<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

    // search for a user
    public function search(Request $request)
    {   
        $search = $request->input('search');
        $users = User::where(function ($query) use ($search) {
            $query->where('username', 'LIKE', "%{$search}%")
                ->orWhere('full_name', 'LIKE', "%{$search}%");
        });
        $users = $users->paginate(10);
        $filter=null;
        return view('users.index', compact('users','filter'));
    }

    // show a user
    public function show(User $user)
    {
        $clients = $user->getClients();
        $commands = $user->getCommands();
        $nbSales = $commands->where('type','done')->count();
        return view('users.show', compact('user','clients','commands','nbSales'));
    }

    // update a user
    public function update(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => ['nullable'], 
            'username' => ['nullable', 'unique:users,username,' . $user->id],
            'password' => ['nullable', 'min:8','string'],
            'privilege' => ['nullable', 'in:superuser,user,admin'],
        ]);

        if($validatedData['full_name']){
            $user->full_name = $validatedData['full_name'];
        }
        if($validatedData['username']){
            $user->username = $validatedData['username'];
        }
        if($validatedData['password']){
            $user->password = Hash::make($validatedData['password']);
        }
        if($validatedData['privilege']){
            $user->privilege = $validatedData['privilege'];
        }
        $user->save();
        Session::flash('success', 'Utilisateur modifié avec succès');
        return redirect()->back();
    }
}
