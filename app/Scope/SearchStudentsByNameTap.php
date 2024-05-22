<?php

declare(strict_types=1);

namespace App\Scope;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;

readonly class SearchStudentsByNameTap
{
    public function __construct(public ?string $value)
    {
    }

    /**
     * @param  Builder<Student>  $query
     */
    public function __invoke(Builder $query): void
    {
        $query->when(
            $this->value, fn (Builder $query, string $value): Builder => $query->where('name', 'ILIKE', '%' . $value . '%')
        );
    }
}
