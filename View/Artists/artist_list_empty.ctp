<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');
}else{
    $Acl=null;
}
$imageUrl = FULL_BASE_URL.'/wene/logo.png';
echo $this->Html->meta(array('name' => 'description', 'content' => 'Rûpela tîpa ('.$letter.') ya hunermendên ku navê wan bi tîpa '.$letter.' dest pê dike. | Ev rûpel vala ye.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => $letter),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => $imageUrl),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li class="active"><?php echo $letter;?></li>
    </ol>
        <?php if($this->Session->check('Auth.User')):?>
            <div class="action dropdown">
                <button class="button dropdown-toggle btn btn-action" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i></button>
                <ul class="dropdown-menu pull-right">
                    <?php if($this->Session->check('Auth.User')):?>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-artist"></i> '.__('Add artist'),array('controller'=>'artists','action'=>'add'),array('escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add artist')));?></li>
                    <?php endif;?>
                </ul>
            </div>
        <?php else:?>
        <div class="request">
            <?php echo $this->Html->link('<i class="glyphicon glyphicon-hk-request"></i> <span class="hidden-xs">'.__('Request an artist').'</span>',array('controller'=>'requests','action'=>'artist'),array('class' => 'btn btn-default btn-action', 'escape' =>false, 'data-toggle' => 'tooltip' ,'data-placement' => 'top' ,'title' => __('Request an artist from HK.')));?>
        </div>
        <?php endif;?>
</div>
<main id="main" class="site-main" role="main">
    <section id="artist-letter">
        <header class="page-header">
            <div class="main-info">
                <div class="letter-container">
                    <span class="letter"><?php echo $letter;?></span>
                    <span class="results-count">(<?php echo __('Empty');?>)</span>
                </div>
            </div>
        </header>
        
        <div class="page-body artist-letter-body clearfix">
            <p class="not-found">
                <?php echo __('Sorry, but nothing matched %s.','<em>' . $letter . '</em>');?>
                    <?php echo __('Please try to send us your  request on %s .',$this->Html->link(__('Here'),array('controller'=>'requests','action'=>'artist')));?>
            </p>
        </div>
    </section>
</main>