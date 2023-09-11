<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Import the Blog model
use Illuminate\Support\Carbon;

class IndexController extends Controller
{
    //
    public function index()
    { 
        $currentDate = Carbon::now();

        $blogs = Blog::where('is_active', 1)
                ->where(function ($query) use ($currentDate) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', $currentDate->toDateString());
                })
                ->get();

        return view('welcome', compact('blogs'));
    }
}
