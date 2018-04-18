@if($enabled)
@foreach($id as $item)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $item }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endforeach
@endif
