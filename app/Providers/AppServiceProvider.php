<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Linkvisithistory;
use App\Observers\VisitHistoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::define('admin',function(User $user){
            return $user->is_admin;
         });
         Gate::define('owner',function(User $user){
            return $user->is_owner;
         });
         Gate::define('verified',function(User $user){
            return $user->email_verified_at !== null;
         });

         VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('🔒 Konfirmasi Alamat Email Anda!')
                ->greeting('Hai ' . $notifiable->name . '!')
                ->line('Kami sangat senang Anda bergabung dengan kami. Harap verifikasi email Anda untuk menyelesaikan pendaftaran.')
                ->line('Cukup klik tombol di bawah ini untuk memverifikasi alamat email Anda:')
                ->action('Verifikasi Email Anda', $url)
                ->line('Jika Anda tidak mendaftar di platform kami, Anda bisa mengabaikan pesan ini.')
                ->salutation('Terima kasih atas kepercayaan Anda, Tim Support');
        });
    }
}
