<?php

namespace App\Services;

use Http;

class Momo
{
    public static function getConfig(): array
    {
        $config = config('services.momo', []);
        if (
            !array_key_exists('domain', $config) || !$config['domain'] ||
            !array_key_exists('phone', $config) || !$config['phone'] ||
            !array_key_exists('access_token', $config) || !$config['access_token']
        )
            throw new \Exception('Config momo service is invalid');

        return $config;
    }

    public static function bank(int $amount, string $phone, string $description = ''): bool
    {
        $config = static::getConfig();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])
            ->post('https://' . $config['domain'] . '/api/sendMoneyMomo', [
                'access_token' => $config['access_token'],
                'phone' => $config['phone'],
                'phoneto' => $phone,
                'amount' => $amount,
                'note' => $description,
            ]);

        $data = $response->json();

        return !$data['error'];
    }
}
