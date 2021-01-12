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
     * @return void
     */
    public function store(CreateRequest $request)
    {
        return response()->json($this->service->store($request->all()), Response::HTTP_CREATED);
    }
}
