<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt($this->generateRandomPassword()),
            'remember_token' => Str::random(10),
        ];
    }
    private function generateRandomPassword($length = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        $password = '';

        // Garante que a senha contenha pelo menos um caractere de cada conjunto
        $password .= $this->faker->randomElement(str_split('abcdefghijklmnopqrstuvwxyz'));
        $password .= $this->faker->randomElement(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
        $password .= $this->faker->randomElement(str_split('0123456789'));
        $password .= $this->faker->randomElement(str_split('!@#$%^&*()-_=+'));

        // Adiciona caracteres aleatórios restantes
        for ($i = 0; $i < $length - 4; $i++) {
            $password .= $this->faker->randomElement(str_split($chars));
        }

        return $password;
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
