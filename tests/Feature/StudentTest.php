<?php

declare(strict_types=1);

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('can show students page', function () {
    $user = User::factory()->create();

    $this
        ->actingAs($user)
        ->get('/students')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Student/Index'));
});

test('cannot show students page when user not authenticated', function () {
    $this
        ->get('/students')
        ->assertRedirectToRoute('login');
});

test('can show student create page', function () {
    $user = User::factory()->create();

    $this
        ->actingAs($user)
        ->get('/students/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Student/Create'));
});

test('cannot show student create page when user not authenticated', function () {
    $this
        ->get('/students/create')
        ->assertRedirectToRoute('login');
});

test('can create student', function () {
    $user = User::factory()->create();
    $class = Classes::factory()->create();
    $section = Section::factory()->create([
        'class_id' => $class->id,
    ]);

    $student = Student::factory()->raw([
        'class_id' => $class->id,
        'section_id' => $section->id,
    ]);

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->post(route('students.store'), $student)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('errors', [])
        );

    $this->assertDatabaseCount(Student::class, 1);
    $this->assertDatabaseHas(Student::class, $student);
});

test('cannot create student when required fields not provided', function () {
    $user = User::factory()->create();

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->post(route('students.store'), [])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('errors.name', 'The name field is required.')
            ->where('errors.email', 'The email field is required.')
            ->where('errors.class_id', 'The class field is required.')
            ->where('errors.section_id', 'The section field is required.')
        );

    $this->assertDatabaseCount(Student::class, 0);
});
