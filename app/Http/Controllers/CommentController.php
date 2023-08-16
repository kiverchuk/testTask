<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request)
    {
         //$query = Comment::with(['user'])->withCount('likes');
        $query = Comment::join('users', 'comments.user_id', '=', 'users.id')->withCount('likes');

        if ($request->has('sort')) {
            $sortField = $request->input('sort');
            $sortOrder = $request->input('order', 'asc');

            if (!in_array($sortOrder, ['asc', 'desc']))
            return response()->json(['error' => 'Invalid sort order (just "asc" or "desc")'], 400);

            $validSortFields = ['user_name', 'user_created_at', 'likes_count'];
            if (!in_array($sortField, $validSortFields))
                return response()->json(['error' => 'Invalid sort field'], 400);

            switch($sortField){
                case 'user_name':
                        $query->orderBy('users.name', $sortOrder);
                    break;
                case 'user_create_at':
                        $query->orderBy('users.created_at', $sortOrder);
                    break;
                case 'likes_count':
                    $query->orderBy('likes_count', $sortOrder);
                default:
                    $query->orderBy($sortField, $sortOrder);
                    break;

            }
        }

        $perPage = $request->input('per_page', 10);
        $comments = $query->paginate($perPage);

        return CommentResource::collection($comments);
    }
}
