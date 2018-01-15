<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
// use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{

    protected $validRules = [
        'alias' => 'required|string|max:32',
        'name' => 'required|string|max:32',
        // 'status' => 'integer'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show($id)
    {
        return response()->json(new CategoryResource(Category::find($id)));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $this->validate($request, $this->validRules);
        $cat = Category::create($request->all());
        return response()->json(new CategoryResource($cat));
    }

    public function update(Request $request, $id)
    {
        $id = (int) $id;
        $cat = Category::find($id);
        if (!$cat) {
            return response()->json('not found', 404);
        }
        $this->authorize('update', $cat);
        $this->validate($request, $this->validRules);
        $cat->update($request->all());
        return response()->json(new CategoryResource($cat));
    }

    public function delete($id)
    {
        $this->authorize('delete', Category::class);        
        $id = (int) $id;
        Category::destroy($id);
    }

}
