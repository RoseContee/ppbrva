<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index() {
        $locations = Location::query()
            ->latest()
            ->get(['id', 'name', 'address', 'image']);
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
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'website' => ['required', 'url'],
            'image' => ['required', 'image'],
        ]);
        if ($request->hasFile('image')) {
            Location::query()->create([
                'name' => $request['name'],
                'address' => $request['address'],
                'lat' => $request['lat'],
                'lng' => $request['lng'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'website' => $request['website'],
                'image' => 'uploads/'.$request->file('image')->store('locations'),
            ]);
            return to_route('locations.index')
                ->with('success_message', 'New location has been added.');
        }
        return back()->withInput()->with('error_message', 'Please upload location image.');
    }

    public function edit($id) {
        $location = Location::query()->find($id);
        if (!$location) return back();
        return view('locations.add', [
            'location' => $location,
        ]);
    }

    public function update(Request $request, $id) {
        $location = Location::query()->find($id);
        if (!$location) return back();
        $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'website' => ['required', 'url'],
            'image' => ['nullable', 'image'],
        ]);
        $location['name'] = $request['name'];
        $location['address'] = $request['address'];
        $location['lat'] = $request['lat'];
        $location['lng'] = $request['lng'];
        $location['phone'] = $request['phone'];
        $location['email'] = $request['email'];
        $location['website'] = $request['website'];
        if ($request->hasFile('image')) {
            General::removeImage($location->getRawOriginal('image'));
            $location['image'] = 'uploads/'.$request->file('image')->store('locations');
        }
        $location->save();
        return back()->with('info_message', 'Location has been updated.');
    }
}
