<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Import the Blog model
use App\Models\User; // Import the Blog model
use Illuminate\Support\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();

        if (auth()->id()) {
            $userId = auth()->id();
            
            // Check if the user's role is 'user' from the 'users' table
            $user = User::find($userId);

            if ($user && $user->role === 'user') {
                // Retrieve and display only the blogs associated with the current user
                $blogs = Blog::where('user_id', $userId)->paginate(10);

            }else{
                $blogs = Blog::where('is_active', 1)
                ->where(function ($query) use ($currentDate) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', $currentDate->toDateString());
                })
                ->paginate(10);
            }
        }else{
            $blogs = Blog::where('is_active', 1)
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $currentDate->toDateString());
            })
            ->paginate(10);
        }

        return view('welcome', compact('blogs'));
    }
}
