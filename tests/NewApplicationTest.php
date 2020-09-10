<?php

namespace Tests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Dmlogic\RecruitmentApi\Models\Position;
use Dmlogic\RecruitmentApi\Models\Application;
use Dmlogic\RecruitmentApi\Events\ApplicationCreated;

class NewApplicationTest extends IntegrationTest
{
    /**
     * @test
     */
    public function bad_reference_gives_422()
    {
        $response = $this->postJson( route('create'), ['email' => 'me@example.com', 'reference' => 'bad']);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function closed_application_says_so()
    {
        $position = Position::factory()->create(['deleted_at' => Carbon::now()]);
        $response = $this->postJson(route('create'), ['email' => 'me@example.com', 'reference' => $position->reference]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function bad_payload_gives_validation_errors()
    {
        $position = Position::factory()->create();
        $response = $this->postJson(route('create'));
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function duplicate_submission_fails()
    {
        Event::fake();
        $position = Position::factory()->create();
        $application = Application::factory()->create(['email' => 'me@example.com','position_reference' => $position->reference]);
        $response = $this->postJson(route('create'), ['email' => 'me@example.com', 'reference' => $position->reference]);
        $response->assertStatus(400);

        Event::assertDispatched(function (ApplicationCreated $event) use ($application) {
            return $event->application->uuid === $application->uuid
                && $event->resend;
        });
    }

    /**
     * @test
     */
    public function good_submission_gives_token_and_instructions()
    {
        Event::fake();
        $position = Position::factory()->create();
        $response = $this->postJson(route('create'), ['email' => 'me@example.com', 'reference' => $position->reference]);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                    'message',
                ]);

        $application = Application::first();

        Event::assertDispatched(function (ApplicationCreated $event) use ($application) {
            return (string) $event->application->uuid === $application->uuid
                && !$event->resend;
        });
    }
}
