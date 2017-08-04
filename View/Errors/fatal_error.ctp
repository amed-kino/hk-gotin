<main id="main" class="site-main" role="main">
    <section id="error">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-warning-sign"></i></div>
                <div class="text-container">
			<div class="info clearfix">
	                    <div class="title"><?php echo __d('cake_dev', 'Fatal Error'); ?></div>
			</div>
                    <div class="description col-lg-12">
                        <p class="error">
                                <?php echo __d('cake_dev', 'Error'); ?>:
                                <?php echo h($error->getMessage()); ?>
                                <br>

                                <?php echo __d('cake_dev', 'File'); ?>: 
                                <?php echo h($error->getFile()); ?>
                                <br>

                                <?php echo __d('cake_dev', 'Line'); ?>: 
                                <?php echo h($error->getLine()); ?>
                        </p>

                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
        <p class="notice">
            <?php echo __d('cake_dev', 'Notice'); ?>: 
            <?php echo __d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR . DS . 'View' . DS . 'Errors' . DS . 'fatal_error.ctp'); ?>
        </p>
            <?php
            if (extension_loaded('xdebug')) {
                    xdebug_print_function_stack();
            }
            ?>
        </div>
    </section>
</main>