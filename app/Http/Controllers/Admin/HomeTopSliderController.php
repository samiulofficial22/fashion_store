<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\HomeTopSlider;
use Illuminate\Http\Request;


class HomeTopSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = HomeTopSlider::orderBy('ordering')->get();
        return view('admin.hometopslider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hometopslider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            foreach ($request->images as $key => $image) {

            $path = $image->store('sliders', 'public');

            HomeTopSlider::create([
                'title' => $request->titles[$key],
                'subtitle' => $request->subtitles[$key],
                'button_text' => $request->button_texts[$key],
                'button_link' => $request->button_links[$key],
                'image' => $path,
                'ordering' => $key,
                'status' => 1
            ]);
        }

        return redirect()->route('admin.hometopslider.index')->with('success', 'Sliders added successfully!');
        }

    /**
     * Display the specified resource.
     */
    public function show(HomeTopSlider $homeTopSlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeTopSlider $hometopslider)
    {
        return view('admin.hometopslider.edit', compact('hometopslider'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, HomeTopSlider $hometopslider)
{
    // validation
    $request->validate([
        'title'       => 'nullable|string|max:255',
        'subtitle'    => 'nullable|string|max:255',
        'button_text' => 'nullable|string|max:255',
        'button_link' => 'nullable|string|max:255',
        'status'      => 'required|in:1,0',  // FIXED
        'image'       => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        'ordering'    => 'nullable|integer',
    ]);

    // Only updatable fields
    $data = $request->only([
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'status',
        'ordering'
    ]);

    // Image Upload
    if ($request->hasFile('image')) {

        // Delete old image
        if ($hometopslider->image && file_exists(storage_path('app/public/' . $hometopslider->image))) {
            unlink(storage_path('app/public/' . $hometopslider->image));
        }

        // Save new image
        $data['image'] = $request->file('image')->store('sliders', 'public');
    }

    // Update DB
    $hometopslider->update($data);

    return redirect()
        ->back()
        ->with('success', 'Slider updated successfully!');
}

    

    /**
     * Remove the specified resource from storage.
     */
    
    public function restore($id)
    {
        HomeTopSlider::withTrashed()->find($id)->restore();
        return back()->with('success', 'Slider restored!');
    }
    
    public function forceDelete($id)
    {
        HomeTopSlider::withTrashed()->find($id)->forceDelete();
        return back()->with('success', 'Slider permanently deleted!');
    }

    public function destroy(HomeTopSlider $hometopslider)
    {
        //
    }
}
