<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    private const TOTAL_CACHE_KEY = 'site:visitor_total_count';
    private const ONLINE_CACHE_KEY = 'site:visitor_online_sessions';
    private const TODAY_CACHE_KEY = 'site:visitor_today_count';
    private const TODAY_DATE_CACHE_KEY = 'site:visitor_today_date';
    private const TOTAL_SESSION_KEY = 'site:visitor_total_counted';
    private const TODAY_SESSION_DATE_KEY = 'site:visitor_today_counted_date';
    private const ONLINE_WINDOW_SECONDS = 300;

    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->isMethod('GET') &&
            ! $request->is('admin/*') &&
            ! $request->is('api/*')
        ) {
            $sessionId = $request->session()->getId();
            $now = now();
            $today = $now->toDateString();

            $this->trackOnlineVisitors($sessionId, $now->timestamp);
            $this->trackTodayVisitors($request, $today);
            $this->trackTotalVisitors($request);
        }

        return $next($request);
    }

  public static function stats(): array
{
    $today = now()->toDateString();
    $currentMonth = now()->format('Y-m');

    $storedDate = Cache::get(self::TODAY_DATE_CACHE_KEY);
    $todayCount = $storedDate === $today ? (int) Cache::get(self::TODAY_CACHE_KEY, 0) : 0;

    $monthlyKey = 'site:visitor_month_count:' . $currentMonth;
    $monthCount = (int) Cache::get($monthlyKey, 0);

    $onlineSessions = Cache::get(self::ONLINE_CACHE_KEY, []);
    $onlineCount = is_array($onlineSessions) ? count($onlineSessions) : 0;

    return [
        'online' => $onlineCount,
        'today' => $todayCount,
        'month' => $monthCount,
        'total' => (int) Cache::get(self::TOTAL_CACHE_KEY, 0),
    ];
}

private function trackTotalVisitors(Request $request): void
{
    if (! $request->session()->has(self::TOTAL_SESSION_KEY)) {
        Cache::add(self::TOTAL_CACHE_KEY, 0);
        Cache::increment(self::TOTAL_CACHE_KEY);
        $request->session()->put(self::TOTAL_SESSION_KEY, true);
    }

    // Track monthly
    $currentMonth = now()->format('Y-m');
    $monthlyKey = 'site:visitor_month_count:' . $currentMonth;
    if (! $request->session()->has('site:visitor_month_counted:' . $currentMonth)) {
        Cache::add($monthlyKey, 0);
        Cache::increment($monthlyKey);
        $request->session()->put('site:visitor_month_counted:' . $currentMonth, true);
    }
}

    private function trackTodayVisitors(Request $request, string $today): void
    {
        $storedDate = Cache::get(self::TODAY_DATE_CACHE_KEY);

        if ($storedDate !== $today) {
            Cache::forever(self::TODAY_DATE_CACHE_KEY, $today);
            Cache::forever(self::TODAY_CACHE_KEY, 0);
        }

        if ($request->session()->get(self::TODAY_SESSION_DATE_KEY) !== $today) {
            Cache::increment(self::TODAY_CACHE_KEY);
            $request->session()->put(self::TODAY_SESSION_DATE_KEY, $today);
        }
    }

    private function trackOnlineVisitors(string $sessionId, int $currentTimestamp): void
    {
        $onlineSessions = Cache::get(self::ONLINE_CACHE_KEY, []);
        if (! is_array($onlineSessions)) {
            $onlineSessions = [];
        }

        $threshold = $currentTimestamp - self::ONLINE_WINDOW_SECONDS;
        foreach ($onlineSessions as $id => $timestamp) {
            if ((int) $timestamp < $threshold) {
                unset($onlineSessions[$id]);
            }
        }

        $onlineSessions[$sessionId] = $currentTimestamp;
        Cache::forever(self::ONLINE_CACHE_KEY, $onlineSessions);
    }
}
