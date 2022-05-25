<?php

namespace App\User\Domain\Observers;

use App\User\Domain\Models\User;
use Illuminate\Support\Arr;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Users\Domain\Models\User $user
     * @return void
     */
//    public function created(User $user)
//    {
//        //
//    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Users\Domain\Models\User $user
     * @return void
     */
//    public function updated(User $user)
//    {
//        if ($user->admin) {
//            $data = Arr::only($user->toArray(), ['name', 'email', 'password', 'phone', 'avatar', 'is_active']);
//            $user->admin()->update($data);
//        }
//    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Users\Domain\Models\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Users\Domain\Models\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Users\Domain\Models\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
