<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Classes;
use App\Models\Section;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class StoreStudentData extends Data
{
    public function __construct(
        #[Max(255)]
        public readonly string $name,
        #[Email, Max(255)]
        public readonly string $email,
        #[Exists(table: Classes::class, column: 'id')]
        public readonly int $class_id,
        #[Exists(table: Section::class, column: 'id')]
        public readonly int $section_id,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public static function attributes(): array
    {
        return [
            'class_id' => 'class',
            'section_id' => 'section',
        ];
    }
}
