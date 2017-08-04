<?php
$user=$this->Session->read('Auth.User');
if ($this->Session->check('Auth.Acl')){$Acl=$this->Session->read('Auth.Acl');}else{}
?>
<section id="dashboard-nav" class="dashboard-nav-hidden">

    <div class="dashboard-nav-header">
        <span class="dragger"><i class="glyphicon glyphicon-pencil"></i></span>
    </div>
    <div class="panel-body">   
    <?php if($Acl['Artist']['0']||$Acl['Artist']['1']||$Acl['Artist']['2']||$Acl['Artist']['3']):?>
    <div class="list-group">
        <span class="list-group-item list-hk">
            <i class="glyphicon glyphicon-artist"></i> <span class="title"><?php echo __('Artists');?> </span>
            <span class="information"><em><?php echo __('%s artists',$user['artist_counter']);?></em></span>
        </span>
        <?php
        
        if($Acl['Artist']['1']||$Acl['Artist']['2']||$Acl['Artist']['3']):
           echo $this->Html->link(__('Add new artist'),array('controller'=>'artists','action'=>'add'),array('class'=>'list-group-item add-link'));
        endif;
       
        if($Acl['Artist']['0']):
           //echo $this->Html->link(__('List all artists'),array('controller'=>'artists','action'=>'index'),array('class'=>'list-group-item list-link'));
        endif;
        
        ?>
    </div>
    <?php endif;?>
        
   <?php if($Acl['Album']['0']||$Acl['Album']['1']||$Acl['Album']['2']||$Acl['Album']['3']):?>
    <div class="list-group">
        <span class="list-group-item  list-hk">
            <i class="glyphicon glyphicon-album"></i> <span class="title"> <?php echo __('Albums');?> </span>
            <span class="information"><?php echo __('%s albums',$user['album_counter']);?></span>
        </span>
        
        <?php 
        if($Acl['Album']['0']):
            echo $this->Html->link(__('Add new album'),array('controller'=>'albums','action'=>'add'),array('class'=>'list-group-item add-link'));
        endif;
        
        if($Acl['Album']['1']||$Acl['Album']['2']||$Acl['Album']['3']):
            //echo $this->Html->link(__('List all albums'),array('controller'=>'albums','action'=>'index'),array('class'=>'list-group-item list-link'));
        endif;
        ?>
    </div>
    <?php endif;?>
        
    <?php if($Acl['Lyric']['0']||$Acl['Lyric']['1']||$Acl['Lyric']['2']||$Acl['Lyric']['3']):?>
    <div class="list-group">
        <span class="list-group-item  list-hk">
            <i class="glyphicon glyphicon-lyric"></i> <span class="title"> <?php echo __('Lyrics');?> </span>
            <span class="information"><?php echo __('%s lyrics',$user['lyric_counter']);?></span>
        </span>
        <?php 
        if($Acl['Lyric']['0']):
            echo $this->Html->link(__('Add new lyric'),array('controller'=>'lyrics','action'=>'add'),array('class'=>'list-group-item add-link'));
        endif;
        
        if($Acl['Lyric']['1']||$Acl['Lyric']['2']||$Acl['Lyric']['3']):
            echo $this->Html->link(__('List my lyrics'),array('controller'=>'lyrics','action'=>'lyricslist'),array('class'=>'list-group-item list-link'));
        endif;
        
        ?>
    </div>
    <?php endif;?>
    <?php if($Acl['User']['0']||$Acl['User']['1']||$Acl['User']['2']||$Acl['User']['3']):?>
    <div class="list-group">
        <span class="list-group-item  list-hk">
            <i class="glyphicon glyphicon-user"></i> <span class="title"> <?php echo __('Users');?> </span>
        </span>
        <?php 
        if($Acl['User']['0']):
            echo $this->Html->link(__('Add new user'),array('controller'=>'users','action'=>'add'),array('class'=>'list-group-item add-link'));
        endif;
        
        if($Acl['User']['1']||$Acl['User']['2']||$Acl['User']['3']):
           echo $this->Html->link(__('List all users'),array('controller'=>'users','action' =>'userslist'),array('class'=>'list-group-item list-link'));
        endif;
        ?>
    </div>
    <?php endif;?>
    </div>
</section>