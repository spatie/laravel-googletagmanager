@if($enabled)
@php
$dLayer = "";

foreach($noScript as $ns)
$dLayer += "&" . $ns;
endforeach

@endphp
@foreach($id as $item)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $item }}{{ $dLayer }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endforeach
@endif
