<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = Media::query();

        if ($search = $request->get('search')) {
            $query->where('filename', 'like', "%{$search}%");
        }

        return view('admin.media.index', [
            'media' => $query->latest()->paginate(20)->withQueryString(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,svg,pdf|max:10240',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $path = $file->store('media', 'public');

        Media::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $request->alt_text,
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function destroy(Media $media)
    {
        $this->deleteImage($media->path);
        $media->delete();

        return back()->with('success', 'Media deleted successfully.');
    }
}
