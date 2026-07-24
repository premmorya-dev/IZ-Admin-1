@props(['title', 'description' => null, 'breadcrumbs' => []])

<div class="izy-page-header">

    <h1 class="izy-page-title">{{ $title }}</h1>
    @if(count($breadcrumbs))
    <div><nav aria-label="breadcrumb" class="izy-page-header-breadcrumb">
        <ol class="breadcrumb izy-breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">
                    <i class="bi bi-house-door-fill"></i>
                </a>
            </li>
            @foreach($breadcrumbs as $index => $item)
            @if($index === count($breadcrumbs) - 1 || empty($item['url']))
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
    </nav></div>
    
    @endif

    @if($description)
    <p class="izy-page-desc">{{ $description }}</p>
    @endif
</div>