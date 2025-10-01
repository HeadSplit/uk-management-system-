<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:requests,id',
            'text' => 'required|string'
        ]);

        $comment = Comment::create([
            'request_id' => $request->request_id,
            'user_id' => auth()->id(),
            'text' => $request->text,
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'text' => $comment->text,
                'created_at' => $comment->created_at->format('d.m.Y H:i'),
            ],
            'comment_user' => [
                'id' => $comment->user_id,
                'name' => $comment->user->name,
            ],
            'comment_user_name' => $comment->user->name
        ]);
    }

}
