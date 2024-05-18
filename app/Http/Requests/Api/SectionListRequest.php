<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SectionListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
