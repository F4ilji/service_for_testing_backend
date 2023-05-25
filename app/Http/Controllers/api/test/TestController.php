<?php

namespace App\Http\Controllers\api\test;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\test\TestResource;
use Exception;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TestResource::collection(Test::orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'string|required|max:255',
            'difficulty_id' => 'integer|required|exists:difficultly_tests,id',
            'test_time' => 'integer',
            'category_id' => 'integer|required|exists:categories,id',
        ]);
        $test = Test::create($data);
        return response([
            'test' => new TestResource($test),
            'message' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TestResource(Test::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'string|max:255',
            'difficulty_id' => 'integer|exists:difficultly_tests,id',
            'test_time' => 'integer',
            'category_id' => 'integer|exists:categories,id',
        ]);
        $test = Test::find($id);
        $test->update($data);
        return response([
            'test' => new TestResource($test),
            'message' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Test::find($id)) {
            Test::destroy($id);
            return response([
                'message' => 'success'
            ]);
        } else {
            throw new Exception('not find');
        }
    }
}
