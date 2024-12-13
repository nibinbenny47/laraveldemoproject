<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teachers = Teacher::all();
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
            'subjects.*.shift' => 'required|string|max:255',
            'subjects.*.subject_name' => 'required|string|max:255',
        ]);

        // Create the teacher
        $teacher = Teacher::create([
            'name' => $validated['name'],
        ]);

        // Create subjects for the teacher
        foreach ($validated['subjects'] as $subject) {
            $teacher->subjects()->create([
                'shift' => $subject['shift'],
                'subject_name' => $subject['subject_name'],
            ]);
        }

        return redirect()->route('teachers.create')->with('success', 'Teacher and subjects added successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
        return view('admin.teachers.edit', compact('teacher'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
            'subjects.*.shift' => 'required|string|max:255',
            'subjects.*.subject_name' => 'required|string|max:255',
            'subjects.*.id' => 'nullable|integer|exists:subjects,id', // Validate existing subject IDs
        ]);

        // Update the teacher's name
        $teacher->update(['name' => $validated['name']]);

        $existingSubjects = $teacher->subjects->keyBy('id'); // Get current subjects indexed by ID

        foreach ($validated['subjects'] as $subjectData) {
            if (isset($subjectData['id'])) {
                // Update existing subject
                if ($existingSubjects->has($subjectData['id'])) {
                    $existingSubjects[$subjectData['id']]->update([
                        'shift' => $subjectData['shift'],
                        'subject_name' => $subjectData['subject_name'],
                    ]);
                    $existingSubjects->forget($subjectData['id']); // Remove from the list of subjects to delete
                }
            } else {
                // Create new subject
                $teacher->subjects()->create([
                    'shift' => $subjectData['shift'],
                    'subject_name' => $subjectData['subject_name'],
                ]);
            }
        }

        // Delete remaining subjects not included in the request
        foreach ($existingSubjects as $subject) {
            $subject->delete();
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher and subjects updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
