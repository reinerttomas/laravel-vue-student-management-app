<?php

declare(strict_types=1);

use App\Models\User;

test('students page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/students');

    $response->assertStatus(200);
});
