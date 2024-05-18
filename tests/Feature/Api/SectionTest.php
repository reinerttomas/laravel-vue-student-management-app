<?php

declare(strict_types=1);

use App\Models\Classes;

test('can fetch sections by class', function () {
    $class = Classes::factory()->create();

    $this
        ->getJson('/api/sections?class_id=' . $class->id)
        ->assertOk();
});

test('cannot fetch sections without class', function () {
    $this
        ->getJson('/api/sections')
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'class_id' => 'The class id field is required.',
        ]);
});
