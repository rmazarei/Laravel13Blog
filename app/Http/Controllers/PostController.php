<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource for authenticated user.
     */
    public function index(): Response
    {
        // Collecting posts based on the authneticated user
        $posts = Auth::user()->posts()->latest()->paginate(1); // using relationship
        // $posts = Post::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate();

        return Inertia::render('post/Index', ['posts' => $posts]);
    }

    /**
     * Display a listing of the resource.
     * NOTE: we can put the authenticated user methods in another controller
     * BUT for this small project, I've used one controller.
     */
    public function home(Request $request): Response
    {
        if ($request->query('query')) {
            $posts = Post::where('title', 'LIKE', '%'.$request->query('query').'%')->orderBy('created_at', 'DESC')->paginate(2)->withQueryString();
        } else {
            // Collecting all posts
            $posts = Post::orderBy('created_at', 'DESC')->paginate(2)->withQueryString();
        }

        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            // TODO: resize image if needed
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $request->user()->posts()->create($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'پست جدید با موفقیت ذخیره شد.']);

        return to_route('posts.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Response
    {
        return Inertia::render('post/Show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Response
    {
        if ($post->user_id != auth()->id()) {
            // Avoid giving too much data to the user
            abort(404);
        }

        return Inertia::render('post/Edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        unset($validated['cover']);

        if ($request->hasFile('cover')) {
            // TODO: resize image if needed
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $post->update($validated);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'پست جدید با موفقیت ذخیره شد.']);

        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if ($post->user_id != auth()->id()) {

            /*
             * We can inform user, using these lines and remove the abort line:
             * Inertia::flash('toast', ['type' => 'error', 'message' => 'این پست متعلق به شما نیست.']);
             * return to_route('posts.index');
             */

            abort(404);
        }

        // OPTIONAL
        // delete file if $post->cover is not null and if file exists in public storage
        if ($post->cover && Storage::disk('public')->exists($post->cover)) {
            Storage::disk('public')->delete($post->cover);
        }

        $post->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'پست با موفقیت خذف شد.']);

        return to_route('posts.index');
    }
}
