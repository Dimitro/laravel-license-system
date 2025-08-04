<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\License;

class LicenseDeactivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_license_can_be_deactivated_with_valid_serial_number()
    {
        $license = License::factory()->create([
            'state' => 1,
        ]);

        $response = $this->postJson('/api/license/deactivate', [
            'serial_number' => $license->serial_number,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('licenses', [
            'id' => $license->id,
            'state' => 0,
        ]);
        $response->assertJsonFragment([
            'id' => $license->id,
            'serial_number' => $license->serial_number,
            'state' => 0,
        ]);
    }

    public function test_deactivation_fails_with_invalid_serial_number_format()
    {
        $response = $this->postJson('/api/license/deactivate', [
            'serial_number' => '123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('serial_number');
    }

    public function test_deactivation_fails_with_invalid_serial_number()
    {
        // DB has random data so we need to generate non-existant serial number
        do {
            $non_existant_serial_number = sprintf('%08d', random_int(10000000, 99999999));
        } while (License::where('serial_number', $non_existant_serial_number)->exists());

        $response = $this->postJson('/api/license/deactivate', [
            'serial_number' => $non_existant_serial_number,
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'License not found',
        ]);
    }

    public function test_deactivation_fails_if_license_not_active()
    {
        $license = License::factory()->create([
            'state' => 0,
        ]);

        $response = $this->postJson('/api/license/deactivate', [
            'serial_number' => $license->serial_number,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'License is not active or already deactivated',
        ]);
    }
}
