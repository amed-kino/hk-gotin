<?php
$pluginDot = empty($plugin) ? null : $plugin . '.';
?>
<main id="main" class="site-main" role="main">
    <section id="error">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-warning-sign"></i></div>
                <div class="text-container">
			<div class="info clearfix">
	                    <div class="title"><?php echo __d('cake_dev', 'Missing Controller'); ?></div>
			</div>
                    <div class="description col-lg-12">
                        <p class="error">
                                <?php echo __d('cake_dev', 'Error'); ?>: 
                                <?php echo __d('cake_dev', '%s could not be found.', '<em>' . h($pluginDot . $class) . '</em>'); ?>
                        </p>
                        <p class="error">
                                <?php echo __d('cake_dev', 'Error'); ?>: 
                                <?php echo __d('cake_dev', 'Create the class %s below in file: %s', '<em>' . h($class) . '</em>', (empty($plugin) ? APP_DIR . DS : CakePlugin::path($plugin)) . 'Controller' . DS . h($class) . '.php'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
        
<pre>
&lt;?php
class <?php echo h($class . ' extends ' . $plugin); ?>AppController {

}
</pre>
<p class="notice">
	<?php echo __d('cake_dev', 'Notice'); ?>:
	<?php echo __d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR . DS . 'View' . DS . 'Errors' . DS . 'missing_controller.ctp'); ?>
</p>

<?php echo $this->element('exception_stack_trace'); ?>

        </div>
    </section>
</main>


<section id="primary" class="content-area col-md-8">
        <main id="main" class="site-main" role="main">


<h2></h2>


        </main>
    </section>
	
