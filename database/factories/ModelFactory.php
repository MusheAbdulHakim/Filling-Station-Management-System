<?php

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
 * Authentication - Users, Roles, Permissions.
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name(),
        'email'          => $faker->unique()->safeEmail(),
        'password'       => bcrypt(Str::random(10)),
        'remember_token' => Str::random(10),
        'created_at'     => Carbon::now()->subDays(rand(0, 7)),
    ];
});

/*
 * Unit
 */
$factory->define(App\Models\Unit::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->word(),
        'value'          => $faker->randomFloat(),
    ];
});

/*
 * Product 
 */
$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word(),
        'unit_id' => function () {
            if (rand(1, 100) % 50 == 0) {
                return factory(app\Models\Unit::class)->create()->id;
            } else {
                return rand(1, 10);
            }
        },
        'cost_price' => $faker->randomFloat(),
        'sale_price' => $faker->randomFloat(),
    ];
});

/*
 * Supplier
 */
$factory->define(App\Models\Supplier::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name(),
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $faker->phoneNumber(),
        'address'        => $faker->address(),
        'comment'        => $faker->paragraph(),
    ];
});

/*
 * Purchase
 */
$factory->define(App\Models\Purchase::class, function (Faker\Generator $faker) {
    return [
        'product_id' => factory(App\Models\Product::class)->create(),
        'supplier_id' => factory(App\Models\Supplier::class)->create(),
        'quantity' => $faker->randomNumber(2),
        'comment' => $faker->paragraph(),
    ];
});
