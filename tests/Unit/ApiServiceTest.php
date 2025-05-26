<?php

namespace Tests\Unit;

use Tests\TestCase; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use App\Services\ApiServices;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;

class ApiServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testFetchWebsiteTitleReturnsCorrectTitle()
    {
        $html = '<html><head><title>My Test Website</title></head><body></body></html>';
        Http::fake([
            'https://example.com' => Http::response($html, 200),
        ]);

        $service = new ApiServices();
        $title = $service->fetchWebsiteTitle('https://example.com');

        $this->assertEquals('My Test Website', $title);
    }

    public function testFetchWebsiteTitleReturnsNullOnError()
    {
        Http::fake([
            'https://invalid-url.com' => Http::response(null, 404),
        ]);

        $service = new ApiServices();
        $title = $service->fetchWebsiteTitle('https://invalid-url.com');

        $this->assertNull($title);
    }

    public function testGenerateGeminiResponseGeneratesAndCachesValue()
    {
        Cache::shouldReceive('has')->with('my-key')->andReturn(false);
        Cache::shouldReceive('put')->with('my-key', 'fake response', \Mockery::any());

        Gemini::swap(new class {
            public function generativeModel($model)
            {
                return new class {
                    public function generateContent($prompt)
                    {
                        return new class {
                            public function text()
                            {
                                return 'fake response';
                            }
                        };
                    }
                };
            }
        });

        $service = new ApiServices();
        $response = $service->generateGeminiResponse('prompt', 'gemini-2.0-flash', 'my-key');

        $this->assertEquals('fake response', $response);
    }


    // public function testQrCodeGenerateReturnsBase64String()
    // {
    //     $image = file_get_contents(base_path('tests/Fixtures/dummy_qr.png')) ?: 'fakeimage';
        
    //     Http::fake([
    //         '*' => Http::response($image, 200),
    //     ]);
    
    //     $service = new ApiServices();
    //     $result = $service->qrCodeGenerate('https://example.com');
    
    //     $this->assertNotNull($result);
    //     $this->assertStringStartsWith('data:image/png;base64,', $result);
    // }

    public function testQrCodeGenerateFailsOnBadResponse()
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $service = new ApiServices();
        $response = $service->qrCodeGenerate('https://example.com');

        $this->assertEquals(500, $response->status());
        $this->assertEquals('Failed to generate QR Code.', $response->getContent());
    }
}
