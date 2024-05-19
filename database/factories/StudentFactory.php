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
        $class = Classes::factory()->create();
        $section = Section::factory()->create([
            'class_id' => $class->id,
        ]);

        return [
            'class_id' => $class->id,
            'section_id' => $section->id,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
        ];
    }
}
