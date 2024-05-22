<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class StudentListData extends Data
{
    public function __construct(
        public readonly ?string $search,
    ) {
    }
}
