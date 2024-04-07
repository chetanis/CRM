<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // show the login form
    public function showLoginForm(Request $request)
    {

        return view('login');
    }

    // handel the login process 
    public function login(Request $request)
    {
        $formFields = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:8']
        ]);
        //check if the remember button is clicked
        $remember = $request->filled('remember');

        if (Auth::attempt($formFields)) {
            //setting the session cookies 
            if ($remember) {
                $expireOnClose = false;
                session()->put('expire_on_close', $expireOnClose);
            }

            return redirect()->route('dashboard');
        } else {
            // Authentication failed
            return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
        }
    }

    // show the create user view
    public function showRegisterForm(Request $request)
    {

        return view('createUser');
    }

    // handel the creation of a user
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'min:8'],
            'privilege' => ['required', 'in:superuser,user'],
        ]);

        $user = new User();
        $user->username = $validatedData['username'];
        $user->password = Hash::make($validatedData['password']);
        $user->privilege = $validatedData['privilege'];
        $user->save();

        return redirect()->route('dashboard');
    }

    // handel the logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // show all users
    public function index()
    {
        $users = User::filter(request(['type']))->paginate(10);;
        $filter = request(['type'][0]);
        return view('users.index', compact('users','filter'));
    }
}
