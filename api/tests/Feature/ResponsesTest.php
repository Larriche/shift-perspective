<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Question;
use App\Services\MBTIService;
use Tests\FakesMBTIResponses;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResponsesTest extends TestCase
{
    use RefreshDatabase, FakesMBTIResponses;

    protected $test_data;

    /** @test */
    public function a_list_of_responses_can_be_gotten_by_email()
    {
        $user = User::first();

        $data = [
            'email' => $user->email,
            'responses' => $this->buildDataFromTestCase('caseA')
        ];

        $mbti = $this->service->store($data)['mbti'];

        $response = $this->actingAs($user)
            ->getJson('/api/responses?email=' . $user->email)
            ->assertStatus(200);

        $this->assertCount(Question::count(), json_decode($response->getContent()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->setFakeResponses();
        $this->service = new MBTIService();
    }
}
