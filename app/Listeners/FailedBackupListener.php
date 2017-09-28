<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Spatie\Backup\Events\BackupHasFailed;

class FailedBackupListener
{

    /**
     * Handle the event.
     *
     * @param  BackupHasFailed $event
     */
    public function handle(BackupHasFailed $event)
    {
        Redis::set('grimm.last_backup_attempt', Carbon::now());
        Redis::set('grimm.last_backup_status', 'fail');
        Redis::set('grimm.last_backup_name', $event->backupDestination->getBackupName());
    }
}
