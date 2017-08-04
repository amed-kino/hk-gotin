<div class="meta-data clearfix">
    <?php 
    if ($lyric['User']['name']==null){$username=$lyric['User']['username'];}else{$username=$lyric['User']['name'];}
    $userLink=$this->Html->link(__('By %s',$username),array('controller'=>'users','action'=>'profile',$lyric['User']['unique']));
    ?>
    <div class="author item">
        <span   data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo __('By %s',$username);?>">
             <i class="glyphicon glyphicon-user"></i> 
              <?php echo $userLink;?> 
        </span>
    </div>


    <div class="view item">
        <span class="number" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo __('Seen %s times',$lyric['Lyric']['views']);?>">
            <i class="glyphicon glyphicon-eye-open"></i>
            <?php echo __('Seen %s times',$lyric['Lyric']['views']);?>
        </span>

    </div>
    <?php
        $user=$this->Session->read('Auth.user');
    if ($user['User']['time_zone']!=''){
        $time_zone=$lyric['User']['time_zone'];
    }
        else {$time_zone='GMT+2';}
    $postedOn = $this->Time->format(
        'd-m-Y',
        $lyric['Lyric']['created'],
        null
        );

    $postedOnFull = $this->Time->format('F jS, Y h:i A',$lyric['Lyric']['created'],null);
    ?>
    <div class="posted-on item">
        <time class="entry-date published" datetime="<?php echo $postedOnFull;?>" title="<?php echo $postedOnFull; ?>"></time>
        <span  data-toggle="tooltip" data-placement="top" title="<?php echo __('Posted on %s ',$postedOnFull);?>" data-original-title="">
            <i class="glyphicon glyphicon-calendar"></i>
            <?php echo __('Posted on %s ',$postedOn);?>
        </span>
    </div>
</div>