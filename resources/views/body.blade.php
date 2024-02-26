<?php
/**
 * @var bool $enabled
 * @var string $id
 * @var string $domain
 * @var \Spatie\GoogleTagManager\DataLayer $dataLayer
 * @var iterable<\Spatie\GoogleTagManager\DataLayer> $pushData
 */
?>
@if($enabled)
    <script>
        function gtmPush() {
            @foreach($pushData as $item)
            window.dataLayer.push({!! $item->toJson() !!});
            @endforeach
        }
        addEventListener("load", gtmPush);
    </script>
    <noscript>
        <iframe
            src="https://{{ $domain }}/ns.html?id={{ $id }}"
            height="0"
            width="0"
            style="display:none;visibility:hidden"
        ></iframe>
    </noscript>
@endif
