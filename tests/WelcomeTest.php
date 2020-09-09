<?php

namespace Tests;

class WelcomeTest extends IntegrationTest
{
    /**
     * @test
     */
    public function see_welcome_page()
    {
        $response = $this->get('/recruitment');
        $response->assertStatus(200);
        $response->assertSeeText("You are looking at a REST API");
    }

    /**
     * @test
     */
    public function root_options_returns_expected_response()
    {
        $response = $this->options('/recruitment');
        $response->assertStatus(200);
        $response->assertSeeText("You've found the instructions for submitting a job application",false);
    }
}
