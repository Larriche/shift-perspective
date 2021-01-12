<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MBTI;
use App\Models\Question;
use App\Models\Response;
use App\Services\MBTIService;
use Tests\FakesMBTIResponses;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MBTITest extends TestCase
{
    use RefreshDatabase, FakesMBTIResponses;

    protected $test_data;

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

    /** @test */
    public function mbti_readings_are_stored()
    {
        $data = [
            'email' => 'user@shift.com',
            'responses' => $this->buildDataFromTestCase('caseA')
        ];

        $mbti = $this->service->store($data)['mbti'];

        $this->assertEquals(1, MBTI::count());
        $this->assertEquals('ENTP', $mbti->mbti);
        $this->assertEquals(Question::count(), Response::count());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->service = new MBTIService();
        $this->setFakeResponses();
    }
}
