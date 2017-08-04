<div id="letters-board" class="clearfix">
   
        <?php
        isset($letter)? $currentLetter = $letter : $currentLetter = null;
        $alphabit=Configure::read('HK.KurdishAlpahbit');
        foreach($alphabit as $letter):
        if (isset($currentLetter) && $currentLetter == $letter){$inj['class'] = 'active';}else{$inj = array();}
        echo    '',
                $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),$inj),
                '';
        endforeach;
        ?>
    
</div>