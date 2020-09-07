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
}
