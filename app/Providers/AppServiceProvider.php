<?php

namespace App\Providers;

use App\Models\User;
use Filament\Notifications\Auth\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // VerifyEmail::createUrlUsing(function (object $notifiable) {
        //     $verifyUrl = URL::temporarySignedRoute(
        //         'verification.verify',
        //         Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        //         [
        //             'id' => $notifiable->getKey(),
        //             'hash' => sha1($notifiable->getEmailForVerification()),
        //         ]
        //     );

        //     return config('app.frontend_url') . config('app.frontend_verify_route') . "?url={$verifyUrl}";
        // });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return config('app.frontend_url') . config('app.frontend_reset_route') . "?token={$token}";
        });
    }
}
