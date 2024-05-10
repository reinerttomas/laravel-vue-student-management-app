<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SectionListRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;

use function response;

class SectionController extends Controller
{
    public function __invoke(SectionListRequest $request): JsonResponse
    {
        $sections = Section::where('class_id', $request->class_id)->get();

        return response()->json(SectionResource::collection($sections));
    }
}
