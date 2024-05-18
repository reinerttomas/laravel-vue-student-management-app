<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Data\SectionListData;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;

use function response;

class SectionController extends Controller
{
    public function __invoke(SectionListData $data): JsonResponse
    {
        $sections = Section::where('class_id', $data->classId)->get();

        return response()->json(SectionResource::collection($sections));
    }
}
