<?php

declare(strict_types=1);

use App\Models\Classes;

use function Pest\Laravel\getJson;

test('can fetch sections by class', function () {
    $class = Classes::factory()->create();

    $response = getJson('/api/sections?classId=' . $class->id);
    $response->assertStatus(200);
});
