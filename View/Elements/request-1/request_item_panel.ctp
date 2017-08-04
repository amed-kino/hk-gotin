<?php
$Acl=$this->Session->read('Auth.Acl');
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
        
        <div class="request-type">
            <i class="glyphicon glyphicon-<?php echo $Request['type'];?>"></i> 
            <?php
                if ($this->Session->check('Auth.User')){

                    if(($Request['public'])=='yes'){

                        echo " <i class=\"public-visible glyphicon glyphicon-eye-open\" data-original-title=".__('Visible')." data-toggle=\"tooltip\" data-placement=\"top\" title=\"".__('Visible for public')."\"></i>";

                    }else{

                        echo " <i class=\"public-invisible glyphicon glyphicon-eye-close\" data-original-title=".__('Unvisible')." data-toggle=\"tooltip\" data-placement=\"top\" title=\"".__('Hidden from public')."\"></i>";

                    }

                } 
            ?>
                <?php echo __('%s request',$requstType);?>
        </div>
        <div class="request-name"><i class="glyphicon glyphicon-user small"></i> <?php echo $Request['name'];?><div class="request-action"><?php if ($Acl['Request']['3']==true){echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $Request['id']), array('data-original-title' => __('Delete'),'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('Delete this request')), __('Are you sure you want to delete # %s?', $Request['name'])); }?></div></div>
        <div class="request-date"><i class="glyphicon glyphicon-time small"></i> <?php echo $dateText;?></div><div class="clearfix"></div>

    </div>
    
<div class="request-data"><?php echo $Request['data'];?></div> 
<div class="clearfix"></div>
</div>




              