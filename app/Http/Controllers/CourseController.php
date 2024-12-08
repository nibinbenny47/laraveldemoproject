<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\campus;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $campuses=campus::all();
        return view('admin.courses.create',compact('campuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' =>'required',
            'campus_id'=>'required|exists:campuses,id',
            'start_date'=>'required',
            'card_img'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category'=>'required',
        ]);
         // Handle the file upload for the course image
        if ($request->hasFile('card_img') && $request->file('card_img')->isValid()) {
            $file = $request->file('card_img');
            
            // Generate a unique filename with current timestamp
            $filename = time().'-'.$file->getClientOriginalName();
            
            // Set the destination path where the file will be stored
            $destinationPath = public_path('uploads/courses');
            
            // Move the file to the destination path
            $file->move($destinationPath, $filename);
            
            // Optionally, store the path in the database
            $filePath = 'uploads/courses/'.$filename;
        } else {
            // Handle case when file upload fails
            return redirect()->back()->with('error', 'Invalid file or file upload failed.');
        }
        Course::create([
            'name' => $validated['name'],
            'campus_id' => $validated['campus_id'],
            'start_date' => $validated['start_date'],
            'card_img' => $filePath ?? null,  // Store the file path in the database
            'category' => $validated['category'],
        ]);
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
