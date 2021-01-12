<?php

namespace Tests;

use App\Models\Question;
use Illuminate\Contracts\Console\Kernel;

trait FakesMBTIResponses
{
    public function setFakeResponses()
    {
        $this->test_data = [
            'caseA' => [4, 3, 1, 6, 7, 3, 5, 3, 6, 6],
            'caseB' => [1, 5, 4, 6, 5, 2, 6, 3, 3, 2],
            'caseD' => [3, 2, 6, 1, 7, 3, 2, 5, 2, 7],
            'caseE' => [3, 4, 7, 1, 2, 5, 4, 3, 2, 6],
            'caseF' => [4, 4, 4, 4, 4, 4, 4, 4, 4, 4],
            'caseG' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
            'caseH' => [7, 7, 7, 7, 7, 7, 7 ,7 ,7, 7]
        ];
    }

    /**
     * Using the test case responses, build data that is compatible with
     * how user responses are expected from the frontend
     *
     * @param string $case Test case to use
     * @return array
     */
    private function buildDataFromTestCase($case): array
    {
        $test_data = $this->test_data[$case];
        $responses = [];

        foreach ($test_data as $index => $choice) {
            $question = Question::find($index + 1);

            $responses[] = [
                'choice' => $choice,
                'question_id' => $question->id,
                'dimension' => $question->dimension,
                'direction' => $question->direction
            ];
        }

        return $responses;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->service = new MBTIService();
        $this->setFakeResponses();
    }
}
