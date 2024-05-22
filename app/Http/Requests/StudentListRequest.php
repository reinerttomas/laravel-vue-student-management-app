<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
}
