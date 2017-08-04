<?php
if(!isset($velocity)){$velocity=500;}
if(!isset($delay)){$delay=4500;}
?>
    <script type="text/javascript">
$(document).ready(function(){
    $(this).notifyMe(
            '<?php echo ($position); ?>',
            '<?php echo ($type); ?>',
            '<?php echo ($title); ?>',
            '<?php echo ($message); ?>',
            <?php echo ($velocity);?>,
            '<?php echo ($delay) ;?>'
    );
});
</script>