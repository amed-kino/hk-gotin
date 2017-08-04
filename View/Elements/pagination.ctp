<?php
if ($active=='artist'){$model='Artist';}
elseif ($active=='album'){$model='Album';}
elseif ($active=='lyric'){$model='Lyric';}
$this->Paginator->options['url']['key'] = $key;
?><nav>
  <ul class="pagination">
    <li>
        <?php echo $this->Paginator->prev(
                '<span aria-hidden="true">&laquo;</span>', 
                array('escape'=>false,'aria-label' => 'Previous','class' => 'prev'),
                '<span aria-hidden="true">&laquo;</span>',
                array('escape'=>false,'aria-label' => 'Previous','class' => 'prev disabled'));
        ?>
    </li>
        <?php

            echo $this->Paginator->numbers(
                            array(
                                'currentTag' => 'xiri amed',
                                'model'=>$model,
                                'separator' => '',
                                'currentClass'=>'active',
                                'tag'=>'li'
                                ));
        ?>
    <li>
        <?php echo $this->Paginator->next(
                '<span aria-hidden="true">&raquo;</span>', 
                array('escape'=>false,'aria-label' => 'Next','class' => 'prev'),
                '<span class="disabled" aria-hidden="true">&raquo;</span>',
                array('escape'=>false,'aria-label' => 'Next','class' => 'prev disabled'));
        ?>
    </li>
  </ul>
    
</nav>