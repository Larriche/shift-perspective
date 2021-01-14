<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    protected $test_data;

    /** @test */
    public function a_listing_of_questions_can_be_gotten()
    {
        $response = $this->getJson('/api/questions')
            ->assertStatus(200);

        $this->assertCount(Question::count(), json_decode($response->getContent()));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("db:seed");
    }
}
