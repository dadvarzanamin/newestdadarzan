<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * JWT Identifier
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // معمولاً id کاربر
    }

    /**
     * Custom JWT Claims
     */
    public function getJWTCustomClaims()
    {
        return []; // اگر claim خاصی نمی‌خواهی خالی بگذار
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function activeCode()
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function permissionsWithActions()
    {
        $role = $this->role()
            ->with(['permissions' => function ($query) {
                $query->withPivot(['can_view', 'can_insert', 'can_edit', 'can_delete']);
            }])
            ->first();

        if (!$role) return collect();

        return $role->permissions->map(function ($permission) {
            return (object)[
                'slug'       => $permission->slug,
                'can_view'   => (bool)$permission->pivot->can_view,
                'can_insert' => (bool)$permission->pivot->can_insert,
                'can_edit'   => (bool)$permission->pivot->can_edit,
                'can_delete' => (bool)$permission->pivot->can_delete,
            ];
        });
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->contains('name', $role);
        }
        return !!$role->intersect($this->role)->count();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(typeUser::class, 'type_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function activeCodes(): HasMany
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function logs()
    {
        return $this->hasMany(Log_user::class);
    }

    public function lastLogin()
    {
        return $this->hasOne(Log_user::class)
            ->where('action', 'login')
            ->where('status', true)
            ->latestOfMany();
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

}
