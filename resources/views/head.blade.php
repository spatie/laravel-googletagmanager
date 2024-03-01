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
        window.dataLayer = window.dataLayer || [];
        @unless(empty($dataLayer->toArray()))
        window.dataLayer.push({!! $dataLayer->toJson() !!});
        @endunless
    </script>
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
        var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
        j.async=true;j.src= 'https://{{ $domain }}/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $id }}');
    </script>
@endif
