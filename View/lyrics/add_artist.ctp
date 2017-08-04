<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');
}else{
    $Acl=null;
}
?>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($artist['Artist']['name'],array('controller'=>'artists','action'=>'index', $artist['Artist']['unique']),array());?></li>
    <li class="active"><?php echo __('Add lyric'); ?></li>
</ol>
<main id="main" class="site-main" role="main">
    <section id="lyric-artist-add">
        <header class="page-header">
            <span class="title"><i class="glyphicon glyphicon-lyric-add"></i> <?php echo __('Add Album');?></span><br/>
            <span class="artist-name"><?php echo $artist['Artist']['name'];?></span><br/>
            
            <span class="pull-right">
                <?php echo $this->Html->link(__('Change artist'),array('controller'=>'lyrics','action'=>'add'), array('class'=>''));?>
            </span>
        </header>
        <div class="page-content">
            <div class="col-lg-10">



    <div class="lyrics form">
    <?php echo $this->Form->create('Lyric'); ?>
    <fieldset>
    <div class="form-group">
    <p class="help-block"><?php echo __('Album');?></p>
    <?php echo $this->Form->input('album_id',array('label'=>false,'class'=>'form-control'));?>
    <p class="help-block"><?php echo __('Your album is not existed?');?> 
    <?php echo $this->Html->link(__('Add Album'),array('controller'=>'albums','action'=>'add',$artist['Artist']['unique']), array('class'=>''));?>
    </p>
    <hr/>
    </div>

    <div class="form-group">
    <p class="help-block"><?php echo __(' Title');?></p>
    <?php echo $this->Form->input('title',array('label'=>false,'class'=>'form-control'));?>                            
    </div>

    <div class="form-group">
    <p class="help-block"><?php echo __(' Writer');?></p>
    <?php echo $this->Form->input('writer',array('label'=>false,'class'=>'form-control'));?>                            
    </div>

    <div class="form-group">
    <p class="help-block"><?php echo __('Composer');?></p>
    <?php echo $this->Form->input('composer',array('label'=>false,'class'=>'form-control'));?>                            
    </div>

    <div class="form-group">
    <p class="help-block"><?php echo __(' # (Track-Number)');?></p>
    <?php echo $this->Form->input('echelon',array('min' => 1,'max' => 35,'label'=>false,'class'=>'form-control'));?>                            
    </div>

    <div class="form-group">
    <p class="help-block"><?php echo __(' Text');?></p>
    <?php echo $this->Form->input('text',array('label'=>false,'class'=>'form-control'));?>                            
    </div>

    <div class="form-group">
    <p class="help-block"><?php echo __(' Source');?></p>
    <?php echo $this->Form->input('source',array('label'=>false,'class'=>'form-control'));?>                            
    </div>
                <div class="form-group">
                                <?php
                                $artistSaver=array(
                                        'label'=>__('Save'),
                                        'class'=>'btn btn-md btn-primary'
                                    );

                                echo $this->Form->end($artistSaver); 
                                ?>
                </div>    
    </fieldset>

    </div>                        


            </div>
            <div class="col-lg-2"></div>
        </div>
    <div class="clearfix"></div>
    </section> 
</main>