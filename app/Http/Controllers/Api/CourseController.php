<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use App\Models\Course;
use App\Models\campus;
use App\Models\Delivery;
use App\Models\Funding;
use App\Models\AdditionalDetail;
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
        $courses = Course::with('deliveries', 'career', 'fundings')->get();

        // Return the courses as JSON
        return response()->json($courses);
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'certificate' => 'required|string',
            'campus_id' => 'required|exists:campuses,id',
            'start_date' => 'required|date',
            'card_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|max:100',
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
                return response()->json(['error' => 'Invalid file or file upload failed.'], 400);
            }

            // Create the course
            $course = Course::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'certificate' => $validated['certificate'],
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

            return response()->json([
                'message' => 'Course created successfully!',
                'data' => $course->load('deliveries', 'career', 'fundings.additionalDetails'),
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            // Log the error with a stack trace for debugging
            Log::error('Course creation failed: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return the error message
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch the course by ID with related models
        $course = Course::with('deliveries', 'career', 'fundings.campus')->find($id);

        // If course is not found, return a 404 response
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Format the funding data as requested
        $formattedFundings = $course->fundings->map(function($funding) {
            $campusName = $funding->campus->name;  // Assuming 'name' is the campus field
            return [
                $campusName => [
                    'fees' => $funding->fees,
                    'additional_details' => $funding->additionalDetails->map(function($detail) {
                        return $detail->details;
                    }),
                ]
            ];
        });

        // Return the course with formatted funding data
        return response()->json([
            'id' => $course->id,
            'name' => $course->name,
            'code' => $course->code,
            'certificate' => $course->certificate,
            'campus_id' => $course->campus_id,
            'start_date' => $course->start_date,
            'category' => $course->category,
            'card_img' => $course->card_img,
            'deliveries' => $course->deliveries,
            'careers' => $course->career,
            'fundings' => $formattedFundings,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search(Request $request)
    {
        $query = Course::query();

        // Search by ID if provided
        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }

        // Search by other fields dynamically
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('code')) {
            $query->where('code', 'like', '%' . $request->input('code') . '%');
        }

        if ($request->has('category')) {
            $query->where('category', 'like', '%' . $request->input('category') . '%');
        }

        if ($request->has('campus_id')) {
            $query->where('campus_id', $request->input('campus_id'));
        }

        if ($request->has('start_date')) {
            $query->whereDate('start_date', '=', $request->input('start_date'));
        }

        // Execute the query and fetch results
        $courses = $query->get();

        if ($courses->isEmpty()) {
            return response()->json(['message' => 'No courses found matching the criteria'], 404);
        }

        // Format the funding section if required
        // $formattedCourses = $courses->map(function ($course) {
        //     $course->fundings = $course->fundings->mapWithKeys(function ($funding) {
        //         $campusName = Campus::find($funding['campus_id'])->name ?? 'Unknown Campus';
        //         return [$campusName => collect($funding)->except('campus_id')];
        //     });
        //     return $course;
        // });

        return response()->json($courses,200);
    }

}
