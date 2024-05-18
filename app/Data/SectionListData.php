<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Classes;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class SectionListData extends Data
{
    public function __construct(
        #[Required]
        #[Exists(Classes::class, 'id')]
        public int $classId
    ) {
    }
}
