<div class="row">
    <ul class="nav nav-pills pull-right" role="tablist">
        <li<?php echo $section == 'artists'? ' class="active"':'';?>><?php echo $this->Html->link(__('artists').' <span class="count">('.$user['User']['artist_counter'].')</span>',array('controller'=>'users','action'=>'property','artists',$user['User']['unique']),array('escape'=>false));?></li>
        <li<?php echo $section == 'albums'? ' class="active"':'';?>><?php echo $this->Html->link(__('albums').' <span class="count">('.$user['User']['album_counter'].')</span>',array('controller'=>'users','action'=>'property','albums',$user['User']['unique']),array('escape'=>false));?></li>
        <li<?php echo $section == 'lyrics'? ' class="active"':'';?>><?php echo $this->Html->link(__('lyrics').' <span class="count">('.$user['User']['lyric_counter'].')</span>',array('controller'=>'users','action'=>'property','lyrics',$user['User']['unique']),array('escape'=>false));?></li>
    </ul>
</div>
<div class="clearfix"></div>