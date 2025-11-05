<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      $superAdminUser = User::factory()->create([
            'name' => 'efoodis',
            'email' => 'info@efood.com',
        ]);
       

    
        $routes = collect(Route::getRoutes())
            ->filter(fn($route) => str_starts_with($route->uri(), 'admin'))
            ->map(fn($route) => [
                'name' => $route->getName() ?? $route->uri(),
                'slug' => str_replace('/', '-', $route->uri()),
            ])
            ->unique('slug');

        foreach ($routes as $data) {
            Permission::updateOrCreate(['slug' => $data['slug']], [
                'name' => $data['name'],
            ]);
        }

       
        $superAdminRole = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Admin']
        );

       
        $allPermissions = Permission::pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissions);

       
        $superAdminUser->roles()->sync([$superAdminRole->id]);

        
        $this->call(DemoSeeder::class);
    }
}
