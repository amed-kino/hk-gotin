<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
    <li><?php echo $this->Html->link($user['User']['name'],array('controller'=>'users','action' => 'profile',$user['User']['unique']));?></li>
    <li><?php echo $this->Html->link(__('Property'),array('controller'=>'users','action' => 'property',$user['User']['unique']));?></li>
    <li class="active"><?php echo __('Artist'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="property">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-artist"></i></div>
                <div class="text-container clearfix">
			<div class="information">
	                    <div class="title"><?php echo __('%s\'s property',$user['User']['name']); ?></div>
	                    <div class="description"><?php echo __('Artists'); ?> (<?php echo $this->Paginator->counter(array('format'=>'{:count}'));?>)</div>
                            <div class="tips"><span class="text-danger">*</span><?php echo __('%s means if the artist is availabe for public view.','<em>Available </em>');?></div>
			</div>
                    
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body property-body clearfix">
            <div class="property-navigator col-lg-12">
                <?php echo $this->Element('property/navigator',array('section'=>'artists'));?>
                <hr class="clearfix "/>
            </div>
           
            <div class="">
                <p>
                    <?php
                    echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                    ));
                    ?>	
                </p>
            </div>
            <div class="pull-right visible-xs"><i class="glyphicon glyphicon-resize-horizontal"></i></div>
            <div class="table-responsive">
        <table class="table col-lg-12 table-hover table-responsive" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('available'); ?></th>
			<th><?php echo $this->Paginator->sort('album_counter',__('Albums')); ?></th>
			<th><?php echo $this->Paginator->sort('lyric_counter',__('Lyrics')); ?></th>
			<th><?php echo $this->Paginator->sort('created',__('Created')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($artists as $artist): ?>
	<tr>
		
		<td><?php echo $this->Html->link($artist['Artist']['name'],array('controller'=>'artists','action'=>'index',$artist['Artist']['unique'])); ?>&nbsp;</td>
                <td align="center"><?php echo h($artist['Artist']['available']); ?>&nbsp;</td>
		<td align="center"><?php echo h($artist['Artist']['album_counter']); ?>&nbsp;</td>
		<td align="center"><?php echo h($artist['Artist']['lyric_counter']); ?>&nbsp;</td>
		<td><?php echo $this->Time->timeAgoInWords($artist['Artist']['created']);?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
        </div>
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
                                        'model'=>'Artist',
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