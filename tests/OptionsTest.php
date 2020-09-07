<?php

namespace Tests;

class OptionsTest extends IntegrationTest
{
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
