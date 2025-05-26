<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Cache;

class ApiServices
{
    public function fetchWebsiteTitle(string $url): ?string
    {
        try {
            $response = Http::get($url);
            if ($response->successful()) {
                $htmlContent = $response->body();
                $doc = new \DOMDocument();
                @$doc->loadHTML($htmlContent);
                $titleNodes = $doc->getElementsByTagName('title');

                return $titleNodes->length > 0 ? 
                    Str::limit($titleNodes->item(0)->nodeValue, 50, '') : 
                    null;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function generateGeminiResponse(string $prompt, string $model = 'gemini-2.0-flash', string $cacheKey)
    {
        try {
            if(Cache::has($cacheKey)){
                return Cache::get($cacheKey);
            }
            $response = Gemini::generativeModel($model)->generateContent($prompt);
            $data = $response->text();
            Cache::put($cacheKey, $data, now()->addMinutes(30));
            return $data;

        } catch (\Exception $e) {
            return null;
        }
    }

    public function qrCodeGenerate(string $url, string $color = '000000', string $bgcolor = 'FFFFFF')
    {
        $encodedUrl = urlencode($url);
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$encodedUrl}&size=200x200&color={$color}&bgcolor={$bgcolor}";
        $response = Http::get($qrCodeUrl);
        if($response->ok()){
            return 'data:image/png;base64,' . base64_encode($response->body());
        }
        return response('Failed to generate QR Code.', 500);
    }
    
}