<?php

namespace App\Http\Controllers;

use App\Models\campus;
use Illuminate\Http\Request;

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return "Hello, world!";
        
        return view('admin.campuses.create');
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
            'name' => 'required|string|max:255',
            'slug'=>'required|string|max:255|unique:campuses,slug',
        ]);
        $campus = Campus::create($validated);
        return redirect()->route('campuses.store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function show(campus $campus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, campus $campus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function destroy(campus $campus)
    {
        //
    }
}
