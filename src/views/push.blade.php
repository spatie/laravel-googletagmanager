@if($enabled)
<script>
@if (isset($dataLayer) && $dataLayer instanceof Spatie\GoogleTagManager\DataLayer)
    dataLayer.push(<?php $dataLayer->toJson(); ?>);
@else
    dataLayer.push(<?php GoogleTagManager::dump(); ?>);
@endif
</script>
@endif
