<?php
namespace App\Providers;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Video;
use App\Policies\ChannelPolicy;
use App\Policies\CommentPolicy;
use App\Policies\VideoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Channel::class => ChannelPolicy::class,
        Comment::class => CommentPolicy::class,
        Video::class => VideoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
