<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        if (isset($search)) {
            return Video::where('title', 'like', "%{$search}%")->paginate(5);
        }

        return Video::paginate(5);
    }

    public function show(int $video)
    {
        $video = Video::find($video);

        if (is_null($video)) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        return $video;
    }

    public function store(StoreVideoRequest $request)
    {
        $data = $request->all();
        $data['category_id'] = $data['category_id'] ?? 1;

        return Video::create($data);
    }

    public function update(StoreVideoRequest $request, Video $video)
    {
        $video->fill($request->all());
        $video->save();

        return $video;
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return response()->noContent();
    }
}
