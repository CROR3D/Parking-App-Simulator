<?php

use Illuminate\Database\Seeder;
use App\Models\Parking;

class ParkingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Users (izbrisana zadana linija koda 'DB::table('users')->truncate();' zbog problema sa ključevima (users[id] -> user_id))

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

        $parking = Parking::create([
            'name' => 'Foša',
            'city' => 'Zadar',
            'address' => 'Ulica kralja Dmitra Zvonimira 2',
            'slug' => 'zadar-fosa',
            'spots' => '50',
            'image' => 'images/parking/zadar-fosa.jpg',
            'working_time' => '08:00-16:00',
            'price_per_hour' => '4.00',
            'price_of_reservation' => '2.00',
            'price_of_reservation_penalty' => '5.00'
        ]);

        $parking2 = Parking::create([
            'name' => 'Bačvice',
            'city' => 'Split',
            'address' => 'Preradovićevo šetalište',
            'slug' => 'split-bacvice',
            'spots' => '35',
            'image' => 'images/parking/split-bacvice.jpg',
            'working_time' => '07:00-17:30',
            'price_per_hour' => '6.00',
            'price_of_reservation' => '4.00',
            'price_of_reservation_penalty' => '8.00'
        ]);

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
