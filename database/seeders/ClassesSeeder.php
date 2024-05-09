<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
        Classes::factory()
            ->count(10)
            ->sequence(fn ($sequence): array => ['name' => 'Class ' . $sequence->index + 1])
            ->has(
                Section::factory()
                    ->count(2)
                    ->state(
                        new Sequence(
                            ['name' => 'Section A'],
                            ['name' => 'Section B'],
                        )
                    )
                    ->has(
                        Student::factory()
                            ->count(5)
                            ->state(
                                fn (array $attributes, Section $section): array => ['class_id' => $section->class_id]
                            )
                    )
            )
            ->create();
    }
}
