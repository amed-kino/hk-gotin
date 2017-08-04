<?php
if (!isset($artists_params)){$artists_params['count']=0;};
if (!isset($albums_params)){$albums_params['count']=0;};
if (!isset($lyrics_params)){$lyrics_params['count']=0;};
if (!isset($key)){$key=NULL;}

echo $this->Html->meta(array('name' => 'description', 'content' => 'Rûpela lêgerînê di nava malpera HuneraKurdî.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Lêgerîn.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-hk-logo.jpg'),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link(__('Search'),array('controller'=>'find','action'=>'index'),array());?></li>
        <li class="active"><?php echo $key;?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="find">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-search"></i></div>
                <div class="text-container">
                        <div class="title"><?php echo __('Search for %s','<em>'.$key.'</em>');?></div>
                        <div class="info">
                            <?php echo __('Results (%s)',0);?><br/>
                            <?php echo __('Nothing found!');?>
                        </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            <header class="search-header">
                <?php echo $this->element('find/search_bar');?>
            </header>
            
            <p><?php echo __('Nothing found for %s keyword!','<em class="big">'.$key.'</em>');?></p>
            
        </div>
    </section>
</main>