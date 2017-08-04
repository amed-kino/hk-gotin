<?php
$isEmtpy = false;
if (isset($artists) && $artists!=NULL){$isEmtpy = true;}

if (!isset($artists_params)){$artists_params['count']=0;};
if (!isset($albums_params)){$albums_params['count']=0;};
if (!isset($lyrics_params)){$lyrics_params['count']=0;};
if (!isset($key)){$key=NULL;}

echo $this->Html->meta(array('name' => 'description', 'content' => 'Rûpela lêgerîna hunermendan di nava malpera HuneraKurdî de, pirsa "'.$key.'" di nava HK de ('.$artists_params['count'].') Hunermend encam dan.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Pirsa "'.$key.'" di nava HK de.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-hk-logo.jpg'),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link(__('Search'),array('controller'=>'find','action'=>'index'),array());?></li>
        <li><?php echo $this->Html->link($key,array('controller'=>'find','action'=>'index','key' => $key),array());?></li>
        <li class="active"><?php echo __('Artists');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="find">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-search"></i></div>
                <div class="text-container">
                    <div class="title"><i class="glyphicon glyphicon-artist"></i> <?php echo __('Search for %s between artists','<em>'.$key.'</em>');?></div>
                        <div class="info">
                            <?php echo __('Results (%s)',$artists_params['count']);?><br/>
                        </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            <div class="search-header row">
                <div class="search-bar">
                    <?php echo $this->element('find/search_bar');?>
                </div>
                <div class="search-tabs">
                    <?php echo $this->element('find/search_tabs');?>
                </div>
            </div>
            <div id="search-main" class="page-content clearfix">
                <?php if ($artists_params['pageCount']!=0&&$artists_params['pageCount']!=1):?><p class="search-page-info"><?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></p><?php endif;?>
                <?php if ($isEmtpy == true):?>
        <?php endif;?>
        <div id="search-item-main-artist">
        <?php
        if ($isEmtpy == true){
            foreach ($artists as  $artist) {
                echo $this->element('find/search_item_artist',$artist);
            }                    
        }else{
            echo '<h5><i class="glyphicon glyphicon-warning-sign"></i> ',__('There is no matched artists to %s','<em>'.$key.'</em>'),'</h5>';
        }
        ?>
        <div class="clearfix"></div>
        </div>
        <?php if($artists_params['pageCount']!=0&&$artists_params['pageCount']!=1){echo $this->element('pagination');} ?>
                
            </div>
        </div>
    </section>
</main>