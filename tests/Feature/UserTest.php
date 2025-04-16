<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // Test creating a user
    public function test_user_can_be_created()
    {
        Storage::fake('public');

        $data = [
            'name'                  => 'John',
            'surname'               => 'Doe',
            'email'                 => 'john@example.com',
            'phone'                 => '123456789',
            'country'               => 'Pakistan',
            'gender'                => 'male',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
            'profile_image'         => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(201)->assertJsonFragment(['email' => 'john@example.com']);
        Storage::disk('public')->assertExists('profile_images/' . basename($response['profile_image']));
    }

    // Test fetching the user details
    public function test_user_can_be_fetched()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");
        $response->assertStatus(200)->assertJsonFragment(['email' => $user->email]);
    }

    // Test updating a user
    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name'                  => 'Updated',
            'surname'               => $user->surname,
            'email'                 => $user->email,
            'phone'                 => $user->phone,
            'country'               => $user->country,
            'gender'                => $user->gender,
            'password'              => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated']);
    }

    // Test deleting a user
    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)->assertJson(['message' => 'User deleted']);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
