<?php
$alphabit=Configure::read('HK.KurdishAlpahbit');
?>
<div class="lettersBoard">
<?php
    foreach($alphabit as $letter):
    echo $letter,"<br>";
    endforeach;
?>
</div>