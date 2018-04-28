<?php

use Illuminate\Database\Seeder;

class SentinelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Users (izbrisana zadana linija koda 'truncate users table' zbog problema sa ključevima (users[id] -> user_id))

        $admin = Sentinel::getUserRepository()->create(array(
            'email'    => 'admin@admin.com',
            'password' => 'password',
            'username' => 'adminator'
        ));

        $user = Sentinel::getUserRepository()->create(array(
            'email'    => 'user@user.com',
            'password' => 'password',
            'username' => 'jimmy'
        ));

        // Create Activations
        DB::table('activations')->truncate();
        $code = Activation::create($admin)->code;
        Activation::complete($admin, $code);
        $code = Activation::create($user)->code;
        Activation::complete($user, $code);

        // Create Roles
        $administratorRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Administrator',
            'slug' => 'administrator',
            'permissions' => array(
                'users.create' => true,
                'users.update' => true,
                'users.view' => true,
                'users.destroy' => true,
                'roles.create' => true,
                'roles.update' => true,
                'roles.view' => true,
                'roles.delete' => true
            )
        ));
        $moderatorRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Moderator',
            'slug' => 'moderator',
            'permissions' => array(
                'users.update' => true,
                'users.view' => true,
            )
        ));
        $subscriberRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Subscriber',
            'slug' => 'subscriber',
            'permissions' => array()
        ));

        // Assign Roles to Users
        $administratorRole->users()->attach($admin);
        $subscriberRole->users()->attach($user);
    }
}
