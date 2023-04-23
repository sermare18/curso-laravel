<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Definimos la 'puerta' para mostrar un contacto, esta puerta será llmada desde el método show de ContactController
        // Gate::define('show-contact', function (User $user, Contact $contact) {
        //     return $user->id === $contact->user_id;
        // });
    }
}
