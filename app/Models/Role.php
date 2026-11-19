<?php

namespace App\Models;

use App\HasLogActivity;
use App\Services\LogService;
use BackedEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Application role model extending Spatie's Role with audit trail logging.
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Permission> $permissions
 * @property-read Collection<int, User> $users
 */
class Role extends SpatieRole
{
    use HasLogActivity;

    /**
     * The attributes that should be tracked in the audit log.
     *
     * Explicitly defined because Spatie's Role model uses `$guarded` instead of `$fillable`.
     *
     * @var list<string>
     */
    protected array $loggable = [
        'name',
        'guard_name',
    ];

    /**
     * The logical log channel name for role audit entries.
     */
    protected string $logName = 'role';

    /**
     * Synchronize the role's permissions and record any changes in the audit log.
     *
     * @param  array<int, string|int|PermissionContract|BackedEnum>  $permissions
     */
    public function syncPermissionsWithLog(array $permissions): void
    {
        /** @var list<string> $oldPermissions */
        $oldPermissions = $this->permissions()->pluck('name')->sort()->values()->all();

        $this->syncPermissions($permissions);

        /** @var list<string> $newPermissions */
        $newPermissions = $this->permissions()->pluck('name')->sort()->values()->all();

        if ($oldPermissions !== $newPermissions) {
            app(LogService::class)->log(
                event: "{$this->getMorphClass()}.permissions_updated",
                description: 'Role Permissions Updated',
                subject: $this,
                diff: [
                    'permissions' => [
                        'old' => $oldPermissions,
                        'new' => $newPermissions,
                    ],
                ],
                logName: $this->getLogName(),
            );
        }
    }
}
