<?php

namespace Tests;

use Illuminate\Support\Carbon;
use Dmlogic\RecruitmentApi\Models\Position;
use Dmlogic\RecruitmentApi\Models\Application;

class NewApplicationTest extends IntegrationTest
{
    /**
     * @test
     */
    public function bad_reference_gives_422()
    {
        $response = $this->postJson('/recruitment', ['email' => 'me@example.com', 'reference' => 'bad']);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function closed_application_says_so()
    {
        $position = Position::factory()->create(['deleted_at' => Carbon::now()]);
        $response = $this->postJson('/recruitment', ['email' => 'me@example.com', 'reference' => $position->reference]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function bad_payload_gives_validation_errors()
    {
        $position = Position::factory()->create();
        $response = $this->postJson('/recruitment');
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function duplicate_submission_fails()
    {
        $position = Position::factory()->create();
        $application = Application::factory()->create(['email' => 'me@example.com','position_reference' => $position->reference]);
        $response = $this->postJson('/recruitment', ['email' => 'me@example.com', 'reference' => $position->reference]);
        $response->assertStatus(400);
    }

    /**
     * @test
     */
    public function good_submission_gives_token_and_instructions()
    {
        $position = Position::factory()->create();
        $response = $this->postJson('/recruitment', ['email' => 'me@example.com', 'reference' => $position->reference]);
        $response->assertStatus(201);

        $application = Application::first();
        $this->assertSame('/recruitment/'.$application->uuid,$response->headers->get('location'));
        $this->assertSame($application->token,$response->json('token'));
    }
}
