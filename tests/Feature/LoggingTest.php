<?php

namespace Tests\Feature;

use App\SamsLog;
use Tests\TestCase;
use App\Http\Controllers\SamsLogController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoggingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_log_can_be_added()
    {
        // New instance of SAMSLogController
        $log = new SamsLogController();

        // Add a log for NeptuneContract
        $log->addLog($user_id = 1, $action = 'Add', $message = 'A new Neptune contract was added: 01 - Anställd');

        // Check if the log was added
        $this->assertCount(1, SamsLog::all());
    }

}
