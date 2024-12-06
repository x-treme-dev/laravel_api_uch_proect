<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    //
    protected $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/photos.json');
    }

    public function index()
    {
        $photos = json_decode(file_get_contents($this->filePath), true);
        return response()->json($photos);
    }

    public function show($id)
    {
        $photos = json_decode(file_get_contents($this->filePath), true);
        $photo = collect($photos)->firstWhere('id', $id);

        if (!$photo) {
            return response()->json(['message' => 'Photo not found'], 404);
        }

        return response()->json($photo);
    }

    public function update(Request $request, $id)
    {
        $photos = json_decode(file_get_contents($this->filePath), true);
        $photoIndex = collect($photos)->search(fn($photo) => $photo['id'] == $id);

        if ($photoIndex === false) {
            return response()->json(['message' => 'Photo not found'], 404);
        }

        // Обновляем данные фотографии
        $photos[$photoIndex]['title'] = $request->input('title', $photos[$photoIndex]['title']);
        $photos[$photoIndex]['url'] = $request->input('url', $photos[$photoIndex]['url']);
        $photos[$photoIndex]['thumbnailUrl'] = $request->input('thumbnailUrl', $photos[$photoIndex]['thumbnailUrl']);

        // Сохраняем обновленные данные обратно в файл
        file_put_contents($this->filePath, json_encode($photos, JSON_PRETTY_PRINT));

        return response()->json($photos[$photoIndex]);
    }
}
