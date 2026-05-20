<?php

namespace Database\Seeders;

use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Facades\Filament;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = Utils::getFilamentAuthGuard();
        $names = collect();

        $panel = Filament::getPanel('admin');

        foreach ($panel->getResources() as $resource) {
            $entity = str(class_basename($resource))
                ->beforeLast('Resource')
                ->snake('::')
                ->lower()
                ->toString();

            foreach (config('filament-shield.permission_prefixes.resource') as $prefix) {
                $names->push("{$prefix}_{$entity}");
            }
        }

        foreach ($panel->getPages() as $page) {
            $base = class_basename($page);
            if (in_array($base, config('filament-shield.exclude.pages', []), true)) {
                continue;
            }
            $names->push(config('filament-shield.permission_prefixes.page') . '_' . $base);
        }

        foreach ($panel->getWidgets() as $widget) {
            $base = class_basename($widget);
            if (in_array($base, config('filament-shield.exclude.widgets', []), true)) {
                continue;
            }
            $names->push(config('filament-shield.permission_prefixes.widget') . '_' . $base);
        }

        foreach ($names->unique() as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => $guard]);
        }

        $superAdmin = Role::firstOrCreate(
            ['name' => config('filament-shield.super_admin.name', 'super_admin'), 'guard_name' => $guard],
        );
        $superAdmin->syncPermissions(Permission::where('guard_name', $guard)->get());

        Role::firstOrCreate(['name' => 'editor', 'guard_name' => $guard])
            ->syncPermissions(
                Permission::where('guard_name', $guard)
                    ->where(function ($q) {
                        $q->where('name', 'like', 'view\\_%')
                            ->orWhere('name', 'like', 'view\\_any\\_%')
                            ->orWhere('name', 'like', 'create\\_%')
                            ->orWhere('name', 'like', 'update\\_%')
                            ->orWhere('name', 'like', 'page\\_%');
                    })
                    ->get(),
            );

        Role::firstOrCreate(['name' => 'viewer', 'guard_name' => $guard])
            ->syncPermissions(
                Permission::where('guard_name', $guard)
                    ->where(function ($q) {
                        $q->where('name', 'like', 'view\\_%')
                            ->orWhere('name', 'like', 'view\\_any\\_%');
                    })
                    ->get(),
            );

        if ($firstUser = User::query()->orderBy('id')->first()) {
            if (! $firstUser->hasRole($superAdmin)) {
                $firstUser->assignRole($superAdmin);
                $this->command->info("Assigned super_admin to {$firstUser->email}.");
            }
        }

        $this->command->info('Shield permissions and default roles seeded.');
    }
}
