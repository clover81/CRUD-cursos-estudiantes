<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Incluye el curso asociado para pintar en Vue
        return response()->json(
            Student::with('course')->orderBy('id', 'desc')->get(),
            200
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'course_id' => ['required', 'integer', 'exists:courses,id'],
        ]);

        $student = Student::create($data);

        return response()->json($student->load('course'), 201);
    }

    public function show(Student $student)
    {
        return response()->json($student->load('course'), 200);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,' . $student->id],
            'course_id' => ['required', 'integer', 'exists:courses,id'],
        ]);

        $student->update($data);

        return response()->json($student->load('course'), 200);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(null, 204);
    }
}
