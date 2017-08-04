<aside id="sidebar-latest" class="panel-sidebar">
    <div class="panel-heading hidden-sm hidden-xs">
        <h3 class="panel-title"><?php echo __('Latest Lyrics');?>:</h3>
    </div>
    <div class="panel-heading title-sm visible-sm visible-xs" data-toggle="collapse" data-target=".sidebar-latest-body">
        <span class="pull-left">
            <span class="sr-only"><?php echo __('Toggle navigation');?></span>
            <i class="glyphicon glyphicon-list"></i>
        </span>
    <h3 class="panel-title"><?php echo __('Latest Lyrics');?>:</h3>
    </div>
    <div class="panel-body sidebar-latest-body collapse coll-able">
            <?php
            $latest = $this->requestAction(array('controller'=>'lyrics','action'=>'latestAdd'));
                foreach($latest as $late){
                    
                $uri = array(
                        'artist' => $late['Artist']['name'],
                        'album'  => $late['Album']['title'],
                        'year'   => $late['Album']['year'],
                        'title'  => $late['Lyric']['title'],
                    );
                $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
                $link=$late['Artist']['name']." - ".$late['Lyric']['title'];

                echo    '<p class="item overflow-fade">',
                            $this->Html->link($link,$url,
                                 array()
                                     ),
                            " <span class=\"date\">(".$this->Time->timeAgoInWords($late['Lyric']['created']).")</span>",
                        '</p>';
                }
            ?>
    </div>
</aside>
<aside id="sidebar-popular" class="panel-sidebar">
    <div class="panel-heading hidden-sm hidden-xs">
    <h3 class="panel-title"><?php echo __('Popular Lyrics');?>:</h3>
    </div>
    <div class="panel-heading title-sm visible-sm visible-xs" data-toggle="collapse" data-target=".sidebar-popular-body">
        <span class="pull-left">
            <span class="sr-only"><?php echo __('Toggle navigation');?></span>
            <i class="glyphicon glyphicon-list"></i>
        </span>
    <h3 class="panel-title"><?php echo __('Popular Lyrics');?>:</h3>
    </div>
    <div class="panel-body sidebar-popular-body collapse coll-able">
            <?php

                $popular=$this->requestAction(array('controller'=>'lyrics','action'=>'popular'));
                foreach($popular as $pop){
                                    
                    $uri = array(
                        'artist' => $pop['Artist']['name'],
                        'album'  => $pop['Album']['title'],
                        'year'   => $pop['Album']['year'],
                        'title'  => $pop['Lyric']['title'],
                    );
                    
                    $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
                    $link=$pop['Artist']['name']." - ".$pop['Lyric']['title'];
                    
                    echo    '<p class="item overflow-fade">',
                                $this->Html->link($link,$url,
                                    array()),
                                " <span class=\"count\">(".($pop['Lyric']['views']).")</span>",
                            '</p>';
                }
            ?>
    </div>
</aside>
<aside id="sidebar-recent-edited" class="panel-sidebar">
    
    <div class="panel-heading hidden-sm hidden-xs">
    <h3 class="panel-title"><?php echo __('Recent Edited Lyrics');?>:</h3>
    </div>
    
    <div class="panel-heading title-sm visible-sm visible-xs" data-toggle="collapse" data-target=".sidebar-recent-edited-body">
    <span class="pull-left">
        <span class="sr-only"><?php echo __('Toggle navigation');?></span>
        <i class="glyphicon glyphicon-list"></i>
    </span>
    <h3 class="panel-title"><?php echo __('Recent Edited Lyrics');?>:</h3>
    </div>
    <div class="panel-body sidebar-recent-edited-body collapse coll-able">
            <?php

                $edited=$this->requestAction(array('controller'=>'lyrics','action'=>'recentEdit'));
                foreach($edited as $edi){
                    
                    $uri = array(
                        'artist' => $edi['Artist']['name'],
                        'album'  => $edi['Album']['title'],
                        'year'   => $edi['Album']['year'],
                        'title'  => $edi['Lyric']['title'],
                    );
                    
                    $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
                    $link=$edi['Artist']['name']." - ".$edi['Lyric']['title'];
                    
                    echo    '<p class="item overflow-fade">',
                                $this->Html->link($link,$url,
                                    array()),
                                " <span class=\"date\">(".$this->Time->timeAgoInWords($edi['Lyric']['modified']).")</span><br/>",
                            '</p>';
                }
            ?>
    </div>
</aside>