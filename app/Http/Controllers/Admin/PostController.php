<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $validationRules = [
        'title' => 'min:3|max:255|required|unique:posts,title|alpha',
        'description' => 'min:5|required',
        'image_url' => 'active_url'
    ];

    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function show($id){
        $post = Post::findOrFail($id);
        return view('admin.posts.show', ['post' => $post]);
    }

    public function create(){
        $post = new Post();
        return view('admin.posts.create', ['post' => $post]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'min:3|max:255|required|unique:posts,title|alpha',
            'description' => 'min:5|required',
            'image_url' => 'active_url'
        ]);

        $data = $request->all();
        $data['author'] = Auth::user()->name;
        $data['post_date'] = new DateTime();
        Post::create($data);
        return redirect()->ruote('admin.posts.index')->with('Il post.'.$data["title"]. 'has been created succesfully');
    }
}


