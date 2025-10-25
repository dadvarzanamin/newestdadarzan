<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('can-access', function ($user, $slug, $action) {
            if ($user->hasRole('superadmin')) return true;

            $permissions = $user->permissionsWithActions();
            $perm = $permissions->first(fn($p) => $p->slug === $slug);

            if (!$perm) return false;

            return match ($action) {
                'view'   => $perm->can_view,
                'insert' => $perm->can_insert,
                'edit'   => $perm->can_edit,
                'delete' => $perm->can_delete,
                default  => false
            };
        });


    }
}
