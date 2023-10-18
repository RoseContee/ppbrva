<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index() {
        $locations = Location::orderBy('created_at', 'desc')->get();
        foreach ($locations as $location) {
            $location['image'] = asset($location['image']);
        }
        return view('locations.index', [
            'locations' => $locations,
        ]);
    }

    public function create() {
        return view('locations.add');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'website' => ['required', 'url'],
            'image' => ['required', 'image'],
        ]);
        if ($request->hasFile('image')) {
            Location::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'website' => $request['website'],
                'image' => 'uploads/'.$request->file('image')->store('locations'),
            ]);
            return redirect()->route('locations.index')
                ->with('success_message', 'New location has been added.');
        }
        return back()->withInput()->with('error_message', 'Please upload location image.');
    }

    public function edit($id) {
        $location = Location::find($id);
        if (!$location) return back();
        return view('locations.add', [
            'location' => $location,
        ]);
    }

    public function update(Request $request, $id) {
        $location = Location::find($id);
        if (!$location) return back();
        $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'website' => ['required', 'url'],
            'image' => ['nullable', 'image'],
        ]);
        $location['name'] = $request['name'];
        $location['address'] = $request['address'];
        $location['phone'] = $request['phone'];
        $location['email'] = $request['email'];
        $location['website'] = $request['website'];
        if ($request->hasFile('image')) {
            if ($location['image'] && file_exists(public_path($location['image']))) {
                unlink(public_path($location['image']));
            }
            $image = 'uploads/'.$request->file('image')->store('locations');
            $location['image'] = $image;
        }
        $location->save();
        return back()->with('info_message', 'Location has been updated.');
    }
}
