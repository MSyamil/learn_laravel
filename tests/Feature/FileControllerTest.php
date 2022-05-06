<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testUpload()
    {
        $picture = UploadedFile::fake()->image('guwah.png');

        $this->post('/file/upload', [
            'picture' => $picture
        ])->assertSeeText("File uploaded, " . $picture->getClientOriginalName()); // File uploaded, guwah.png
    }
}
