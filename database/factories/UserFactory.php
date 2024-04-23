<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Faker\Factory as Fakers;
//use File;
//use QrCode;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;
     $cin = $faker->randomElement( $array = array ('M', 'AA', 'E', 'JK', 'Q', 'U', 'D', 'B')) . $faker->unique()->numberBetween(1111,9999) ;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'),
        'remember_token' => Str::random(10),
        'cin'              =>  $cin , 
        'gender'              => $faker->randomElement($array = array ('Homme', 'Femme')),
        'tele'             => $faker->randomNumber(8, false) ,
        'image'             => $faker->randomElement($array = array ('homme.png', 'femme.png')),
        'is_valide'        => $faker->boolean() ,
        'id_user'        => 1
    ];
});


$factory->define(App\Adherent::class, function (Faker $faker) {
     static $password;
     $cin = $faker->randomElement( $array = array ('M', 'AA', 'E', 'JK', 'Q', 'U', 'D', 'B')) . $faker->unique()->numberBetween(1111,9999) ;
     $qr_code = $cin  .'_'. time() ;
     

      /*$image = \QrCode::format('png')
                ->size(500)->errorCorrection('H')
                ->generate($qr_code);

            $output_file = 'public/admin/adherents/qr_code/' . $qr_code . '.png';
            \File::put($output_file, $image);*/

    $name = $faker->name;

     return [
        'code_client'              => strtoupper(substr($name, 0, 2 ) ) . rand(1111, 9999) , //$faker->unique()->numberBetween(1,9999), 
        'qr_code'              =>  $qr_code ,// $faker->unique()->numberBetween(1,99), 
        'cin'              =>  $cin , 
        'gender'              => $faker->randomElement($array = array ('Homme', 'Femme')),
     	'nom'              => $name ,
     	'email'             => $faker->unique()->safeEmail,
     	'password'          => bcrypt('secret'),
        'tele'             => $faker->randomNumber(8, false) ,
		'tele_urgence'             => $faker->randomNumber(8, false) ,
		'date_naiss'             => now() ,
		'image'             =>  $faker->randomElement($array = array ('homme.png', 'femme.png')),
		'is_valide'        => 1, //$faker->boolean() ,
        'id_adherent'        => 1,
		'id_user'        => function () { return App\User::inRandomOrder()->first()->id; },
    ];

});
 
 $factory->define(App\Pack::class, function (Faker $faker)   {
     return [
		'Description'       => 'Pack ' . rand(1,99),  
		'prix'       => rand(150,450),
    ];
});

/*
  $factory->define(App\Message::class, function (Faker $faker)   {
     return [
        'message'       => $faker->realText(rand(80, 200)),
     ];
});*/



$factory->define(App\Abonner::class, function (Faker $faker) {
    static $id_adherent = 1;  
     return [
		'date_debut'        => now() ,
		'date_fin'          => date('Y/m/d', strtotime(date('Y/m/d',strtotime('+'  . rand(1,20) . ' days')))) ,
		'remise'           => rand(5,30),
		'id_adherent'        => $id_adherent++,
		'has_new_abonnement'  => 0, 
		'id_user'        => function () { return App\User::inRandomOrder()->first()->id; },
    ];
});


$factory->define(App\Paiement::class, function (Faker $faker) {
     static $id_abonner = 1;  
     static $id_adherent = 1;  
     return [
        'date_paiement'        => date('Y/m/d', strtotime(date('Y/m/d',strtotime('-'  . rand(1,12) . ' months')))) ,
        'prix'        =>  rand(1,50),
        'id_abonner' =>  $id_abonner++ ,
        'id_adherent' =>  $id_adherent++ ,
        'id_user'        => function () { return App\User::inRandomOrder()->first()->id; },
    ];
});


$factory->define(App\Recharge::class, function (Faker $faker) { 
     return [
        'code_client' => function () { return App\Adherent::inRandomOrder()->first()->code_client; },
        'recharge'    =>  rand(1,50),
        'type'        =>  $faker->randomElement($array = array ('Recharge', 'Parrinage')),
    ];
});



$factory->define(App\Presence::class, function (Faker $faker) {
     static $id_adherent = 1;  
     return [
        'date_entrer'        => now() ,
        'date_sortier'        =>   now() ,
         'id_adherent' =>  $id_adherent++ ,
     ];
});


$factory->define(App\Promotion::class, function (Faker $faker) {
     return [
     	'Description'       => $faker->realText(rand(80, 200)),
     	'remise'       => rand(1,30),
        'date_debut'        => date('Y/m/d', strtotime(date('Y/m/d',strtotime('-'  . rand(1,5) . ' days')))) ,
        'date_fin'        => date('Y/m/d', strtotime(date('Y/m/d',strtotime('+'  . rand(0,5) . ' days')))) ,
        'image'        => 'default.jpg',
        'id_pack'        => function () { return App\Pack::inRandomOrder()->first()->id; },
        'id_user'        => function () { return App\User::inRandomOrder()->first()->id; },
    ];
});