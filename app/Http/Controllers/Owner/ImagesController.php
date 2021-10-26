<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $owner = $request->route('image')->owner;
            if (Auth::id() !== $owner->id) {
                abort(404);
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
    }

    public function index()
    {
        $images = Auth::user()->images()
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('owner.images.index', compact('images'));
    }

    public function create()
    {
        return view('owner.images.create');
    }

    public function store(UploadImageRequest $request)
    {
        foreach ($request->file('files') as $imageFile) {
            $basename = ImageService::upload($imageFile['image'], 'products');
            Image::create([
                'owner_id' => Auth::id(),
                'filename' => $basename,
            ]);
        }


        return redirect()
            ->route('owner.images.index')
            ->with([
                'message' => '画像登録を実施しました。',
                'status' => 'info'
            ]);
    }

    public function edit(Image $image)
    {
        //
    }

    public function update(Request $request, Image $image)
    {
        //
    }

    public function destroy(Image $image)
    {
        //
    }
}
