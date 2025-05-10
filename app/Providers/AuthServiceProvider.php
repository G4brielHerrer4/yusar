<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate para administradores
        Gate::define('admin', function ($user) {
            return $user->rol->nombre === 'Administrador'; // Acceder al nombre del rol a través de la relación
        });

        // Gate para vendedores
        Gate::define('vendedor', function ($user) {
            return $user->rol->nombre === 'Vendedor'; // Acceder al nombre del rol a través de la relación
        });


        // Gate para responsables
        Gate::define('responsable', function ($user) {
            return $user->rol->nombre === 'Responsable'; // Acceder al nombre del rol a través de la relación
        });
    }
}
