<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ResponsesService;

class ResponsesController extends Controller
{
    public function __construct(ResponsesService $service)
    {
        $this->service = $service;
    }

    /**
     * Get a list of individual responses
     *
     * @param
     * @return void
     */
    public function index(Request $request)
    {
        return $this->service->index($request->all());
    }
}
