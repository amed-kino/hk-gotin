<?php
$user=$this->Session->read('Auth.User');
if ($user['time_zone']!=''){$time_zone=$user['time_zone'];}else{$time_zone='GMT+2';}
?>
<main id="main" class="site-main" role="main">
    <section id="lyrics-list">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-list"></i></div>
                <div class="text-container">
                    <div class="title"><?php echo __('My Lyrics');?></div>
                    <div class="tips"><?php echo __('These are lyrics that you had added.');?></div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body lyrics-list-body clearfix">
        <h4>
            <?php echo $this->Paginator->counter(array('format' => __('({:count})')));?>
        </h4>
        <p>
            <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>
        </p>
            <hr/>
        <table class="table" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('Artist.name'); ?></th>
			<th><?php echo $this->Paginator->sort('Album.title'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
                        <th><?php echo $this->Paginator->sort('views'); ?></th>

	</tr>
	</thead>
<?php foreach ($lyrics as $lyric): ?>
        <tr>
	
        <td><?php echo h($lyric['Artist']['name']); ?>&nbsp;</td>
        <td><?php echo h($lyric['Album']['title']); ?>&nbsp;</td>
        <td><?php echo $this->Html->link($lyric['Lyric']['title'],array('controller' => 'lyrics','action' =>'index',$lyric['Lyric']['unique'])); ?>&nbsp;</td>
        <td>
            <time class="entry-date published" datetime="<?php echo $this->Time->format('F jS, Y h:i A',$lyric['Lyric']['created'],null,$time_zone); ?>">
                <?php
                echo $this->Time->format(
                    'd-m-y',
                    $lyric['Lyric']['created'],
                    null,
                    $time_zone
                );
                ?>
            </time>
        </td>
        <td>
            <span class="action">
                <?php echo $this->Html->link(__('Edit'),array('controller'=>'lyrics','action'=>'edit',$lyric['Lyric']['unique']),array());?> |
                <?php echo $this->Form->postLink(__('Delete'), array('controller'=>'lyrics','action' => 'delete', $lyric['Lyric']['id']), array(), __('Are you sure you want to delete %s?', $lyric['Lyric']['title']));?>
            </span>
            <span class="text-muted"> <i class=" glyphicon glyphicon-eye-open"></i> (<?php echo h($lyric['Lyric']['views']); ?>)</span>
        </td>
        </tr>
<?php endforeach; ?>
        </table>
        <br/>
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
                                'model'=>'Lyric',
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
</div>
</section>
</main>