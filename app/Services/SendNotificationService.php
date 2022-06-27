<?php

namespace App\Services;

use App\Repositories\JournalRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SendNotificationService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendNotifyCationForAllParticipant($title, $message)
    {
        $userFromDBNeedNotification = $this->userRepository->getAllHaveExponentPushTokenNotNull();

        for ($i = 0; $i < count($userFromDBNeedNotification); ++$i) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ])->withOptions(
                [
                    'verify' => false
                ]
            )->post('https://exp.host/--/api/v2/push/send', [
                "to" => "ExponentPushToken[HfyH1vAMm9yTTGuUKmwlAF]",
                "title" => $title,
                "body" => $message,
            ]);
        }
    }
}
