<?php

namespace App\Services;

use Auth;
use App\Models\MBTI;

class MBTIService
{
    /**
     * Store the MBTI score and the actual responses of a user
     *
     * @param array $data
     * @return void
     */
    public function store($data)
    {
        $mbti_scores = $this->calculateMBTI($data['responses']);
        $creation_data = [
            'email' => $data['email'],
            'mbti' => $mbti_scores['mbti']
        ];

        // Overwrite response filled in previous times by user with that email
        $mbti = MBTI::where('email', $data['email'])->first();

        if ($mbti) {
            $mbti->delete();
        }

        $mbti = MBTI::create($creation_data);

        foreach ($data['responses'] as $response) {
            $mbti->responses()->create([
                'question_id' => $response['question_id'],
                'choice' => $response['choice']
            ]);
        }

        return [
            'mbti' => $mbti,
            'scores' => $mbti_scores['scores']
        ];
    }

    /**
     * Get the mbti details for the currently authenticated user
     *
     * @return object
     */
    public function getUserMBTIProfile(): ?object
    {
        $user = Auth::user();

        return MBTI::where('email', $user->email)->with('responses')->first();
    }

    /**
     * Calculate the MBTI value based on responses made
     *
     * @param array $data
     * @return array
     */
    public function calculateMBTI($data): array
    {
        $scores_list = [
            'EI' => [],
            'SN' => [],
            'TF' => [],
            'JP' => []
        ];

        $scores = [];

        foreach ($data as $data) {
            $scores_list[$data['dimension']][] = $this->getScore($data);
        }

        $mbti = '';

        foreach ($scores_list as $dimension => $dimension_scores) {
            $average = array_sum($dimension_scores) / count($dimension_scores);
            $mbti .= ($average <= 4) ? $dimension[0] : $dimension[1];

            $scores[$dimension] = $average;
        }

        return [
            'mbti' => $mbti,
            'scores' => $scores
        ];
    }

    /**
     * Get score based on scale value and direction
     *
     * @param array $response_data
     * @return int
     */
    public function getScore($response_data): int
    {
        $max_value = 7;

        if ($response_data['direction'] == 1) {
            return $response_data['choice'];
        }

        return $max_value - $response_data['choice'] + 1;
    }
}
