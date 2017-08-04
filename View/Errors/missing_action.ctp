<main id="main" class="site-main" role="main">
    <section id="error">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-warning-sign"></i></div>
                <div class="text-container">
			<div class="info clearfix">
	                    <div class="title"><?php echo __d('cake_dev', 'Missing Method in %s', h($controller)); ?></div>
			</div>
                    <div class="description col-lg-12">
                        <p class="error">
                                <em><?php echo __d('cake_dev', 'Error'); ?>: </em>
                                <?php echo __d('cake_dev', 'The action %1$s is not defined in controller %2$s', '<em>' . h($action) . '</em>', '<em>' . h($controller) . '</em>'); ?>
                        </p>
                        <p class="error">
                                <em><?php echo __d('cake_dev', 'Error'); ?>: </em>
                                <?php echo __d('cake_dev', 'Create %1$s%2$s in file: %3$s.', '<em>' . h($controller) . '::</em>', '<em>' . h($action) . '()</em>', APP_DIR . DS . 'Controller' . DS . h($controller) . '.php'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
        
        <pre>
        &lt;?php
        class <?php echo h($controller); ?> extends AppController {

        <em>
                public function <?php echo h($action); ?>() {

                }
        </em>
        }
        </pre>

        <?php echo $this->element('exception_stack_trace'); ?>
        </div>
    </section>
</main>
