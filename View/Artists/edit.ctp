<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
        <li><?php echo $this->Html->link($artist['Artist']['name'],array('controller'=>'artists','action'=>'index', $artist['Artist']['unique']),array());?></li>
        <li class="active"><?php echo __('Edit'); ?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="edit">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                <?php echo $this->Html->image('cuk/hunermend/'.$artist['Artist']['image']);?>
                </div>
               <div class="info">
                   <?php echo __('Edit %s','<em>'.$artist['Artist']['name'].'</em>');?>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Only Kurdish-Latin alphabet is allowed.'); ?></div>
               </div>
                <div class="information">
                    <div class="pull-right links">
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-picture"></i> '.__('Change photo'),array('controller' => 'artists', 'action' => 'add','photo',$artist['Artist']['unique']),array('escape'=>false,'class' => 'btn btn-sm btn-default btn-action','data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Change photo for artist %s.',$artist['Artist']['name'])));?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-album"></i> '.__('Add album'),array('controller'=>'albums','action'=>'add', $artist['Artist']['unique']),array('class' => 'btn btn-sm btn-default btn-action','escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add album to %s.',$artist['Artist']['name'])));?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> '.__('Add lyric'),array('controller'=>'lyrics','action'=>'add' ,'artist' ,$artist['Artist']['unique']),array('class' => 'btn btn-sm btn-default btn-action','escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to %s.',$artist['Artist']['name'])));?>
                    </div>
                </div>
                
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body edit-body clearfix">
           <?php echo $this->Form->create('Artist'); ?>
                    <div class="add-entries clearfix">
                        <div class="form-group">
                            <p class="help-block"><?php echo __('Artist Name');?></p>
                            <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control'));?>

                        </div>
                        <div class="form-group">
                            <?php
                            $requestSubmit=array(
                                'class'=>'btn btn-md btn-primary',
                                'escape' => FALSE,
                                'type' => 'submit',);
                            echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i> '.__('Save'), $requestSubmit);
                            ?> 
                        </div>
                    </div>
            <?php if ($artistExists ==true):?>
                    <div class="existed col-lg-12">
                        <div class="media">
                            <div class="media-left">
                                    <div class="pull-left"><img src="/wene/cuk/hunermend/<?php echo $artistExist['Artist']['image'];?>" width="80" height="80" alt=""></div>
                            </div>
                            <div class="media-body">
                                <div class="page-title">
                                    
                                    <?php
                                        $artistUri = array('artist' => $artistExist['Artist']['name'],);                    
                                        $artistUrl = FULL_BASE_URL.'/hunermend'.$this->HK->uri($artistUri);
                                        echo $this->Html->link($artistExist['Artist']['name'],$artistUrl,array());
                                    ?>
                                </div>
                                <?php echo __('%s lyrics','<em>'.$artistExist['Artist']['lyric_counter'].'</em>');?><br/>
                                <?php echo __('%s albums','<em>'.$artistExist['Artist']['album_counter'].'</em>');?>
                            </div>
                            <div class="media-bottom">
                                <span class="posted-on">
                                    <?php
                                        $user=$this->Session->read('Auth.user');
                                    if ($user['User']['time_zone']!=''){
                                        $time_zone=$artistExist['User']['time_zone'];
                                    }
                                        else {$time_zone='GMT+2';}
                                    ?>
                                    <time class="entry-date published" datetime="<?php echo $this->Time->format('F jS, Y h:i A',$artistExist['Artist']['created'],null); ?>" title="<?php echo $this->Time->format('F jS, Y h:i A',$artistExist['Artist']['created'],null); ?>">
                                        <?php
                                        $postedOn = $this->Time->format(
                                            'd-m-Y',
                                            $artistExist['Artist']['created'],
                                            null

                                            );
                                        ?>
                                    </time>
                                    <?php echo '<i class="glyphicon glyphicon-calendar"></i> ',__('Posted on %s ',$postedOn),',';?>
                                </span>
                                <span class="author">    
                                    <?php
                                         
                                         $userLink=$this->Html->link($artistExist['User']['name'],array('controller'=>'users','action'=>'profile',$artistExist['User']['unique']));
                                         echo '<i class="glyphicon glyphicon-user"></i>  ',__('By %s',$userLink);
                                    ?>
                                 </span>
                                
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
        </div>
    </section>
</main>


