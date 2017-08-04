<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link(__('Dashboard'),array('controller' => 'dashboard','action' => 'index'),array());?></li>
        <li class="active"><?php echo __('Public messages');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="dashboard-messages">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-envelope"></i></div>
                <div class="text-container clearfix">
			<div class="info">
	                    <div class="title"><?php echo __('Public messages');?></div>
                            <div class="tips">
                                <?php echo __('It is open for everyone to send their notes about mistakes and suggestions to our community.');?><br/>
                            </div>
                        </div>
                    
                </div>
                <div class="tips-downward row">
                    <div><?php echo __('%s messages',$publicMessages['all']);?></div>
                    <div>(<?php echo __('%s unreads',$publicMessages['unread']);?>)</div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            
            <div id="messages">
                <p>
                    <?php
                        echo $this->Paginator->counter(array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                    ?>
                </p>
                <?php foreach ($messages as $message): ?>
                   <?php echo $this->element('dashboard/public_messages_item',$message);?>
                <?php endforeach; ?>
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
                                            'model'=>'Message',
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