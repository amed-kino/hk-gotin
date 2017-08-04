<main id="main" class="site-main" role="main">
    <section id="recovery">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-lock"></i></div>
                <div class="text-container">
                    <div class="title"><?php echo __('Recovery password'); ?></div>
                    <div class="details"><?php echo __('Follow the instructions bellow.'); ?></div>
                </div>
            </div>
            
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body recovery-body clearfix">
            <p>Tu alîkariyan em niha nikarin bo te bikin.<br/>Hûn dikarin nav û e-maila xwe bo me bişînin ser: <a href="mailto:recovery@hunerakurdi.com">recovery@hunerakurdi.com</a><br/>Li bendî bersiva me bin.</p>
        </div>
    </section>
</main>