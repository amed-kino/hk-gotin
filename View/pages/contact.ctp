<?php
echo $this->Html->meta(array('name' => 'description', 'content' => 'Peywendî bi birêvebirên malperê re dê di riya ev e-peyama: info@hunerakurdi.com'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Peywendî bi Malpera Hunera Kurdî re'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-hk-logo.jpg'),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li class="active"><?php echo __('Contact');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="contact">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-phone-alt"></i></div>
                <div class="text-container">
                    <div class="info">
                        <div class="title"><?php echo __('Contact');?></div>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
                
            <h4>Çawa hun dikarin bi HK re têkildar bin?</h4>
            <p> 
               Peywendî bi birêvebirên malperê re dê di riya ev e-peyama: <a href="mailto:info@hunerakurdi.com">info@hunerakurdi.com</a>
            </p><br/>            
            
            <hr/>
        </div>
    </section>
</main>