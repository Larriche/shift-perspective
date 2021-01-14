<?php

namespace App\Http\Controllers;

use App\Services\MBTIService;
use Illuminate\Http\Response;
use App\Http\Requests\MBTI\CreateRequest;

class MBTIController extends Controller
{
    public function __construct(MBTIService $service)
    {
        $this->service = $service;
    }

    /**
     * Calculate and save mbti scores from user responses
     *
     * @return Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        return response()->json($this->service->store($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Get the MBTI details of currently authenticated user by looking up using his email
     *
     * @return Illuminate\Http\Response
     */
    public function getUserMBTIProfile()
    {
        return $this->service->getUserMBTIProfile();
    }
}
