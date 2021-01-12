<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Logout
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->user()
            ->tokens()
            ->delete();

        Auth::logout();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
