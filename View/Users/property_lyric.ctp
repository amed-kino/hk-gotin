<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
        <li><?php echo $this->Html->link($user['User']['name'],array('controller'=>'users','action' => 'profile',$user['User']['unique']));?></li>
        <li><?php echo $this->Html->link(__('Property'),array('controller'=>'users','action' => 'property',$user['User']['unique']));?></li>
        <li class="active"><?php echo __('Lyric'); ?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="property">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-lyric"></i></div>
                <div class="text-container clearfix">
			<div class="information">
	                    <div class="title"><?php echo __('%s\'s property',$user['User']['name']); ?></div>
	                    <div class="description"><?php echo __('Lyrics'); ?> (<?php echo $this->Paginator->counter(array('format'=>'{:count}'));?>)</div>
                            <div class="tips"><span class="text-danger">*</span><?php echo __('%s means if the lyric is availabe for public view.','<em>Available </em>');?></div>
			</div>
                    
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body property-body clearfix">
            <div class="property-navigator col-lg-12">
                <?php echo $this->Element('property/navigator',array('section'=>'lyrics'));?>
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
            <table class="table table-hover" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
                        <th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('album_id',__('Album')); ?></th>
			<th><?php echo $this->Paginator->sort('artist_id',__('Artist')); ?></th>
			<th><?php echo $this->Paginator->sort('created',__('Created')); ?></th>
			<th><?php echo $this->Paginator->sort('views',__('Views')); ?></th>
			<th><?php echo $this->Paginator->sort('available'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($lyrics as $lyric): ?>
	<tr>
                <td><?php echo $this->Html->link($lyric['Lyric']['title'],array('controller'=>'lyrics','action'=>'index',$lyric['Lyric']['unique'])); ?>&nbsp;</td>
		<td>
                    <?php echo $this->Html->link($lyric['Album']['title'].' '.$this->HK->albumYear($lyric['Album']['year']).' ', array('controller' => 'albums', 'action' => 'index', $lyric['Album']['unique'])); ?>
                     
		</td>
		<td>
			<?php echo $this->Html->link($lyric['Artist']['name'], array('controller' => 'artists', 'action' => 'view', $lyric['Artist']['id'])); ?>
		</td>
		
		<td><?php echo $this->Time->timeAgoInWords(($lyric['Lyric']['created'])); ?>&nbsp;</td>
		<td><?php echo h($lyric['Lyric']['views']); ?>&nbsp;</td>
		<td><?php echo h($lyric['Lyric']['available']); ?>&nbsp;</td>

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


<main id="main" class="site-main" role="main">
    <section id="user-property">
        <header class="property-lyric-header property-header ">
            
        </header>
        <div class="col-lg-12">
            
                <div class="information col-lg-12">
            <div class="tips">
                
                
            </div>
        </div>
	 
	
	

        </div>
    </section>
</main>