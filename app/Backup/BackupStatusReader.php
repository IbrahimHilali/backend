<?php


namespace App\Backup;


use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class BackupStatusReader
{

    public function lastBackupAttempt($format = null)
    {
        $data = Redis::get('grimm.last_backup_attempt');

        $date = new Carbon($data);
        if ($format === null) {
            return $date;
        }

        return ($data !== null) ? $date->format($format) : '';
    }

    public function lastBackupStatus()
    {
        return Redis::get('grimm.last_backup_status');
    }

    public function lastSuccessfulBackup($format = null)
    {
        $data = Redis::get('grimm.last_successful_backup');
        $date = new Carbon($data);

        if ($format === null) {
            return $date;
        }

        return ($data !== null) ? $date->format($format) : '';
    }

    public function statusLabel()
    {
        if ($this->lastBackupIsOld()) {
            return 'warning';
        }

        if ($this->lastBackupStatus() == 'success') {
            return 'success';
        }

        return ($this->lastBackupStatus() == 'fail') ? 'danger' : 'default';
    }

    public function lastBackupName()
    {
        return Redis::get('grimm.last_backup_name');
    }

    /**
     * @return bool
     */
    protected function lastBackupIsOld()
    {
        return Carbon::now()->diffInDays($this->lastSuccessfulBackup()) > 3;
    }
}