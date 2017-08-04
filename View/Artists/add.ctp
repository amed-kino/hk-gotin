<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo __('Add');?></li>
        <li class="active"><?php echo __('Artist');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-artist">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-artist"></i></div>
                <div class="text-container">
                    <div class="title"><?php echo __('New artist'); ?></div>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Only Kurdish-Latin alphabet is allowed.'); ?></div>
                </div>
                
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body add-artist-body clearfix">
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
                                <?php echo __('%s lyrics',$artistExist['Artist']['lyric_counter']);?><br/>
                                <?php echo __('%s albums',$artistExist['Artist']['album_counter']);?>
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