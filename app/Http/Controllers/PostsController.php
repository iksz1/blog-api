<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
// use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{

    protected $validRules = [
        'title' => 'required|string|max:512',
        // 'teaser' => 'required|string|max:1024',
        'body' => 'required|string',
        'category_id' => 'required|numeric', //can alias be used?
        'img' => 'nullable|string|max:512',
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

    public function index() {
        // if ($request->has('category')) {
        //     $cat = Category::where('name', $request->category)->first();
        //     return PostResource::collection(Post::where('category_id', $cat->id)
        //         ->with('user', 'category')->orderBy('id', 'desc')->simplePaginate(5));    
        // }
        return PostResource::collection(Post::withTrashed()->with('user', 'category')
            ->orderBy('id', 'desc')->simplePaginate());
    }

    public function byCategory($cat) {
        $cat = Category::where('alias', $cat)->first();
        //querying category 2 times :/
        if ($cat) {
            return PostResource::collection($cat->posts()->with('user', 'category')
                ->orderBy('id', 'desc')->simplePaginate());
            // return PostResource::collection(Post::where('category_id', $cat->id)
            //     ->with('user', 'category')->orderBy('id', 'desc')->simplePaginate(5));
        }
        return response()->json('not found', 404);
    }

    public function show($id) {
        $id = (int) $id;
        $post = Post::withTrashed()->with('comments')->findOrFail($id);
        return response()->json(new PostResource($post));
        // $posts = DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')
        //     ->join('categories', 'posts.category_id', '=', 'categories.id')->select('posts.*', 'users.name as author', 'categories.name as category')->find($id);
    }

    public function store(Request $request) {
        $this->authorize('create', Post::class);
        $this->validate($request, $this->validRules);
        $post = $request->user()->publish(new Post($request->all()));
        return response()->json(new PostResource($post), 201);
    }

    public function update(Request $request, $id) {
        $id = (int) $id;
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('update', $post);
        $this->validate($request, $this->validRules);
        // dd($request->all());
        $post->update($request->all());
        return response()->json(new PostResource($post));
    }

    public function delete($id) {
        // increments id?
        $id = (int) $id;
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json('success');
        // Post::destroy($id);
    }

    public function restore($id) {
        $id = (int) $id;
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);
        $post->restore();
        return response()->json('success');
    }

}
