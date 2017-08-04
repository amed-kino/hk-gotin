<?php if ($this->Session->check('Auth.Acl')){$Acl=$this->Session->read('Auth.Acl');}else{$Acl=null;}?>
<div id="driver">
<ol class="breadcrumb">
<li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($lyric['Artist']['name'],array('controller'=>'artists','action'=>'index', $lyric['Artist']['unique']),array());?></li>
    <li><?php echo $this->Html->link($lyric['Album']['title'].' ('.$lyric['Album']['year'].')',array('controller'=>'albums','action'=>'index', $lyric['Album']['unique']),array());?></li>
    <li><?php echo $this->Html->link($lyric['Lyric']['title'],array('controller'=>'lyrics','action'=>'index', $lyric['Lyric']['unique']),array());?></li>
    <li class="active"><?php echo __('Edit'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="edit">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                    <?php echo $this->Html->image('berhem/cuk_'.$lyric['Album']['image']);?>
                </div>
               <div class="info">
                   <span class="artist-name">
                        <?php echo $lyric['Lyric']['title'];?></span><br/>
                   <span class="artist-name">
                        <?php echo $lyric['Artist']['name'];?></span><br/>
                    <span class="album-title">
                        <?php echo $lyric['Album']['title'];?></span>
                    <span class="album-year">(<?php echo $lyric['Album']['year'];?>)</span><br/>
                    <div class="tips"></div>
               </div>
                <div class="information">
                    <div class="pull-right links">
                        <?php if ($Acl['Artist'][3] || $lyric['Artist']['user_id']==$this->Session->read('Auth.User.id')){echo $this->Form->postLink('<i class="glyphicon glyphicon-remove small"></i> '.__('Delete'), array('controller'=>'lyrics','action' => 'delete', $lyric['Lyric']['id']), array('class'=>'action-delete', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('delete %s',$lyric['Lyric']['title']) ,'escape' => false,'class' => 'btn btn-xs btn-danger'), __('Are you sure you want to delete %s?', $lyric['Lyric']['title']));}?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body edit-body clearfix">


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
                                $artistSaver=array(
                                        'label'=>__('Save'),
                                        'class'=>'btn btn-md btn-primary'
                                    );

                                echo $this->Form->end($artistSaver); 
                                ?>
                </div>    
</fieldset>


            
           
        </div>
    </section>
</main>