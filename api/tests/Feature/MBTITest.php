<?php

namespace Tests\Feature;

use Tests\TestCase;
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
        $this->setFakeResponses();
    }
}