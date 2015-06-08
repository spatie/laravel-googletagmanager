@if($enabled)
<script>
    dataLayer.push(<?php echo $dataLayer->toJson(); ?>);
</script>
@endif
