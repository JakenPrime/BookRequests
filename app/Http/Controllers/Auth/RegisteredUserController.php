<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SyncClassesService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class RegisteredUserController extends Controller
{  
    /**
     * @var SyncClassesService
     */
    private $classSync;

     /**
   *
   * @param SyncClassesService $orders
   */
    public function __construct(SyncClassesService $classSync){
        $this->classSync = $classSync;
    }
    
    /**
     * Call Azure AD for auth
     */
    public function azure(){
        return Socialite::driver('azure')->redirect();
    }
    //dev login
    public function dev(){
        $user = User::first();
        Auth::login($user);
        return redirect(route('dashboard', absolute: false));
    }
    /**
     * Login in/ create user from AD.
     */
    public function create()
    {
        $adUser = Socialite::driver('azure')->user();
        dd($adUser);
        $name = explode(', ', $adUser->name);
        $user = User::firstOrCreate(['email' => $adUser->email],
            [
                'first_name' => $name[1],
                'last_name' => $name[0],
                'email' => $adUser->email,
                'password' => Hash::make('random'),
            ]
            );
        $this->classSync->readCSV($user->email, $user->id);
        Auth::login($user);
        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
