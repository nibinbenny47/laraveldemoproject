<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\campus;
use App\Models\Delivery;
use App\Models\Funding;
use App\Models\AdditionalDetail;
use Illuminate\Http\Request;
use DB;
use Log;
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
    public function fetchcampus(){
        // Assuming you have a method to fetch all campuses
        // $campuses = $this->fetchCampuses();
        $campuses = campus::all();
        return response()->json($campuses);
    }
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
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required',
            'campus_id' => 'required|exists:campuses,id',
            'start_date' => 'required',
            'card_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required',
            'deliveries' => 'required|array|min:1',
            'deliveries.*.name' => 'required|string|max:255',
            'deliveries.*.slug' => 'required|string|max:255|unique:deliveries,slug',
            'careers' => 'required|array|min:1',
            'careers.*.name' => 'required|string|max:100',
            'fundings' => 'required|array|min:1',
            'fundings.*.campus_id' => 'required|exists:campuses,id',
            'fundings.*.fees' => 'required|numeric|min:0',
            'fundings.*.additional_details' => 'nullable|array',
            'fundings.*.additional_details.*.details' => 'nullable|string',
        ]);

        try {
            // Begin database transaction
            DB::beginTransaction();

            // Handle the file upload for the course image
            if ($request->hasFile('card_img') && $request->file('card_img')->isValid()) {
                $file = $request->file('card_img');
                $filename = time() . '-' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/courses');
                $file->move($destinationPath, $filename);
                $filePath = 'uploads/courses/' . $filename;
            } else {
                return redirect()->back()->with('error', 'Invalid file or file upload failed.');
            }

            // Create the course
            $course = Course::create([
                'name' => $validated['name'],
                'campus_id' => $validated['campus_id'],
                'start_date' => $validated['start_date'],
                'card_img' => $filePath ?? null,
                'category' => $validated['category'],
            ]);

            // Add deliveries
            foreach ($validated['deliveries'] as $delivery) {
                $course->deliveries()->create([
                    'name' => $delivery['name'],
                    'slug' => $delivery['slug'],
                ]);
            }

            // Add careers
            foreach ($validated['careers'] as $career) {
                $course->career()->create([
                    'name' => $career['name'],
                ]);
            }

            // Add fundings
            foreach ($validated['fundings'] as $fundingData) {
                $funding = $course->fundings()->create([
                    'campus_id' => $fundingData['campus_id'],
                    'fees' => $fundingData['fees'],
                ]);

                if (!empty($fundingData['additional_details'])) {
                    foreach ($fundingData['additional_details'] as $detail) {
                        $funding->additionalDetails()->create([
                            'details' => $detail['details'],
                        ]);
                    }
                }
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('courses.index')->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            // Rollback transaction in case of error

            DB::rollBack();

            // Log the error with a stack trace for debugging
            Log::error('Course creation failed: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return the error message
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
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
