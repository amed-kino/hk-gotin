<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
    <li><?php echo $this->Html->link($user['User']['name'],array('controller'=>'users','action' => 'profile',$user['User']['unique']));?></li>
    <li class="active"><?php echo __('Property'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="property">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-list"></i></div>
                <div class="text-container clearfix">
			<div class="information clearfix">
	                    <div class="title"><?php echo __('%s\'s property',$user['User']['name']); ?>
                            </div>
                            <div class="tips"><?php echo __('Please select the property section.');?></div>
			</div>
                    
                    
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body property-body clearfix">
            <div class="page-content col-lg-12">
        <div class="col-lg-4">
            <div class="title">(<?php echo $user['User']['artist_counter'];?>) <?php echo __('Artist');?> <i class="glyphicon glyphicon-artist"></i> </div>
          <p class="body">

          </p>
          <p><?php echo $this->Html->link(__('Artist'),array('controller'=>'users','action'=>'property','artists',$user['User']['unique']),array('class'=>'btn btn-default'));?></p>
        </div>
        <div class="col-lg-4">
          <div class="title">(<?php echo $user['User']['album_counter'];?>) <?php echo __('Album');?> <i class="glyphicon glyphicon-album"></i> </div>
                <p class="body">

          </p>
          <p><?php echo $this->Html->link(__('Album'),array('controller'=>'users','action'=>'property','albums',$user['User']['unique']),array('class'=>'btn btn-default'));?> </p>
        </div>
        <div class="col-lg-4">
            <div class="title">(<?php echo $user['User']['lyric_counter'];?>) <?php echo __('Lyric');?> <i class="glyphicon glyphicon-lyric"></i> </div>
          <p class="body">

          </p>
          <p><?php echo $this->Html->link(__('Lyric'),array('controller'=>'users','action'=>'property','lyrics',$user['User']['unique']),array('class'=>'btn btn-default'));?></p>
        </div>
    </div>
        </div>
    </section>
</main>