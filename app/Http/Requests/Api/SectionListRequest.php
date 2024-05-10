<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Classes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $class_id
 */
class SectionListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'class_id' => ['required', Rule::exists(Classes::class, 'id')],
        ];
    }
}
