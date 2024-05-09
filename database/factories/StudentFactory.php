<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => Classes::factory(),
            'section_id' => Section::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];
    }
}
