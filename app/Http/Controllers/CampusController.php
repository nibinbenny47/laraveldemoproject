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
        $campuses = Campus::all();
        return view('admin.campuses.index', compact('campuses'));
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
        return redirect()->route('campuses.index')->with('success', 'Campus created successfully!');

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
    public function edit(Campus $campus)
    {
       
        return view('admin.campuses.edit', compact('campus'));
    }
    
    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:campuses,slug,' . $campus->id],
        ]);
    
        $campus->update($validated);
    
        return redirect()->route('campuses.index')->with('success', 'Campus updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\campus  $campus
     * @return \Illuminate\Http\Response
     */
    // public function destroy(campus $campus)
    // {
    //     //
    //     $campus->delete();
    //     return redirect()->route('campuses.index')->with('success', 'Campus deleted successfully!');
    // }
    public function destroy(campus $campus)
{
    // Delete the campus record
    $campus->delete();

    // Redirect back with a success message
    return redirect()->route('campuses.index')->with('success', 'Campus deleted successfully!');
}

}
