<div class="item lyric-item clearfix" data-anchor="<?php echo $lyrics['unique'];?>">
     <?php if($this->Session->check('Auth.User')):?>
            <?php if ($Acl['User'][3]):?>
                <?php echo $this->element('album/lyric_edit_hook');?>
            <?php endif;?>
    <?php endif;?>
    
    <div class="music">&nbsp;
        <?php if ($lyrics['file'] != null):?>
            <i class="glyphicon glyphicon-music"></i> 
        <?php endif;?>
    </div>
    <div class="text">
        <?php echo $this->Html->link($lyrics['echelon'].". ".$lyrics['title'],$lyricUrl);?>
    </div>
    <div class="extension">
        <span class="views">
            <i class="glyphicon glyphicon-eye-open"></i> <?php echo $lyrics['views'];?> 
        </span>
        <span class="action">
            <?php if($this->Session->check('Auth.User')):?>
            <?php if ($Acl['Lyric'][2] || $lyrics['user_id']==$this->Session->read('Auth.User.id')){echo '',$this->Html->link('<i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="right" title="'.__('edit %s',$lyrics['title']).'"></i>',array('controller'=>'lyrics','action'=>'edit',$lyrics['unique']), array('class'=>'action','escape' =>FALSE)),'';}?>
            <?php endif;?>
        </span> 
    </div>
    
   
    
    
    
</div>