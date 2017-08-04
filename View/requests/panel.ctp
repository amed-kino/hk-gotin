<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Requests'),array('controller'=>'requests','action' => 'index'));?></li>
    <li class="active"><?php echo __('Requests panel'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="request">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container ">
                    <i class="glyphicon glyphicon-hk-request"> </i>
                </div>
                <div class="text-container ">
                    <div class="title">
                        <?php echo __('Requests panel');?>
                    </div>
                    <?php if($this->Session->check('Auth.User')): ?>
                        <div class="visibility ">
                            <?php echo __('Visibility of request means that the request is available for public review.');?>
                            <div class="icons ">
                               <i class="error small glyphicon glyphicon-eye-close"> </i> <?php echo __('Unvisible request');?><br/>
                               <i class="success small glyphicon glyphicon-eye-open"></i> <?php echo __('Visible request');?><br/>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
        <p><?php echo __('Sort List by');?>:</p>
         <ul class="sort-list">
            <?php if ($this->Session->check('Auth.User')){echo "<li>",$this->Paginator->sort('public'),"</li>";}?>
            <li class="sort-list"><?php echo $this->Paginator->sort('type'); ?></li>
            <li><?php echo $this->Paginator->sort('name'); ?></li>
            <li><?php echo $this->Paginator->sort('created'); ?></li>
         </ul>
        <p>
            <?php
                echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
            ?>
        </p>
        <hr class="clearfix" />
        <div id="requests">
	<?php foreach ($requests as $request): ?>
            <?php echo $this->element('request/request_item_panel',$request);?>
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
                                        'model'=>'Request',
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
