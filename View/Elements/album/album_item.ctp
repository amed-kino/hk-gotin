<?php 
    
    $allPlayerLink = FALSE;
    $allPlayerN = 0;
    foreach($Lyric as $lyrics):
        $lyricUri = array('artist' => $album['Artist']['name'], 'album'  => $album['Album']['title'],'year'   => $album['Album']['year'],'title'  => $lyrics['title']);
        $lyricUrl = FULL_BASE_URL.'/gotin'.$this->HK->uri($lyricUri);

        $passedData = array(
            'Acl' => $Acl, 
            'lyrics' => $lyrics,
            'lyricUri' => $lyricUri,
            'lyricUrl' => $lyricUrl
        );

        echo $this->element('album/lyric_item',$passedData);
        if ($lyrics['file'] != null){
            $allPlayerLink = TRUE;
            $allPlayerN ++;
        }

    endforeach;
    
    
?>
<?php if ($allPlayerLink == TRUE):?>
    <div class="hk-player-play-all">
        <?php 
            echo $this->Html->link(            
                sprintf(' <i class="glyphicon glyphicon-hk-player"></i> '.__n('Play the only song with HK-Player', 'Play all %s songs with HK-Player',$allPlayerN, $allPlayerN),1),                    
                array('controller' => 'album','plugin' => 'player',$albumUnique),
                array('escape' => false)
            );
            ?>
    </div>
<?php endif; ?>
