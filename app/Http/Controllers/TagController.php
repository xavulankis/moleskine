<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;

class TagController extends Controller
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
    public function update(StoreTagRequest $request, Tag $tag)
    {
        $formData = $request->validated();
        try {
            Tag::where('id', $tag->id)->update($formData);
            return to_route('tags.show', $tag)->with('message', 'Tag successfully updated');
        } catch (Exception $e) {
            return to_route('tags.show', $tag)->with('error', 'Error(' . $e->getCode() . ') tag can not be updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        /* resticted access - only user who owns the type has access
        if ($tag->user_id !== request()->user()->id) {
            abort(403);
        }*/
        try {
            $tag->delete();
            return to_route('tags.index')->with('message', 'Tag (' . $tag->name . ') deleted.');
        } catch (Exception $e) {
            return to_route('tags.index')->with('error', 'Error (' . $e->getCode() . ') Tag: ' . $tag->name . ' can not be deleted.');
        }
    }
}
