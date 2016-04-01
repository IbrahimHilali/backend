<?php


namespace App\Backup;


use Carbon\Carbon;
use Illuminate\Redis\Database;

class BackupStatusReader
{
    /**
     * @var Database
     */
    private $redis;

    public function __construct(Database $redis)
    {
        $this->redis = $redis;
    }

    public function lastBackupAttempt($format = null)
    {
        $data = $this->redis->get('last_backup_attempt');

        $date = new Carbon($data);
        if ($format === null) {
            return $date;
        }

        return ($data !== null) ? $date->format($format) : '';
    }

    public function lastBackupStatus()
    {
        return $this->redis->get('last_backup_status');
    }

    public function lastSuccessfulBackup($format = null)
    {
        $data = $this->redis->get('last_successful_backup');
        $date = new Carbon($data);

        if ($format === null) {
            return $date;
        }

        return ($data !== null) ? $date->format($format) : '';
    }

    public function statusLabel()
    {
        if ($this->lastBackupStatus() == 'success') {
            return 'success';
        }
        return ($this->lastBackupStatus() == 'fail') ? 'danger' : 'default';
    }

    public function lastBackupName()
    {
        return $this->redis->get('last_backup_name');
    }
}