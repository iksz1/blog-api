<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
// use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{

    protected $validRules = [
        'name' => 'required|string|min:3|max:24|regex:/^[а-яА-ЯёЁ\w]+$/u|unique:users',
        'email' => 'required|string|email|max:64|unique:users',
        'password' => 'required|string|min:6|max:255', //confirmed - id="password_confirmation"
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

    public function index() {
        // return CommentResource::collection(Comment::with('author', 'category')->orderBy('id', 'desc')->simplePaginate(5));
        return CategoryResource::collection(Category::all());
    }

    public function show($id) {
        return new CategoryResource(Category::find($id));
    }

    public function store(Request $request) {
        $this->authorize('create', Category::class);
        $this->validate($request, $this->validRules);
        $cat = Category::create($request->all());
        return response()->json(new CategoryResource($cat));
    }

    public function update(Request $request, $id) {
        $id = (int) $id;
        $cat = Category::find($id);
        if (!$cat) {
            return response('not found', 404);
        }
        $this->authorize('update', $cat);
        $this->validate($request, $this->validRules);
        // dd($request->all());
        $cat->update($request->all());
        return response()->json(new CategoryResource($cat));
    }

    public function delete($id) {
        // increments id?
        $this->authorize('delete', Category::class);        
        $id = (int) $id;
        Category::destroy($id);
    }

}
