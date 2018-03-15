<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
// use Illuminate\Support\Facades\Gate;

class CommentsController extends Controller
{

    protected $validRules = [
        'post_id' => 'required|integer',
        'parent_id' => 'required|integer',
        'author' => 'required|min:3|max:32|regex:/^[а-яА-ЯёЁ\w]+$/u',
        'content' => 'required|string|max:2048',
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
        // return CommentResource::collection(Comment::with('author', 'category')->orderBy('id', 'desc')->simplePaginate(5));
    }

    public function show($id)
    {
        $id = (int)$id;
        $cmt = Comment::find($id);
        if ($cmt) {
            return response()->json(new CommentResource($cmt));
        }
        return response()->json('not found', 404);
    }

    public function store(Request $request)
    {
        // $this->authorize('create', Comment::class);
        $this->validate($request, $this->validRules);
        if ($request->user()) {
            $cmt = $request->user()->writeComment(new Comment($request->all()));
        } else {
            $cmt = Comment::create($request->all());
        }
        return response()->json(new CommentResource($cmt));
    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        $cmt = Comment::find($id);
        if (!$cmt) {
            return response('not found', 404);
        }
        $this->authorize('update', $cmt);
        $this->validate($request, $this->validRules);
        $cmt->update($request->all());
        return response()->json(new CommentResource($cmt));
    }

    public function delete($id)
    {
        $this->authorize('delete', Comment::class);
        $id = (int)$id;
        Comment::destroy($id);
    }

}
