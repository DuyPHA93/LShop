<?php

namespace App\Observers;

use App\Models\User;
use App\Models\File;

use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // Remove file and file in database
        $this->removeFile($user->files->first());
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    private function removeFile($file) {
        if (empty($file)) {
            return;
        }

        // Remove old file
        if (Storage::disk('public')->exists('images/users/'.$file->file_name)) {
            Storage::disk('public')->delete('images/users/'.$file->file_name);
        }

        // Delete file in database
        $file->delete();
    }
}
