<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
    use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:adherent')->except('logout');
    }



    /**
 * Custom credentials to validate the status of user.
 */
public function credentials(Request $request)
{
    return [
        'email'     => $request->email,
        'password'  => $request->password,
        'is_valide' => '1'
    ];
}



     public function showAdherentLoginForm()
    {
        return view('adherent.login', ['url' => 'adherent']);
    }

    public function adherentLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('adherent')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended("/adherent/profile/".Auth::guard('adherent')->user()->code_client);
        }
        return back()->withInput($request->only('email', 'remember'));
    }

}
