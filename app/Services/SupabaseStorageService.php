<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseStorageService
{
    public function upload(string $bucket, string $fileName, string $contents, string $contentType = 'application/octet-stream'): array
    {
        $supabaseUrl = env('SUPABASE_URL');
        $accessKey = $this->getAccessKey();

        if (empty($supabaseUrl) || empty($accessKey)) {
            return [
                'ok' => false,
                'public_url' => null,
                'error' => 'Supabase URL or access key is not configured.',
            ];
        }

        $response = Http::withHeaders([
            'apikey' => $accessKey,
            'Authorization' => 'Bearer ' . $accessKey,
            'Content-Type' => $contentType,
            'x-upsert' => 'true',
        ])->withBody($contents, $contentType)
            ->post($supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $fileName);

        if ($response->successful()) {
            return [
                'ok' => true,
                'public_url' => $supabaseUrl . '/storage/v1/object/public/' . $bucket . '/' . $fileName,
                'error' => null,
            ];
        }

        return [
            'ok' => false,
            'public_url' => null,
            'error' => $response->body() ?: 'Failed to upload file to Supabase Storage.',
        ];
    }

    public function getAccessKey(): string
    {
        return env('SUPABASE_SERVICE_ROLE_KEY') ?: env('SUPABASE_KEY', '');
    }
}
