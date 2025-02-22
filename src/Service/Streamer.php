<?php

namespace App\Service;

class Streamer
{
    public function sendSseEvent(string $event, string $data): void
    {
        ob_start();
        echo 'event: '.$event."\n";
        echo 'data: '.$data."\n\n";
        ob_flush();
        flush();
        ob_end_clean();
    }
}