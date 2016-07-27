<ul class="breadcrumb">
    @foreach ($list as $item)
        @if (empty($item['link']))
            <li class="active">{{ $item['label'] }}</li>
        @else
            <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
        @endif
    @endforeach
</ul>
