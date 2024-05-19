<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * @property-read Student $student
 */
class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                new StringType(),
                new Max(255),
            ],
            'email' => [
                'required',
                new Email(),
                new Unique(
                    table: Student::class,
                    column: 'email',
                    ignore: (string) $this->student->id,
                ),
            ],
            'class_id' => [
                'required',
                new Exists(table: Classes::class, column: 'id'),
            ],
            'section_id' => [
                'required',
                new Exists(table: Section::class, column: 'id'),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'class_id' => 'class',
            'section_id' => 'section',
        ];
    }
}
