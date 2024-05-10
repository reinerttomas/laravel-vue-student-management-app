<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(): Response
    {
        $students = StudentResource::collection(Student::all());

        return Inertia::render('Student/Index', [
            'students' => $students,
        ]);
    }
}
