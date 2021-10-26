<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
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
        //
    }

    public function store(Request $request)
    {
        //
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
