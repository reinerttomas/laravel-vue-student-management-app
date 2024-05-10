<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(): Response
    {
        $students = StudentResource::collection(Student::paginate(10));

        return Inertia::render('Student/Index', [
            'students' => $students,
        ]);
    }

    public function create(): Response
    {
        $classes = Classes::all();

        return Inertia::render('Student/Create', [
            'classes' => $classes,
        ]);
    }
}
