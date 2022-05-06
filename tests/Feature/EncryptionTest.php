<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrypt = Crypt::encrypt('Nivek Gemink');
        $decrypt = Crypt::decrypt($encrypt);

        var_dump($encrypt);
        
        self::assertEquals('Nivek Gemink', $decrypt);
    }
}
