<?php

namespace App\Notifications;

use App\Models\NomineeApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(NomineeApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $applicationUrl = route('user.applications.show', $this->application->id);
        $isFreeApplication = (bool) ($this->application->category->is_free ?? false)
            || (float) ($this->application->category->nomination_fee ?? 0) <= 0
            || $this->application->status === \App\Models\NomineeApplication::STATUS_PENDING_REVIEW;

        $mail = (new MailMessage)
            ->subject('Ombi Lako la Ushiriki Limepokelewa')
            ->greeting('Habari ' . $this->application->applicant_name . ',')
            ->line('Asante kwa kuwasilisha ombi lako la kushiriki katika tuzo za ' . config('app.name') . ' kwenye kategoria ya "' . $this->application->category->name . '".');

        if ($isFreeApplication) {
            $mail->line('Ombi lako ni la kategoria ya bure, hivyo halihitaji malipo.')
                ->line('Timu yetu italipitia ombi lako na utapata mrejesho kupitia akaunti yako.');
        } else {
            $mail->line('Ujumbe wa kufanya malipo umetuumwa kwenye namba yako ya simu. Tafadhali kamilisha malipo ili ombi lako liweze kupitiwa.');
        }

        return $mail
            ->line('Unaweza kufuatilia hali ya ombi lako kupitia akaunti yako.')
            ->action('Fuatilia Ombi Lako', $applicationUrl)
            ->line('Asante kwa kushiriki!');
    }
}
