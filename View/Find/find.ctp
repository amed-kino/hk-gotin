<?php
if (!isset($artists_params)){$artists_params['count']=0;};
if (!isset($albums_params)){$albums_params['count']=0;};
if (!isset($lyrics_params)){$lyrics_params['count']=0;};
if (!isset($key)){$key=NULL;}

echo $this->Html->meta(array('name' => 'description', 'content' => 'Rûpela lêgerînê di nava malpera HuneraKurdî de, pirsa "'.$key.'" di nava HK de: ('.$lyrics_params['count'].') Stranan - ('.$albums_params['count'].') Berheman - ('.$artists_params['count'].') Hunermendan heye.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Pirsa "'.$key.'" di nava malperê de.'),'',array('inline'=>false));
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
                            <?php echo __('Results (%s)',$artists_params['count'] + $albums_params['count'] + $lyrics_params['count']);?><br/>
                            <?php echo __('Artists');?> (<?php echo $artists_params['count'];?>) - 
                            <?php echo __('Albums');?> (<?php echo $albums_params['count'];?>) - 
                            <?php echo __('Lyrics');?> (<?php echo $lyrics_params['count'];?>) 
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
            <div id="search-main" class="page-content row clearfix">
                <?php
                            
                if (isset($lyrics) && $lyrics!=null){
                    echo '<div class="col-lg-12 general-block clearfix">';
                    foreach ($lyrics as $lyric){
                       echo $this->element('find/search_item_lyric',$lyric);
                        unset($lyric); 
                    }
                    if ($lyrics_params['count']>5){
                        echo '<div class="lyric-read-more">';
                    echo $this->Html->link(__('View more %s lyrics',($lyrics_params['count']-5)),array('controller'=>'find','action'=>'index','section'=>'lyrics','key'=>$key),array('class' => 'btn btn-md btn-primary'));
                        echo '</div>';
                    }
                    echo "</div>";
                }

                if (isset($albums) && $albums!=null){
                    echo '<div class="col-lg-12 general-block clearfix">';
                    foreach ($albums as $albumKey => $album){
                       echo $this->element('find/search_item_album',$album);
                        
                         unset($album);
                    }
                    if ($albums_params['count']>5){
                        echo '<div class="album-read-more album-block col-lg-4 col-md-6 col-sm-6 col-xs-6 ">';
                    echo $this->Html->link(__('View more %s albums',($albums_params['count']-5)),array('controller'=>'find','action'=>'index','section'=>'albums','key'=>$key),array('class' => 'btn btn-md btn-primary'));
                        echo '</div>';
                    }
                    echo "</div>";
                }
                ?>            
                <?php
                if (isset($artists) && $artists!=null){
                    echo '<div class="col-lg-12 general-block clearfix">';
                    foreach ($artists as $artist){
                        echo $this->element('find/search_item_artist',$artist);
                        unset($artist);
                    }
                    if ($artists_params['count']>5){
                        echo '<div class="artist-read-more artist-block col-lg-4 col-md-6 col-sm-6 col-xs-6">';
                        echo $this->Html->link(__('View more %s artists',($artists_params['count']-5)),array('controller'=>'find','action'=>'index','section'=>'artists','key'=>$key),array('class' => 'btn btn-md btn-primary'));
                        echo '</div>';
                    }
                    echo '</div>';
                }
                ?>
                <?php
                if (isset($key)){
                    if ($artists==null && $albums==null && $lyrics==null){
                        echo "<h3>",__('Nothing found!'),"</h3>"
                                . "<p>",__('Nothing were found in database,please try another keyword.'),"</p>";
                    }
                }else{
                        echo "<h3>",__('Specify keyword'),"</h3>"
                                . "<p>",__('Please write your keyword for seaching.'),"</p>";
                }
               
                ?>
            </div>
        </div>
    </section>
</main>