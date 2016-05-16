<div class="col-md-12 letters-container">
    <ul class="letters">
        @foreach($navigationPrefixes as $letter => $_)
            <li {!! active($firstCharacter, $letter) !!}>
                <a href="{{ url($route) }}?prefix={{ $letter }}">{{ $letter }}</a>
            </li>
        @endforeach
        @if($firstCharacter)
            <li>
                <a href="{{ url($route) }}">&times;</a>
            </li>
        @endif
    </ul>
</div>
@if($firstCharacter)
    <div class="col-md-12 letters-container">
        <ul class="letters">
            @foreach($navigationPrefixes[$firstCharacter] as $letter)
                <li {!! active($secondCharacter, $letter) !!}>
                    <a href="{{ url($route) }}?prefix={{ $firstCharacter . $letter }}">{{ $firstCharacter . $letter }}</a>
                </li>
            @endforeach
            @if($secondCharacter)
                <li>
                    <a href="{{ url($route) }}?prefix={{ $firstCharacter }}">&times;</a>
                </li>
            @endif
        </ul>
    </div>
@endif
