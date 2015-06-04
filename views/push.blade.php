@if($enabled)
<script>
@if (isset($dataLayer) && $dataLayer instanceof Spatie\GoogleTagManager\DataLayer)
    dataLayer.push({!! $dataLayer->toJson() !!});
@else
    dataLayer.push({!! GoogleTagManager::dump() !!});
@endif
</script>
@endif
