<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Spatie\Backup\Events\BackupWasSuccessful;

class SuccessfulBackupListener
{

    /**
     * Handle the event.
     *
     * @param  BackupWasSuccessful $event
     */
    public function handle(BackupWasSuccessful $event)
    {
        Redis::set('grimm.last_successful_backup', Carbon::now());
        Redis::set('grimm.last_backup_attempt', Carbon::now());
        Redis::set('grimm.last_backup_status', 'success');
        Redis::set('grimm.last_backup_name', $event->backupDestination->getBackupName());
    }
}
