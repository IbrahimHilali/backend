<a href="#" class="backup-link" data-container="body" data-toggle="popover" data-placement="bottom"
   data-title="Datensicherung"
   data-content="Name: {{ $backup->lastBackupName() }}<br>Letzter Sicherungsversuch: {{ $backup->lastBackupAttempt('d.m.Y H:i') }}<br>Letzte erfolgreiche Sicherung: {{ $backup->lastSuccessfulBackup('d.m.Y H:i') }}">
    <span class="label label-{{ $backup->statusLabel() }}">
        <i class="fa fa-cloud"></i>
    </span>
</a>