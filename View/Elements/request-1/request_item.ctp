<?php
$dateText="<span class=\"date\">".$this->Time->timeAgoInWords($Request['created'])."</span>";
switch ($Request['type']) {
    case 'lyric':
        $requstType = __('Lyric');
        break;
    case 'album':
        $requstType = __('Album');
        break;
    case 'artist':
        $requstType = __('Artist');
        break;
    default:
        $requstType = __('Lyric');
        break;


        break;
}
?>
<div class="request-item">
    <div class="request-entry">
        
        <div class="request-type"><i class="glyphicon glyphicon-<?php echo $Request['type'];?>"></i> <?php echo __('%s request',$requstType);?></div>
        <div class="request-name"><i class="glyphicon glyphicon-user small"></i> <?php echo $Request['name'];?></div>
        <div class="request-date"><i class="glyphicon glyphicon-time small"></i> <?php echo $dateText;?></div><div class="clearfix"></div>

    </div>
    
<div class="request-data"><?php echo $Request['data'];?></div> 
<div class="clearfix"></div>
</div>