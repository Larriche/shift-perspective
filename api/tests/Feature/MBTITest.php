<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Services\MBTIService;
use Tests\FakesMBTIResponses;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MBTITest extends TestCase
{
    use RefreshDatabase, FakesMBTIResponses;

    protected $test_data;

    /** @test */
    public function mbti_recordings_cant_be_saved_without_valid_email_added()
    {
        $this->postJson('api/mbti', [
                'responses' => $this->buildDataFromTestCase('caseA'),
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function mbti_recordings_cant_be_saved_with_incomplete_responses()
    {
        $this->postJson('api/mbti', [
                'email' => 'user@shift.com',
                'responses' => [
                    [
                        'choice' => 1,
                        'question_id' => 1,
                        'direction' => 1,
                        'dimension' => 'EI'
                    ]
                ],
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function mbti_recordings_are_saved_with_valid_data()
    {
        $this->postJson('api/mbti', [
                'email' => 'user@shift.com',
                'responses' => $this->buildDataFromTestCase('caseA'),
            ])
            ->assertStatus(201)
            ->assertJsonFragment(['mbti' => 'ENTP']);
    }

    /** @test */
    public function mbti_profile_of_a_logged_in_user_can_be_viewed()
    {
        $user = User::first();

        $data = [
            'email' => $user->email,
            'responses' => $this->buildDataFromTestCase('caseA')
        ];

        $mbti = $this->service->store($data)['mbti'];

        $this->actingAs($user)
            ->getJson('/api/mbti_profile')
            ->assertStatus(200)
            ->assertJsonFragment(['email' => $user->email])
            ->assertJsonFragment(['mbti' => 'ENTP']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->setFakeResponses();
        $this->service = new MBTIService();
    }
}
