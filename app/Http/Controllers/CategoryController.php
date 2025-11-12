<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $formData = $request->validated();
        try {
            Category::where('id', $category->id)->update($formData);
            return to_route('categories.show', $category)->with('message', 'Category successfully updated');
        } catch (Exception $e) {
            return to_route('categories.show', $category)->with('error', 'Error(' . $e->getCode() . ') Category can not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        /* resticted access - only user who owns the type has access
        if ($category->user_id !== request()->user()->id) {
            abort(403);
        }*/
        // test error
        //$category->id = null;  
        //dd($category);  
        try {
            $category->delete();
            return to_route('categories.index')->with('message', 'Category (' . $category->name . ') deleted');
        } catch (Exception $e) {
            return to_route('categories.index')->with('error', 'Error (' . $e->getCode() . ') Category: ' . $category->name . ' can not be deleted');
        }
    }
}

