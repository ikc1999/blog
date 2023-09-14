<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Import the Blog model
use App\Models\User; // Import the Blog model
use Illuminate\Support\Facades\Storage;

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
        if (auth()->id()) {
            // Get the current user's ID from the session
            $userId = auth()->id();
            
            // Check if the user's role is 'user' from the 'users' table
            $user = User::find($userId);

            if ($user && $user->role === 'user') {
                // Retrieve and display only the blogs associated with the current user
                $blogs = Blog::where('user_id', $userId)->paginate(10);

                return view('home', compact('blogs'));
            }
        }
        $blogs = Blog::paginate(10);

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
            'end_date' => 'nullable|date|after_or_equal:start_date', // Make end_date nullable
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // You may adjust the image validation rules
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }
        $end_date = $request->input('end_date');

        // Check if "end_date" is provided and not empty before assigning it to the blog post
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->start_date = $request->input('start_date');
        if (!empty($end_date)) {
            $blog->end_date = $end_date;
        } else {
            $blog->end_date = null; // Set it to null if not provided
        }
        $blog->image = $imagePath ?? null; // Set the image path
        $blog->user_id = auth()->id();
        $blog->save();

        // Redirect to the blog listing page or perform any other action
        return redirect()->route('home');
    }

    public function destroy(Request $request, Blog $blog)
    {
        if (auth()->id()) {
            $userId = auth()->id();
            $user = User::find($userId);

            if($userId === $blog->user_id || $user->role === 'admin'){
                // Unlink the image from storage
                if (Storage::disk('public')->exists('uploads/' . $blog->image)) {
                    Storage::disk('public')->delete('uploads/' . $blog->image);
                }

                $blog->delete();

                return redirect()->route('home')
                    ->with('success', 'Blog post deleted successfully.');
            }else{
                return redirect()->route('home');
            }
        }
    }

    public function edit($id)
    {
        if (auth()->id()) {
            $userId = auth()->id();
            $user = User::find($userId);

            $blog = Blog::findOrFail($id);
            if($userId === $blog->user_id || $user->role === 'admin'){
                return view('blogs.edit', compact('blog'));
            }else{
                return redirect()->route('home')->with('error', 'Blog post Can not be updated');

            }
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // You may adjust the image validation rules
        ]);

        $blog = Blog::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete the previous image (if exists)
            if ($blog->image) {
                \Storage::disk('public')->delete($blog->image);
            }
            $imagePath = $request->file('image')->store('uploads', 'public');
            $blog->image = $imagePath;
        }

        // Update the blog post
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->start_date = $request->input('start_date');
        $blog->end_date = $request->input('end_date');
        $blog->save();

        return redirect()->route('home')->with('success', 'Blog post updated successfully');
    }

    public function activate($id)
    {
        $blog = Blog::findOrFail($id);
        if (auth()->id()) {
            $userId = auth()->id();
            $user = User::find($userId);
            if($userId === $blog->user_id || $user->role === 'admin'){
                $blog->is_active =  1;
                $blog->save();
                return redirect()->route('home')->with('success', 'Blog post status updated successfully');
            }else{
                return redirect()->route('home');
            }
        }

    }

    public function deactivate($id)
    {
        $blog = Blog::findOrFail($id);
        if (auth()->id()) {
            $userId = auth()->id();
            $user = User::find($userId);
            if($userId === $blog->user_id || $user->role === 'admin'){
                $blog->is_active =  0;
                $blog->save();
                return redirect()->route('home')->with('success', 'Blog post status updated successfully');
            }else{
                return redirect()->route('home');
            }
        }
    }
}
