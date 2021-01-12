<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MBTI;
use App\Models\Question;
use App\Services\MBTIService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MBTITest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mbti_is_calculated_correctly()
    {
        $caseA = $this->buildDataFromTestCase('caseA');
        $this->assertEquals('ENTP', $this->service->calculateMBTI($caseA)['mbti']);

        $caseB = $this->buildDataFromTestCase('caseB');
        $this->assertEquals('ESTJ', $this->service->calculateMBTI($caseB)['mbti']);

        $caseD = $this->buildDataFromTestCase('caseD');
        $this->assertEquals('INFP', $this->service->calculateMBTI($caseD)['mbti']);

        $caseE = $this->buildDataFromTestCase('caseE');
        $this->assertEquals('ISFP', $this->service->calculateMBTI($caseE)['mbti']);

        $caseF = $this->buildDataFromTestCase('caseF');
        $this->assertEquals('ESTJ', $this->service->calculateMBTI($caseF)['mbti']);

        $caseG = $this->buildDataFromTestCase('caseG');
        $this->assertEquals('ISTJ', $this->service->calculateMBTI($caseG)['mbti']);

        $caseH = $this->buildDataFromTestCase('caseH');
        $this->assertEquals('ESTP', $this->service->calculateMBTI($caseH)['mbti']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->service = new MBTIService();
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
}
