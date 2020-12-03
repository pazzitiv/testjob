<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('jwt', ['except' => ['email']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['login', 'password']);

        if (!$token = auth('jwt')->attempt($credentials)) {
            return response()->json(['error' => 'Неверный логин или пароль'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('jwt')->logout();

        $response = response()->json('loggedOut');
        $response->headers->setCookie(\cookie('token', '', -1));

        return $response;
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            $token = $this->respondWithToken(auth('jwt')->refresh());
        } catch (\Exception $exception) {
            throw new AccessDeniedHttpException('Нет доступа', $exception);
        }
        return $token;
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token, $guard = 'jwt'): JsonResponse
    {
        $user = request()->user($guard);

        if ($user) throw_if($user->cannot('login', $this), AccessDeniedHttpException::class, 'Пользователь заблокирован');

        $response = response()->json([
            'user' => $user ? UserResource::make($user) : null,
            'auth' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth($guard)->factory()->getTTL() * 60
            ]
        ]);
        $response->headers->setCookie(
            \cookie('token', $token, auth($guard)->factory()->getTTL() * 60, '/')
        );

        return $response;
    }
}
