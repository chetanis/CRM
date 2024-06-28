<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
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
            $user = Auth::user();
            //setting the session cookies 
            if ($remember) {
                $expireOnClose = false;
                session()->put('expire_on_close', $expireOnClose);
            }

            // Check the user's privilege
            if ($user->privilege === 'master') {
                return redirect()->route('logs');
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

        return view('Users.create');
    }

    // handel the creation of a user
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'min:8'],
            'full_name' => ['required'],
            'privilege' => ['required', 'in:superuser,user,admin'],
        ]);

        //check if the current user has reached his quota
        $current_user = User::find(Auth::user()->id);
        if ($current_user->current_quota >= $current_user->quota) {
            return redirect()->back()->with('error', 'Vous avez atteint votre quota d\'utilisateurs');
        }

        //create the user
        $user = new User();
        $user->username = $validatedData['username'];
        $user->full_name = $validatedData['full_name'];
        $user->password = Hash::make($validatedData['password']);
        $user->privilege = $validatedData['privilege'];
        $user->notes = $request->input('notes');
        $user->save();

        //increment the current user quota
        $current_user->update([
            'current_quota' => $current_user->current_quota + 1
        ]);

        Log::CreateLog('Créer utilisateur', 'utilisateur: ' . $user->username . ' privilege: ' . $user->privilege);

        return redirect()->back()->with('success', 'Utilisateur ajouter!');
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
        return view('users.index', compact('users', 'filter'));
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
        $filter = null;
        return view('users.index', compact('users', 'filter'));
    }

    // show a user
    public function show(User $user)
    {
        $clients = $user->clients()->get();
        $commands = $user->commands()->get();
        $appointments = $user->appointments()->get();
        $nbSales = $commands->where('type', 'done')->count();
        return view('users.show', compact('user', 'clients', 'commands', 'nbSales', 'appointments'));
    }

    // update a user
    public function update(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => ['nullable'],
            'username' => ['nullable', 'unique:users,username,' . $user->id],
            'password' => ['nullable', 'min:8', 'string'],
            'privilege' => ['nullable', 'in:superuser,user,admin'],
            'notes' => ['nullable', 'string']
        ]);

        if ($validatedData['full_name']) {
            $user->full_name = $validatedData['full_name'];
        }
        if ($validatedData['username']) {
            $user->username = $validatedData['username'];
        }
        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }
        if ($validatedData['privilege']) {
            $user->privilege = $validatedData['privilege'];
        }
        if ($validatedData['notes']) {
            $user->notes = $validatedData['notes'];
        }
        $user->save();
        Log::CreateLog('modifier utilisateur', 'utilisateur: ' . $user->username);
        Session::flash('success', 'Utilisateur modifié avec succès');
        return redirect()->back();
    }
}
