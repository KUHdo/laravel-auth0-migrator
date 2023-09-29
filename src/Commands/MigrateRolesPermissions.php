<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Composer\InstalledVersions;
use Illuminate\Console\Command;
use KUHdo\LaravelAuth0Migrator\Auth0Migrator;
use Spatie\Permission\Models\Role;

class MigrateRolesPermissions extends Command
{
    protected $signature = 'auth0:migrate:roles-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize alle roles and permission via management api.';

    /**
     * Execute the console command.
     */
    public function handle(Auth0Migrator $migrator, Role $role): int
    {
        $checkInstalled = InstalledVersions::isInstalled('spatie/permissions');
        throw_if(
            ! $checkInstalled,
            \RuntimeException::class,
            __('Actually this packages only allows migration from \'spatie/permission\' package')
        );

        $count = $role::count();
        $this->output->progressStart($count);

        Role::with('permissions')->cursor()
            ->lazy()
            ->each(function (Role $role) use ($migrator) {
                $migrator->syncRole($role);
                $this->output->progressAdvance();
            });

        $this->output->progressFinish();

        return static::SUCCESS;
    }
}
