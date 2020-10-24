<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->FirstName ='Admin';
        $user->LastName ='Admin';
        $user->Email ='admin@admin.com';
        $user->Password = Hash::make('admin');
        $user->AccessRights = '1';
        $user->save();

        $user = new User;
        $user->FirstName ='Juan';
        $user->LastName ='Dela Cruz';
        $user->Email ='user@user.com';
        $user->Password = Hash::make('user');
        $user->AccessRights = '2';
        $user->save();
    }
}
