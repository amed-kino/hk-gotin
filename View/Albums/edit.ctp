<?php
$albumYear = $album['Album']['title'].$this->HK->albumYear($album['Album']['year']);
?>
<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($album['Artist']['name'],array('controller'=>'artists','action'=>'index', $album['Artist']['unique']),array());?></li>
    <li><?php echo $this->Html->link($album['Album']['title'].$this->HK->albumYear($album['Album']['year']),array('controller'=>'albums','action'=>'index', $album['Album']['unique']),array());?></li>
    <li class="active"><?php echo __('Edit'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="edit">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                    <?php echo $this->Html->image('cuk/berhem/'.$album['Album']['image']);?>
                </div>
               <div class="info">
                   <?php echo __('Edit %s','<em>'.$albumYear.' - '.$album['Artist']['name'].'</em>');?>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Only Kurdish-Latin alphabet is allowed.'); ?></div>
               </div>
                <div class="information">
                    <div class="pull-right links">
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-picture"></i> '.__('Change photo'),array('controller' => 'albums', 'action' => 'add','photo',$album['Album']['unique']),array('escape'=>false,'class' => 'btn btn-sm btn-default btn-action','data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Change photo for album %s.',$albumYear.' - '.$album['Artist']['name'])));?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> '.__('Add lyric'),array('controller'=>'lyrics','action'=>'add' ,'album' ,$album['Album']['unique']),array('class' => 'btn btn-sm btn-default btn-action','escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to %s.',$albumYear.' - '.$album['Artist']['name'])));?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body edit-body clearfix">
            
                    <?php echo $this->Form->create('Album'); ?>        
                    <div class="form-group">
                        <p class="help-block"><?php echo __('Album Title');?></p>
                        <?php echo $this->Form->input('title',array('label'=>false,'class'=>'form-control'));?>
                        <?php echo $this->Form->input('without-photo-board',array('type'=>'hidden','value'=>true));?>   
                    </div>
                    <div class="form-group">
                        <p class="help-block"><?php echo __('Album Year');?></p>
                        <?php echo $this->Form->input('year',array('label'=>false,'class'=>'form-control'));?>
                    </div>
                    
                    <div class="form-group">
                    <?php
                        $requestSubmit=array(
                            'class'=>'btn btn-md btn-primary',
                            'escape' => FALSE,
                            'type' => 'submit',);
                        echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i> '.__('Save'), $requestSubmit);
                        
                        echo $this->Form->end();?>
                    </div>
                
           
        </div>
    </section>
</main>