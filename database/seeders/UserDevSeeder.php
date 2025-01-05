<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserDevSeeder extends Seeder
{
    public function run()
    {
        $role1 = Role::find(1);

        User::updateOrcreate([
		    'email' => 'contato@bredi.com.br',
		], [
            'name' => 'Bredi',
		    'password' => Hash::make('bredi'),
        ])->assignRole($role1);
    }
}
