<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Resources\Auth\UserLoginResource;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    * The user repository interface implementation.
    * Create a new controller instance.
    *
    * @var UserRepository
    */
    protected $userRepository;

    /**
     * Create a new controller instance.
     * @param  UserRepositoryInterface  $repository
     * @return void
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->middleware('guest')->except('logout');
        $this->userRepository = $repository;
    }

    public function loginUser(UserLoginRequest $request)
    {
        $data = $request->validated();

        $user = $this->userRepository->findOneByEmail($data['email']);

        if (!$user) 
            return $this->errorResponse(Message::EMAIL_NOT_FOUND, 401);

        $userPassword = $user->password;

        $checkPassword = Hash::check($data['password'], $userPassword);

        if (! $checkPassword) {
            return $this->errorResponse(Message::INVALID_CREDENTIALS, 401);
        }

        $tokenResult = $user->createToken('Pers0nalAcc3ssToken');
        $token = $tokenResult->token;
        $token->save();

        $response = [
            'access_token' => $tokenResult->accessToken,
            'user' => new UserLoginResource($user),
            'topics' => [
                'general',
                'users'
            ]
        ];

        return $this->successResponse($response, 200);
    }
}
