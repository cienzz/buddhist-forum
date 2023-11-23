<?php

namespace Database\Factories;

use App\Enums\UserElement;
use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Enums\UserShio;
use App\Enums\UserStatus;
use App\Enums\UserZodiac;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'password' => fake()->password(), //static::$password ??= Hash::make('password'),
            'status' => fake()->randomElement(UserStatus::cases()),
            'roles' => fake()->randomElements(UserRole::cases()),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone_number' => fake()->phoneNumber(),
            'phone_number_verified_at' => now(),
            'gender' => fake()->randomElement(UserGender::cases()),
            'zodiac' => fake()->randomElement(UserZodiac::cases()),
            'shio' => fake()->randomElement(UserShio::cases()),
            'element' => fake()->randomElement(UserElement::cases()),
            'birth_at' => fake()->dateTime(),
            'address' => [
                'city' => fake()->city(),
                'province' => fake()->citySuffix(),
                'country' => fake()->country()
            ]
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'phone_number_verified_at' => null,
        ]);
    }
}
