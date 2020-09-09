<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Dmlogic\RecruitmentApi\Models\Application;

class UploadCvTest extends IntegrationTest
{
    private $application;
    private $endpoint;
    private $tokenHeader;

    public function setUp(): void
    {
        parent::setUp();
        $this->application = Application::factory()->create(['email' => 'me@example.com','position_reference' => 'abc']);
        $this->endpoint = route('upload',['uuid' => $this->application->uuid]);
        $this->tokenHeader = ['Authorization' => 'Bearer '.$this->application->token];
        Storage::fake('cv_uploads');
    }

    /**
     * @test
     */
    public function see_options()
    {
        $response = $this->options($this->endpoint,[],$this->tokenHeader );
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function non_pdf_fails()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->post($this->endpoint, ['file' => $file],$this->tokenHeader);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function too_big_fails()
    {
        $file = UploadedFile::fake()->create('cv.pdf',50000);
        $response = $this->post($this->endpoint, ['file' => $file],$this->tokenHeader);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function can_upload_as_post()
    {
        $file = UploadedFile::fake()->create('cv.pdf',500);
        $response = $this->post($this->endpoint, ['file' => $file],$this->tokenHeader);
        $response->assertStatus(200);
        $this->assertFileUploaded($file);
    }

    /**
     * @test
     */
    public function can_upload_as_json()
    {
        $file = UploadedFile::fake()->create('cv.pdf',500);
        $response = $this->postJson($this->endpoint, ['file' => $file],$this->tokenHeader);
        $response->assertStatus(200);
        $this->assertFileUploaded($file);
    }

    protected function assertFileUploaded($file)
    {
        $expectedFilename = $file->hashName();
        Storage::disk('cv_uploads')->assertExists($this->application->uuid.'/'.$expectedFilename);
        $this->assertEquals($expectedFilename,Application::first()->cv_upload);
        return $this;
    }
}
