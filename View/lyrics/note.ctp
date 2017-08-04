<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');
}else{
    $Acl=null;
    
}

$artistUri = array(
    'artist' => $lyric['Artist']['name'],
);                    
$artistUrl = FULL_BASE_URL.'/hunermend'.$this->HK->uri($artistUri);

$albumUri = array(
                'artist' => $lyric['Artist']['name'],
                'album'  => $lyric['Album']['title'],
                'year'   => $lyric['Album']['year'],
            );                  
$albumUrl = FULL_BASE_URL.'/berhem'.$this->HK->uri($albumUri,'album');

$lyricUri = array(
                'artist' => $lyric['Artist']['name'],
                'album'  => $lyric['Album']['title'],
                'year'   => $lyric['Album']['year'],
                'title'   => $lyric['Lyric']['title'],
            );                  
$lyricUrl = FULL_BASE_URL.'/gotin'.$this->HK->uri($lyricUri,'lyric');
?>
<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($lyric['Artist']['name'],$artistUrl,array());?></li>
    <li><?php echo $this->Html->link($lyric['Album']['title'].' ('.$lyric['Album']['year'].')',$albumUrl,array());?></li>            
    <li><?php echo $this->Html->link($lyric['Lyric']['title'],$lyricUrl,array());?></li>
    <li class="active"><?php echo __('Send a note');?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="lyric-note">
        <header class="page-header clearfix">
            <div class="main-info clearfix">
                <div class="icon-container clearfix">
                    <i class="glyphicon glyphicon-envelope"></i>
                </div>
                <div class="text-container">
                    <div class="title">
                        <?php echo __('Inform a mistake');?><br/>
                        <?php echo $lyric['Artist']['name'],'-',$lyric['Lyric']['title'];?>
                    </div>

                </div>
            </div>
                    <div class="tips-downward">
                        <?php echo __('Your correction note will be sent to %s to be checked.','<strong>'.$lyric['User']['name'].'</strong>');?><br/>
                        <?php echo __('You can be a part of HK comunity and correct it with your name'),' ',$this->Html->link(__('Signup'),array('controller'=>'users','action'=>'signup')),' .';?>
                    </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body lyric-note-body clearfix">
            <p><?php echo __('This information will be kept secret, and this message is sent just to the user.');?></p>

    <?php echo $this->Form->create('Request');?> 
        
        <div class="col-md-5 clearfix">
            <div class="form-group">
                <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control','placeholder'=>__('Your Name')));?>
            </div>
            <div class="form-group">    
                <?php echo $this->Form->input('email',array('label'=>false,'class'=>'form-control','placeholder'=>__('Your Email')));?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group input text required">
                <?php echo $this->Form->input('data',array('type'=>'textarea','label'=>false,'class'=>'form-control','placeholder'=>__('Your request message.'),'rows'=>'4','maxlength' => 255));?>
            </div>
            <div class="form-group">
                <?php
                    $requestSubmit=array(
                        'class'=>'btn btn-md btn-primary',
                        'escape' => FALSE,
                        'type' => 'submit',);
                    echo $this->Form->button(' <i class="glyphicon glyphicon-envelope"></i>  '.__('Inform'), $requestSubmit);
                ?> 
            </div>
        </div>
            <?php echo $this->Form->end();?> 
        </div>
    </section>
</main>
