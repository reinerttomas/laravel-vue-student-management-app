<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\StoreStudentData;
use App\Data\StudentListData;
use App\Data\UpdateStudentData;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use App\Scope\SearchStudentsByNameTap;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(StudentListData $data): Response
    {
        $query = Student::query()->tap(new SearchStudentsByNameTap($data->search));

        return Inertia::render('Student/Index', [
            'students' => StudentResource::collection($query->paginate(10)),
            'search' => $data->search ?: '',
        ]);
    }

    public function create(): Response
    {
        $classes = ClassesResource::collection(Classes::all());

        return Inertia::render('Student/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreStudentData $data): RedirectResponse
    {
        Student::create($data->all());

        return redirect()->route('students.index');
    }

    public function edit(Student $student): Response
    {
        $classes = ClassesResource::collection(Classes::all());

        return Inertia::render('Student/Edit', [
            'student' => StudentResource::make($student),
            'classes' => $classes,
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update(UpdateStudentData::from($request)->all());

        return redirect()->route('students.index');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index');
    }
}
