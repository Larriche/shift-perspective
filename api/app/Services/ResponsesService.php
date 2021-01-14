<?php

namespace App\Services;

use App\Models\Response;

class ResponsesService
{
    /**
     * Get a listing of questions
     *
     * @param $query_data
     * @return \Illuminate\Database\Eloquent\Collection List of responses
     */
    public function index($query_data)
    {
        // Get non-soft deleted(latest by users) responses only
        $responses = Response::whereHas('mbti', function ($mbti_query) {
            $mbti_query->whereNull('deleted_at');
        })
        ->with(['question']);

        $email = isset($query_data['email']) ? $query_data['email'] : null;

        if ($email) {
            $responses->whereHas('mbti', function ($mbti_query) use ($email) {
                $mbti_query->where('email', $email);
            });
        }

        return $responses->get();
    }
}
