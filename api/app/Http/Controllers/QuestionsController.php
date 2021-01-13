<?php

namespace App\Http\Controllers;

use App\Services\QuestionsService;
use Illuminate\Http\Response;

class QuestionsController extends Controller
{
    public function __construct(QuestionsService $service)
    {
        $this->service = $service;
    }

    /**
     * Get a list of questions
     *
     * @return void
     */
    public function index()
    {
        return $this->service->index();
    }
}
