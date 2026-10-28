{{-- resources/views/components/page-header.blade.php --}}
@props(['title', 'description' => null, 'breadcrumbs' => []])
 
<div class="izy-page-header">

    <div class="izy-ph-main">
        @if(count($breadcrumbs))
        <nav aria-label="breadcrumb" class="izy-page-header-breadcrumb">
            <ol class="breadcrumb izy-breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/dashboard') }}" aria-label="Dashboard" title="Dashboard">
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
        </nav>
        @endif

        <h1 class="izy-page-title">{{ $title }}</h1>

        @if($description)
        <p class="izy-page-desc">{{ $description }}</p>
        @endif
    </div>

    {{-- Optional: <x-slot:actions> ... </x-slot:actions> (Add New, Export, etc.) --}}
    @isset($actions)
    <div class="izy-ph-actions">{{ $actions }}</div>
    @endisset
</div>