<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use MacsiDigital\Zoom\Facades\Zoom;

trait MeetingZoomTrait
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {


        $this->client = new Client();
        $this->accessToken = 'bEMUquuBTBuKi6wmSH0-Cw';

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }
    function generateZoomAccessToken()
    {
        $apiKey = env('Client_ID');
        $apiSecret = env('Client_Secret');
        $account_id = env('Account_ID');

        $base64Credentials = base64_encode("$apiKey:$apiSecret");

        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $account_id;

        $response = Http::withHeaders([
            'Authorization' => "Basic $base64Credentials",
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post($url);

        $responseData = $response->json();

        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        } else {
            // Log or print the entire response for debugging purposes.
            \Log::error('Zoom OAuth Token Response: ' . json_encode($responseData));

            // Handle the error as needed.
            return null; // You might want to return null or throw an exception here.
        }
    }
    public function createMeeting($request){

        $accessToken = $this->generateZoomAccessToken();
        $user = Zoom::user()->first();
        $url = 'https://api.zoom.us/v2/users/'.$user->id.'/meetings';

        $meetingData = Http::withToken($accessToken)->post($url, [
            'topic' => $request->topic,
            'duration' => $request->duration,
            'password' => $request->password,
            'start_time' => $request->start_time,
            'timezone' => config('zoom.timezone')
            // 'timezone' => 'Africa/Cairo'
        ]);
        $meeting = Zoom::meeting()->make($meetingData);

        $meeting->settings()->make([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording')
        ]);

        return  $user->meetings()->save($meeting);


    }
}
