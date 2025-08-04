<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\License;

class LicenseActivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_license_can_be_activated_with_valid_key()
    {
        $license = License::factory()->create([
            'state' => 0,
        ]);

        $response = $this->postJson('/api/license/activate', [
            'key' => $license->key,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('licenses', [
            'id' => $license->id,
            'state' => 1,
        ]);
        $response->assertJsonFragment([
            'id' => $license->id,
            'key' => $license->key,
            'state' => 1,
        ]);
    }

    public function test_activation_fails_with_invalid_key_format()
    {
        $response = $this->postJson('/api/license/activate', [
            'key' => '123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('key');
    }

    public function test_activation_fails_with_invalid_key()
    {
        $response = $this->postJson('/api/license/activate', [
            // We need a key with a valid format (39 characters) to test activation fail
            'key' => 'THE-CODE-IS-THIRTY-NINE-CHARACTERS-LONG',
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'License key not found',
        ]);
    }

    public function test_activation_fails_if_already_active()
    {
        $license = License::factory()->create([
            'state' => 1,
        ]);

        $response = $this->postJson('/api/license/activate', [
            'key' => $license->key,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'License key was already activated',
        ]);
    }
}
