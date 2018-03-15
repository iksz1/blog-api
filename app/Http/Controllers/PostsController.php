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
        'body' => 'required|string',
        'category_id' => 'required|numeric',
        'img' => 'nullable|string|max:512',
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
        return PostResource::collection(Post::withTrashed()->with('user', 'category')
            ->orderBy('id', 'desc')->simplePaginate());
    }

    public function byCategory($cat)
    {
        $cat = Category::where('alias', $cat)->first();
        if ($cat) {
            return PostResource::collection($cat->posts()->with('user', 'category')
                ->orderBy('id', 'desc')->simplePaginate());
        }
        return response()->json('not found', 404);
    }

    public function show($id)
    {
        $id = (int) $id;
        $post = Post::withTrashed()->with('comments')->findOrFail($id);
        return response()->json(new PostResource($post));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $this->validate($request, $this->validRules);
        $post = $request->user()->publish(new Post($request->all()));
        return response()->json(new PostResource($post), 201);
    }

    public function update(Request $request, $id)
    {
        $id = (int) $id;
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('update', $post);
        $this->validate($request, $this->validRules);
        $post->update($request->all());
        return response()->json(new PostResource($post));
    }

    public function delete($id)
    {
        $id = (int) $id;
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json('success');
        // Post::destroy($id);
    }

    public function restore($id)
    {
        $id = (int) $id;
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);
        $post->restore();
        return response()->json('success');
    }

}
