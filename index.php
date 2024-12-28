<?php

use Faker\Factory as FakerFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

require 'vendor/autoload.php';

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => 'database/database.sqlite', // Use SQLite in-memory database for testing
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

Factory::guessFactoryNamesUsing(fn (string $modelName) => $modelName.'Factory');

// Define the CustomerFactory
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $faker = FakerFactory::create('en_US'); // Set appropriate locale

        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'phone' => $faker->phoneNumber(),
        ];
    }
}

// Define the Customer model
class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $guarded = [];

    /*protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }*/
}

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 Customer instances
        $customer = Customer::factory(10)->create();
    }
}

if (Capsule::connection()->getDriverName() === 'sqlite') {
    // check if the database file exists
    if (! file_exists('database/database.sqlite')) {
        file_put_contents('database/database.sqlite', '', FILE_APPEND);
    }

    if (Capsule::schema()->hasTable('customers')) {
        Capsule::schema()->drop('customers');
    }

    // Create an SQLite schema (for testing)
    Capsule::schema()->create('customers', function ($table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone');
        $table->timestamps();
    });

    seedDatabaseUsing([new CustomerSeeder, 'run']);
}

function seedDatabaseUsing(array|callable $seeder): void
{
    call_user_func($seeder);
}

$customer = Customer::find(1);

// Output the customer
dump($customer->attributesToArray(), Customer::count());

function parseAlgerianID($id): false|array
{
    // Check if the ID is exactly 18 characters long
    if (strlen($id) !== 18) {
        return false;
    }

    // Extract the parts of the ID
    $sexCode = substr($id, 0, 2);
    $yearOfBirth = substr($id, 2, 3);
    $communeOfBirth = substr($id, 5, 4);
    $civilStateRegistryID = substr($id, 9, 5);
    $registryID = substr($id, 14, 4);

    // Validate sex code (10 for men and 11 for women)
    $sex = '';
    if ($sexCode === '10') {
        $sex = 'male';
    } elseif ($sexCode === '11') {
        $sex = 'female';
    } else {
        return false;
    }

    // Validate year of birth (assuming any 3-digit year is valid)
    if (! preg_match('/^\d{3}$/', $yearOfBirth)) {
        return false;
    } else {
        // Parse year of birth
        if ($yearOfBirth[0] == '9') {
            $parsedYearOfBirth = (int) ('19'.substr($yearOfBirth, 1, 2));
        } else {
            $parsedYearOfBirth = (int) ('20'.substr($yearOfBirth, 1, 2));
        }
    }

    // Validate commune of birth (must be 4 digits)
    if (! preg_match('/^\d{4}$/', $communeOfBirth)) {
        return false;
    }

    // Validate civil state registry ID (must be 5 digits)
    if (! preg_match('/^\d{5}$/', $civilStateRegistryID)) {
        return false;
    }

    // Validate registry ID (must be 4 digits)
    if (! preg_match('/^\d{4}$/', $registryID)) {
        return false;
    }

    return [
        'sex' => $sex,
        'year_of_birth' => $parsedYearOfBirth,
        'commune_of_birth' => $communeOfBirth,
        'civil_state_registry_id' => $civilStateRegistryID,
        'registry_id' => $registryID,
    ];
}

// Example usage
$id = '109941329027780009'; // Replace with actual ID for testing
$parsedID = parseAlgerianID($id);

if ($parsedID) {
    echo "The ID is valid.\n";
    echo 'Sex: '.$parsedID['sex']."\n";
    echo 'Year of Birth: '.$parsedID['year_of_birth']."\n";
    echo 'Commune of Birth: '.$parsedID['commune_of_birth']."\n";
    echo 'Civil State Registry ID: '.$parsedID['civil_state_registry_id']."\n";
    echo 'Registry ID: '.$parsedID['registry_id']."\n";
} else {
    echo 'The ID is invalid.';
}

dump($parsedID);
