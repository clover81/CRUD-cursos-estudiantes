<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CourseController extends Controller
{
    public function index()
{
    return response()->json(
        Course::withCount('students')->orderBy('id', 'desc')->get(),
        200
    );
}


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $course = Course::create($data);

        return response()->json($course, 201);
    }

    public function show(Course $course)
    {
    return response()->json(
        $course->loadCount('students'),
        200
    );
    }


    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $course->update($data);

        return response()->json($course, 200);
    }



public function destroy(Course $course)
{
    // Bloqueo a nivel de aplicación: Verificar si el curso tiene estudiantes antes de intentar eliminarlo
    if ($course->students()->exists()) {
        return response()->json([
            'message' => 'No se puede eliminar el curso porque tiene estudiantes asociados.'
        ], 409);
    }

    try {
        $course->delete();
        return response()->json(null, 204);
    } catch (QueryException $e) {
        // Bloqueo por integridad referencial (por si ocurre igualmente)
        return response()->json([
            'message' => 'No se puede eliminar el curso porque tiene estudiantes asociados.'
        ], 409);
    }
}
}
