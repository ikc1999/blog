<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'image' => ['required', 'image', 'max:2048'], // Assuming you want to validate image uploads with a maximum size of 2MB (2048 KB)
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Get the uploaded image file
        $image = $data['image'];
    
        // Generate a unique filename for the image
        $imageFileName = time() . '.' . $image->getClientOriginalExtension();
    
        // Store the image in the storage/app/public directory
        $imagePath = $image->storeAs('public/profile_images', $imageFileName);
        try {
            // Create the user and store the image path in the database
            return User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'dob' => $data['dob'],
                'image' => $imagePath,
                'role' => $data['role'],
            ]);
         } catch (\Exception $e) {
            // Log the error or handle it as needed
            // For debugging, you can use dd($e->getMessage()) to display the error message.
            // Log::error($e->getMessage());
            // dd($e->getMessage());
    
            // Redirect back with an error message (example)
            return redirect()->back()->with('error', 'User registration failed.');
        }
    }
    
}
