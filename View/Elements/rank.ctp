<?php $balance = $group -$rank;?>
<div class="btn-group">
<?php if ($balance>=2):?> 
<a class="dropdown-toggle" data-toggle="dropdown">
<?php endif;?>
<?php
if ($rank==1){echo '<div data-unique="'.$unique.'" class="stars _1"></div>';}
if ($rank==2){echo '<div data-unique="'.$unique.'" class="stars _2"></div>';}
if ($rank==3){echo '<div data-unique="'.$unique.'" class="stars _3"></div>';}
if ($rank==4){echo '<div data-unique="'.$unique.'" class="stars _4"></div>';}
if ($rank==5){echo '<div data-unique="'.$unique.'" class="stars _5"></div>';}
?>
<?php if ($balance>=2):?>
</a>
<?php endif;?>

<ul class="dropdown-menu pull-left">
    <?php for($i=0;$i<$balance;$i++){ ?>
        
        <li <?php echo ($rank>=$i+$rank)?'class="disabled"':'';?>><a class="<?php echo $rank==($i+$rank)?'disabled':'ranker';?>" data-value="_<?php echo $i+$rank;?>" href="#"><div class="_<?php echo $i+$rank;?>"></div></a></li>
        
        
    <?php } ?>
 
</ul>
</div>