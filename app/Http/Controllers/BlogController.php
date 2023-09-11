<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Import the Blog model

class BlogController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        $blogs = Blog::all();

        return view('home', compact('blogs'));
    }
    public function create()
    {
        return view('blogs.create');
    }

    // Store a newly created blog post in the database
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // You may adjust the image validation rules
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        // Create a new blog post
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->start_date = $request->input('start_date');
        $blog->end_date = $request->input('end_date');
        $blog->image = $imagePath ?? null; // Set the image path

        $blog->save();

        // Redirect to the blog listing page or perform any other action
        return redirect()->route('blogs.index');
    }
}
