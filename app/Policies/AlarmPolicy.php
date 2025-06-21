<?php

namespace App\Policies;

use App\Models\Alarm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlarmPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alarm  $alarm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Alarm $alarm)
    {
        return $user->id === $alarm->baby->user_id;
    }
} 