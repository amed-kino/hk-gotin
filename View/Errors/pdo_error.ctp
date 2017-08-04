<main id="main" class="site-main" role="main">
    <section id="error">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-warning-sign"></i></div>
                <div class="text-container">
			<div class="info clearfix">
	                    <div class="title"><?php echo __d('cake_dev', 'Database Error'); ?></div>
			</div>
                    <div class="description col-lg-12">
                        <p class="error">
                            <?php echo __d('cake_dev', 'Error'); ?>:
                            <?php echo $message; ?>
                        </p>
                        <?php if (!empty($error->queryString)) : ?>
                                <p class="notice">
                                        <?php echo __d('cake_dev', 'SQL Query'); ?>:
                                        <?php echo h($error->queryString); ?>
                                </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            <?php if (!empty($error->params)) : ?>
		<?php echo __d('cake_dev', 'SQL Query Params'); ?>:
		<?php echo Debugger::dump($error->params); ?>
            <?php endif; ?>
                <?php echo $this->element('exception_stack_trace'); ?>
        </div>
    </section>
</main>