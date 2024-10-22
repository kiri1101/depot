<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    /**
     * Create post
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        #save post
        $post = Post::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'content' => $request->content
        ]);

        #output response
        return $this->sendResponse($post, 'New post created.');
    }

    /**
     * Like post
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request)
    {
        $like = Like::create([
            'user_id' => $request->user()->id,
            'likeable_id' => $request->id,
            'likeable_type' => 'App\Models\Post',
        ]);

        return $this->sendResponse($like, 'Post with id ' . $request->id . ' liked');
    }
}