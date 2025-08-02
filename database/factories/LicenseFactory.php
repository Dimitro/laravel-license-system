<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\License;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\License>
 */
class LicenseFactory extends Factory
{
    protected $model = License::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->generateKey(),
            'serial_number' => $this->generateSerialNumber(),
            'name' => '',
            'quantity' => fake()->numberBetween(1, 10),
            'state' => 0,
            'type' => fake()->randomElement(['server', 'user', 'module']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        // Update name to LicenseN, where N is id of the record
        return $this->afterCreating(function (License $license) {
            $license->name = 'License' . $license->id;
            $license->save();
        });
    }

    private function generateKey(): string
    {
        // Ensure that key is unique
        do {
            $key = strtoupper(fake()->bothify('****-****-****-****-****-****-****-****'));
        } while (License::where('key', $key)->exists());
        
        return $key;
    }

    private function generateSerialNumber() : string
    {
        // Ensure that serial number is unique
        do {
            $serial_number = fake()->numerify('########');
        } while (License::where('serial_number', $serial_number)->exists());
        
        return $serial_number;
    }
}
