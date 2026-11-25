<?php

namespace App\Models;

use App\HasLogActivity;
use App\Services\LogService;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Represent application users, casts, search scope, and role audit logging.
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasLogActivity, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Apply the search filter to the user query.
     *
     * @param  Builder<static>  $query
     */
    #[Scope]
    public function search(Builder $query, string $searchQuery): void
    {
        $query->whereAny(['name'], 'like', '%'.$searchQuery.'%');
    }

    /**
     * Synchronize the user's single role and record any changes in the audit log.
     */
    public function syncRoleWithLog(int|string|Role $role): static
    {
        $oldRole = $this->roles()->value('name');

        $this->syncRoles($role);

        $newRole = $this->roles()->value('name');

        if ($oldRole !== $newRole) {
            app(LogService::class)->log(
                event: "{$this->getMorphClass()}.role_updated",
                description: 'User Role Updated',
                subject: $this,
                diff: [
                    'role' => [
                        'old' => $oldRole,
                        'new' => $newRole,
                    ],
                ],
                logName: $this->getLogName(),
            );
        }

        return $this;
    }
}
