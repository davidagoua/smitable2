<li>
    <a href="{{ $link }}" class="d-flex align-items-center justify-content-between">
        <span class="{{ $icon }}"></span>
        <span class="flex-grow-1"> {{ $label  }}</span>
        @if($badge != null)
            <span class="badge bg-success rounded-pill float-end">{{ $badge }}</span>
        @endif
    </a>
</li>
