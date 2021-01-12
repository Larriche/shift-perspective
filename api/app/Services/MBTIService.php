<?php

namespace App\Services;

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

        $mbti = MBTI::create([
            'email' => $data['email'],
            'mbti' => $mbti_scores['mbti']
        ]);

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

        foreach ($data as $data) {
            $scores_list[$data['dimension']][] = $this->getScore($data);
        }

        $mbti = '';

        foreach ($scores_list as $dimension => $scores) {
            $average = array_sum($scores) / count($scores);
            $mbti .= ($average <= 4) ? $dimension[0] : $dimension[1];
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
