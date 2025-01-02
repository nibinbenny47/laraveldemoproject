<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\campus;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $campuses= campus::all();
        if ($campuses->isEmpty()) {
            return response()->json(['message' => 'No campuses found'], 404);
        }

        return response()->json($campuses, 200);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $query = campus::query();

        // Apply filters if the corresponding parameter exists
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('slug')) {
            $query->where('slug', $request->input('slug'));
        }

        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }

        $campuses = $query->get();

        if ($campuses->isEmpty()) {
            return response()->json(['message' => 'No campuses found'], 404);
        }

        return response()->json($campuses, 200);
    }
}
