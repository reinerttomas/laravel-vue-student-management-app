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
    Classes::factory()
        ->count(3)
        ->create();

    $user = User::factory()->create();

    $this
        ->actingAs($user)
        ->get('/students/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Student/Create')
            ->has('classes', fn (Assert $page) => $page
                ->has('data', 3, fn (Assert $page) => $page
                    ->has('id')
                    ->has('name')
                )
            )
        );
});

test('cannot show student create page when user not authenticated', function () {
    $this
        ->get('/students/create')
        ->assertRedirectToRoute('login');
});

test('can create student', function () {
    $user = User::factory()->create();
    $student = Student::factory()->raw();

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

test('can show student edit page', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $this
        ->actingAs($user)
        ->get("/students/$student->id/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Student/Edit')
            ->has('student', fn (Assert $page) => $page
                ->has('data', fn (Assert $page) => $page
                    ->where('id', $student->id)
                    ->where('name', $student->name)
                    ->where('email', $student->email)
                    ->has('class', fn (Assert $page) => $page
                        ->where('id', $student->class->id)
                        ->where('name', $student->class->name)
                    )
                    ->has('section', fn (Assert $page) => $page
                        ->where('id', $student->section->id)
                        ->where('name', $student->section->name)
                    )
                    ->etc()
                )
            )
            ->has('classes', fn (Assert $page) => $page
                ->has('data', 1, fn (Assert $page) => $page
                    ->has('id')
                    ->has('name')
                )
            )
        );
});

test('cannot show student edit page when user not authenticated', function () {
    $student = Student::factory()->create();

    $this
        ->get("/students/$student->id/edit")
        ->assertRedirectToRoute('login');
});

test('can update student', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $sectionForUpdate = Section::factory()->create();
    $dataForUpdate = [
        'name' => 'student',
        'email' => 'student@example.com',
        'class_id' => $sectionForUpdate->class_id,
        'section_id' => $sectionForUpdate->id,
    ];

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->put(route('students.update', $student->id), $dataForUpdate)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('errors', [])
        );

    $this->assertDatabaseCount(Student::class, 1);
    $this->assertDatabaseHas(Student::class, $dataForUpdate);
});

test('can delete student', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();

    $this->assertDatabaseCount(Student::class, 1);
    $this->assertDatabaseHas(Student::class, $student->toArray());

    $this
        ->followingRedirects()
        ->actingAs($user)
        ->delete(route('students.destroy', $student->id))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Student/Index'));

    $this->assertDatabaseCount(Student::class, 0);
});
