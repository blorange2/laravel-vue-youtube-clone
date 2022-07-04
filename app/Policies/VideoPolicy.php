<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User                      $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User                      $user
     * @param  \App\Models\Video                     $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Video $video)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User                      $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User                      $user
     * @param  \App\Models\Video                     $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Video $video)
    {
        if ($user->id === $video->channel->user_id) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User                      $user
     * @param  \App\Models\Video                     $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Video $video)
    {
        if ($user->id === $video->channel->user_id) {
            return true;
        }
    }

    /**
     * Determine whether the user can vote on the model.
     *
     * @param  \App\Models\User                      $user
     * @param  \App\Models\Video                     $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function vote(User $user, Video $video)
    {
        if (!$video->canBeAccessed($user)) {
            return false;
        }

        if (!$video->votesAllowed()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can vote on the model.
     *
     * @param  \App\Models\User                      $user
     * @param  \App\Models\Video                     $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function comment(User $user, Video $video)
    {
        if (!$video->canBeAccessed($user)) {
            return false;
        }

        if (!$video->commentsAllowed()) {
            return false;
        }

        return true;
    }
}
