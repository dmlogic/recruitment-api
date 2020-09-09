<?php

namespace Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Dmlogic\RecruitmentApi\Models\Position;
use Dmlogic\RecruitmentApi\Models\Application;

class SubmitApplicationTest extends IntegrationTest
{
    private $position;
    private $application;
    private $endpoint;
    private $tokenHeader;

    public function setUp(): void
    {
        parent::setUp();
        $this->position = Position::factory()->create();
        $this->application = Application::factory()->create(['email' => 'me@example.com','position_reference' => $this->position->reference]);
        $this->endpoint = route('view',['uuid' => $this->application->uuid]);
        $this->tokenHeader = ['Authorization' => 'Bearer '.$this->application->token];
    }

    /**
     * @test
     */
    public function access_without_token_fails()
    {
        $response = $this->options($this->endpoint);
        $response->assertStatus(401);

        $response = $this->getJson($this->endpoint);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function access_with_bad_token_fails()
    {
        $response = $this->options($this->endpoint,[],['Authorization' => 'Bearer nonsense']);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function access_good_token_granted()
    {
        $response = $this->options($this->endpoint,[],$this->tokenHeader);
        $response->assertStatus(200);
        $response->assertSee('YOUR APPLICATION');
        $response->assertSee('recruitment/'.$this->application->uuid.'/confirm');
    }

    /**
     * @test
     */
    public function get_progress_displays()
    {
        $response = $this->get($this->endpoint,$this->tokenHeader);
        $response->assertJsonStructure([
                    'status',
                    'email',
                    'position_reference',
                    'cover_letter',
                    'cv',
                    'code_example',
                    'created_at',
                    'updated_at'
                ]);
        $this->assertEquals('draft',$response->json('status'));
        $this->assertNull($response->json('cv'));
    }

    /**
     * @test
     */
    public function validation_rules_apply()
    {
        $response = $this->patchJson($this->endpoint,[
            'name' => 'a',
            'cover_letter' => 'b',
            'cv' => 'c',
            'code_example' => 'd',
        ],$this->tokenHeader);
        $response->assertStatus(422);
        $this->assertEquals(['name','cover_letter','cv','code_example'],array_keys($response->json('errors')));
    }

    /**
     * @test
     */
    public function cannot_update_locked_fields()
    {
        $response = $this->patchJson($this->endpoint,[
            'email' => 'foofoo@example.com',
            'uuid' => 'bcd',
        ],$this->tokenHeader);
        $response->assertStatus(200);
        $this->assertEquals($this->application->toArray(),Application::first()->toArray());
    }

    /**
     * @test
     */
    public function can_submit_as_json()
    {
        $updateData = [
            'name' => 'Scooby Doo',
            'cover_letter' => 'I would have got away with it',
            'cv' => 'http://example.com',
            'code_example' => 'If it wasn\'t for you meddling kids',
        ];
        $response = $this->patchJson($this->endpoint,$updateData,$this->tokenHeader);
        $this->assertEquals($updateData,Arr::only(Application::first()->toArray(),['name','cover_letter','cv','code_example']));
    }

    /**
     * @test
     */
    public function can_nullify_editable_fields()
    {
        $this->application->name = 'Something';
        $this->application->save();
        $response = $this->patchJson($this->endpoint,['name' => ''],$this->tokenHeader);
        $this->assertNull(Application::first()->name);
    }

    /**
     * @test
     */
    public function can_submit_as_form()
    {
        $updateData = [
            'name' => 'Posted',
            'cover_letter' => 'Should have form header',
            'cv' => 'http://example.com',
        ];
        $response = $this->patch($this->endpoint,$updateData,$this->tokenHeader);
        $this->assertEquals($updateData,Arr::only(Application::first()->toArray(),['name','cover_letter','cv']));
    }

    /**
     * @test
     */
    public function cannot_confirm_if_incomplete()
    {
        $response = $this->post($this->endpoint.'/confirm',[],$this->tokenHeader);
        $response->assertStatus(400);

        $this->application->fill(['name' => 'something','cover_letter' => 'something', 'code_example' => 'something']);
        $this->application->save();

        $response = $this->post($this->endpoint.'/confirm',[],$this->tokenHeader);
        $response->assertStatus(400);
    }

    /**
     * @test
     */
    public function can_confirm_complete_application()
    {
        $this->application->fill(['name' => 'something','cover_letter' => 'something', 'code_example' => 'something', 'cv' => 'something']);
        $this->application->save();
        $response = $this->post($this->endpoint.'/confirm',[],$this->tokenHeader);
        $response->assertStatus(200);
        $this->assertNotNull(Application::first()->confirmed_at);

        $response = $this->get($this->endpoint,$this->tokenHeader);
        $this->assertEquals('confirmed',$response->json('status'));
    }

    /**
     * @test
     */
    public function cannot_update_once_confirmed()
    {
        $this->application->confirmed_at = now();
        $this->application->save();
        $response = $this->patchJson($this->endpoint,['name' => 'edited'],$this->tokenHeader);
        $response->assertStatus(422);
    }
}
