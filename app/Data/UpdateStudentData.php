<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class UpdateStudentData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly int $class_id,
        public readonly int $section_id,
    ) {
    }
}
