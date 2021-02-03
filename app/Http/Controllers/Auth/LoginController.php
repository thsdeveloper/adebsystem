<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\LoginValidator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use JWTAuth;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        if ($this->guard()->logout()) {
            return response()->json(['data' => 'Usuário deslogado.'], 200);
        }
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'login' => ['required', 'string', new LoginValidator],
            'password' => 'required|string'
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {

        $user = User::join('user_details', 'users.id', '=', 'user_details.user_id')
            ->where(function ($query) use ($request) {
                $query->where('users.email', $request->login);
            })->orWhere(function ($query) use ($request) {
                $query->where('user_details.cpf', $request->login);
            })
            ->first();

        if ($user === null) {
            return false;
        }
        if (!(Hash::check($request->password, $user->password))) {
            return false;
        }

        $token = JWTAuth::fromUser($user);

        if ($token) {
            $this->guard()->setToken($token);

            return true;
        }

        return false;
    }

    /**
     * Envie a resposta depois que o usuário foi autenticado.
     *
     * @param Request $request
     * @return Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = (string)$this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration - time(),
        ];
    }

}
