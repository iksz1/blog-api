<?php

namespace App\Providers;

use App\User;
use App\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\GenericUser;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // $this->registerPolicies();
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);        

        // Gate::define('show-post', function ($user, $post) {
        //     // return $user->id === $post->user_id;
        //     return $post->author->name === 'vasya';
        // });

        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken();
            // dd($request->headers);
            if ($token) {
                $jwt = \explode('.', $token);
                if (\count($jwt) === 3) {
                    $signature = \base64_encode(\hash_hmac('sha256', $jwt[0] . '.' . $jwt[1], env('JWT_KEY'), true));
                    // dd($signature);
                    if (\hash_equals($signature, $jwt[2])) {
                        $data = \json_decode(\base64_decode($jwt[1], true));
                        // dd($data);
                        if ($data) {
                            return User::where('name', $data->name)->first();
                        }
                    }
                }
            }
        });
    }
}
