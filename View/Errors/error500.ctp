<main id="main" class="site-main" role="main">
    <section id="error">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-warning-sign"></i></div>
                <div class="text-container">
			<div class="info clearfix">
	                    <div class="title"><?php echo $message; ?></div>
			</div>
                    <div class="description col-lg-12">
                        <p class="error">
                            <em><?php echo __d('cake', 'Error'); ?>: </em>
                            <?php echo __d('cake', 'An Internal Error Has Occurred.'); ?>
                        </p>
                        <?php
                        if (Configure::read('debug') > 0):
                                echo $this->element('exception_stack_trace');
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
        
        </div>
    </section>
</main>