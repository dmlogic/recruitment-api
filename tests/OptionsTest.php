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
        // dump($response);
        $response->assertStatus(200);
    }
}
