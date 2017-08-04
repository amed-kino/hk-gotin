<div id="driver">
    <ol class="breadcrumb">
   <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($album['Artist']['name'],array('controller'=>'artists','action'=>'index', $album['Artist']['unique']),array());?></li>
    <li><?php echo $this->Html->link($album['Album']['title'].' ('.$album['Album']['year'].')',array('controller'=>'albums','action'=>'index', $album['Album']['unique']),array());?></li>
    <li class="active"><?php echo __('Add lyric'); ?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-lyric">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix">
                    <i class="glyphicon glyphicon-lyric"></i>
                </div>
                <div class="text-container">
                    <div class="details">
                        <?php echo __('New lyric'); ?><br/>
                        <span class="artist-name"><?php echo $album['Artist']['name'];?></span><br/>
            <span class="album-title"><?php echo $album['Album']['title'];?> (<?php echo $album['Album']['year'];?>)</span><br/>
                    </div>
                </div>
                <div class="action-content pull-right">
                    
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-repeat"></i> '.__('Change artist'),array('controller'=>'lyrics','action'=>'add'), array('class'=>'btn btn-primary btn-sm','escape' => FALSE));?>

                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body add-body clearfix">
             <?php echo $this->Form->create('Lyric'); ?>
    <fieldset>
    
    
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
        <p class="help-block">
            <?php echo __(' Source');?><br/>
            <?php echo __('The source of this is from : %s','');?>
        </p>
        <?php echo $this->Form->input('source',array('label'=>false,'class'=>'form-control'));?>                            
    </div>
    <div class="form-group">
        <?php
            $requestSubmit=array(
                'class'=>'btn btn-md btn-primary',
                'escape' => FALSE,
                'type' => 'submit',);
            echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i>  '.__('Save'), $requestSubmit);
        ?>        
    </div>
        <?php echo $this->Form->end(); ?>
	</fieldset>


        </div>
    </section>
</main>