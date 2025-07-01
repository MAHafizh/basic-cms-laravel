<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('posts', [
            'title' => 'Blog',
            'posts' => Post::filter(request(['search', 'category', 'author']))
                ->latest()
                ->paginate(6)
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.form-article', [
            'title' => 'Article Form',
            'categories' => Category::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required',
            'image' => 'image|nullable|mimes:jpg,jpeg,png|max:10240'
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('post/images', 'public');
        };
        $validated['slug'] = Str::slug($validated['title']);
        Post::create($validated);
        return redirect('/posts')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post', ['title' => 'Detail Post', 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.form-article', [
            'title' => 'Edit Article',
            'post' => Post::findOrFail($id),
            'categories' => Category::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required',
            'image' => 'image|nullable|mimes:jpg,jpeg,png'
        ]);
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('post/images', 'public');
        };
        $validated['slug'] = Str::slug($validated['title']);
        $post->update($validated);
        return redirect('/posts')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted!');
    }
}
