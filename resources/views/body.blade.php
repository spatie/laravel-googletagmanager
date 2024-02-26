@if($enabled)
    <script>
        function gtmPush() {
            @unless(empty($dataLayer->toArray()))
            window.dataLayer.push({!! $dataLayer->toJson() !!});
            @endunless
            @foreach($pushData as $item)
            window.dataLayer.push({!! $item->toJson() !!});
            @endforeach
        }
        addEventListener("load", gtmPush);
    </script>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $id }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

