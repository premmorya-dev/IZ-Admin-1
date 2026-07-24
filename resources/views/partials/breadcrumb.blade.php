<nav aria-label="breadcrumb" class="izy-breadcrumb-wrap">
    <ol class="breadcrumb izy-breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ url('/dashboard') }}">
                <i class="bi bi-house-door-fill"></i>
            </a>
        </li>

        @foreach($items as $index => $item)
            @if($index === count($items) - 1 || empty($item['url']))
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>