<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'body'=>'required|string',
            'images'=> 'nullable|array',
            'images.*'=> 'image|max:2048',
        ]);
        $imagesPath = [];

        if($request->hasFile('images')){
            foreach($request->file('images') as $image){
                $imagesPath[]= $image->store('posts','public');
            }
        }
        $post = Auth::user()->posts()->create([
            'body' => $data['body'],
            'pubtime' => now(),
            'images' => $imagesPath,
        ]);
        return redirect()->back()->with('success', 'Пост создан!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => 'required|string',
            'images.*' => 'image|max:2048'
        ]);

        // Загружаем текущие картинки
        $images = $post->images ?? [];

        // Если были выбраны для удаления
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $img) {
                // Удаляем файл из storage
                Storage::disk('public')->delete($img);

                // Убираем из массива
                $images = array_diff($images, [$img]);
            }
        }

        // Добавляем новые картинки
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');
                $images[] = $path;
            }
        }

        $post->update([
            'body' => $data['body'],
            'images' => $images,
        ]);

        return redirect()->route('post.show', $post)->with('success', 'Пост обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->images) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // 2. Удаляем сам пост
        $post->delete();

        return redirect()->route('home');
    }
}
