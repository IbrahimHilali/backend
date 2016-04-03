@if (count($errors) > 0)
<!-- Form Error List -->
<div class="alert alert-danger">
    <strong>Es sind Fehler aufgetreten</strong>

    <br><br>

    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif