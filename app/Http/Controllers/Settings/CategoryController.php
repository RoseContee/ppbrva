<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::orderBy('name')->get();
        return view('settings.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create() {
        return view('settings.categories.add');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required', 'unique:categories'],
        ]);
        Category::create([
            'name' => $request['name'],
        ]);
        return redirect()->route('settings.categories.index')
            ->with('success_message', 'New category has been added.');
    }

    public function edit($id) {
        $category = Category::find($id);
        if (!$category) return back();
        return view('settings.categories.add', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        if (!$category) return back();
        $request->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category['id'])],
        ]);
        $category['name'] = $request['name'];
        $category->save();
        return back()->with('info_message', 'Category has been updated.');
    }

    public function destroy(Request $request) {
        $categories = explode(',', $request['categories']);
        Category::whereIn('id', $categories)->delete();
        return back()->with('error_message', 'Categories have been removed.');
    }
}
