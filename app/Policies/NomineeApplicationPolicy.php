<?php

namespace App\Policies;

use App\Models\NomineeApplication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NomineeApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NomineeApplication $nomineeApplication): bool
    {
        return $user->id === $nomineeApplication->user_id;
    }

    /**
     * Determine whether the user can create models.
     * BORESHO: Kuruhusu mtumiaji kuanzisha maombi mapya hata kama
     * ana maombi mengine yanayosubiri malipo. Hii inasaidia kama
     * kuna shida ya mtandao na anataka kuanza upya.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NomineeApplication $nomineeApplication): bool
    {
        return $user->id === $nomineeApplication->user_id;
    }

    /**
     * Determine whether the user can retry payment for the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\NomineeApplication  $nomineeApplication
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function retryPayment(User $user, NomineeApplication $application): bool
    {
        // Mtumiaji anaweza kujaribu kulipa tena kama ombi ni lake.
        return $user->id === $application->user_id;
    }
}
