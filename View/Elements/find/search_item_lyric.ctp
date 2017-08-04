<div class="lyric-block media">
        <div class="description media-left">
            <i class="glyphicon glyphicon-artist"></i> <?php echo $this->Html->link($Artist['name'],array('controller' => 'artists','action'=>'index',$Artist['unique']),array());?><br/>
            <i class="glyphicon glyphicon-album"></i> <?php echo $this->Html->link($Album['title'],array('controller' => 'albums','action'=>'index',$Album['unique']),array());?><br/>
            <?php echo $Album['year'];?>
        </div>
        <div class="content media-body">
            <div class="title">
                <i class="glyphicon glyphicon-lyric"></i> 
                    <?php
                    $titleLink = $this->Html->link($Lyric['title'],array('controller'=>'lyrics','action'=>'index',$Lyric['unique']));
                    echo $this->Text->highlight($titleLink,$key, array('format' => '<span class="search-highlight">'.$key.'</span>','html'=>true));
                    ?>
                
            </div>
            <div class="excerpt">
            <?php      
            $text = htmlspecialchars_decode(str_replace('</br>',' ',$this->Text->excerpt(h($Lyric['text'],$key))));    
            $text_c = $this->Text->highlight($text,$key, array('format' => '<span class="search-highlight">'.$key.'</span>','html'=>false));
            echo $text_c;
                if ($User['name']==null){$username=$User['username'];}else{$username=$User['name'];}
                $userLink = $this->Html->link($username,array('controller'=>'users','action'=>'profile',$User['unique']));
                $date=$this->Time->format(
                            'd-m-Y',
                            $Lyric['created'],
                            null
                    );
            ?>
            
            </div>
            <div class="meta">
                <i class="glyphicon glyphicon-eye-open"></i><?php echo $Lyric['views']; ?> | <i class="glyphicon glyphicon-user"></i><?php echo $userLink; ?> | <i class="glyphicon glyphicon-calendar small"></i><?php echo $date; ?>
            </div>
        </div>
</div>