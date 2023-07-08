<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Like;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeatController extends BaseController
{
    /**
     * Create beat
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'premium' => 'required|file',
            'free' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // dd($request->toArray());

        # save files
        $premiumPath = $this->fileUpload($request->file('premium'), 'premium');

        $freePath = $this->fileUpload($request->file('free'), 'free');

        #save beat
        $beat = Beat::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'premium_file' => $premiumPath,
            'free_file' => $freePath,
        ]);

        #output response
        return $this->sendResponse($beat, 'New beat created.');
    }

    /**
     * Like beat
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request)
    {
        $like = Like::create([
            'user_id' => $request->user()->id,
            'likeable_id' => $request->id,
            'likeable_type' => 'App\Models\Beat',
        ]);

        return $this->sendResponse($like, 'Beat with id ' . $request->id . ' liked');
    }

    /**
     * Upload file.
     */
    public function fileUpload($file, $root): string
    {
        $path = Storage::put('public/' . $root, $file);

        return $path;
    }
}