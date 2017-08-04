<div class="entry-action clearfix">
    <div class="edit-history col-lg-12 clearfix">      
        <?php
        if ($lyric['Lyric']['lyric_edit_counter']!=0){
            $counts = ($lyric['Lyric']['lyric_edit_counter'])-1;
            echo ' <div class="pull-left"><i class="glyphicon glyphicon-lyric-recent-edit"></i></div><div class="pull-left">'.__('This Lyric has beend updated '),
                 __n('one time ', '%s times ',$counts,$counts),'<br/>',
                    $this->Html->link(__('Edit history'),array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique']),array('escape' => false)),
                '</div>';
            
        }
        ?>
        <div class="clearfix"></div>
    </div> 
</div>


<?php
if (isset($lyric['Lyric']['editors']) && $lyric['Lyric']['editors']!=''){

    echo '<span class="editors">';

    $editorsArrayLength = sizeof($editors);
    $editorsString = '';
    $i=1;

    foreach ($editors as $editor) {
        $editorLink = $this->Html->link($editor['User']['name'],array('controller' => 'users', 'action' => 'profile', $editor['User']['unique']));
        $editorsString .= $editorLink;
        if ($i != $editorsArrayLength){
            $editorsString .= ' ';
        }
        $i++;
    }

    echo __('Editors : %s',$editorsString);




    echo '</span>';
}
?>