<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
     
     public function index()
    {
        $users=User::select('*','users.id as uid')->where('is_active',1)->get();
            
          $locations=Role::all();
                       
            return view('forex.admin.dashboard',compact('users','locations'));
        
    }
     
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'designation_id' => ['required'],
            'contact' => ['string', 'max:20'],
            'is_active' => ['required', 'integer', 'max:3'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'is_active'=> $request->is_active,
            'contact'=> $request->contact,
            'password' => Hash::make($request->password),
        ]);
        $user->attachRole($request->designation_id);
        event(new Registered($user));
        return redirect()->back()->with('success', 'User Record Successfully Added!!');
    }
     public function update(Request $request,User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required'],
            'designation_id' => ['required'],
            'contact' => ['string', 'max:20'],
            'is_active' => ['required', 'integer', 'max:3'],
        ]);
         $user->update([
            'name' => $request->name,
            'full_name' => $request->full_name,
            // 'email' => $request->email,
            'is_active'=> $request->is_active,
            'contact'=> $request->contact,
                ]);
               
          
            return redirect()->back()->with('success', 'User Updated Successfully!!');
        }
}
