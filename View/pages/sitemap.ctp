<?php
Configure::load('sitemap');
$Map = Configure::read('HK.sitemap');
?>
<?php
echo $this->Html->meta(array('name' => 'description', 'content' => 'Di vê rûplê de hemû dergehên malperê tên dîtin. | Rûpla Nexşê ne diyar e ji hemî kesî ve.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Nexşeya malpera HuneraKurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-hk-logo.jpg'),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li class="active"><?php echo __('Sitemap');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="sitemap">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-list-alt"></i></div>
                <div class="text-container">
                    <div class="info">
                        <div class="title"><?php echo __('Sitemap');?></div>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
                <?php
                    foreach ($Map as $itemKey => $itemValue) {
                        echo '<h4><a href="',  isset($itemValue['link'])? $itemValue['link']:'','">'.$itemKey.'</a></h4>';
                        echo '<ul class="'.$itemKey.'">';
                            $this->HK->siteMapItems($itemValue,$itemKey);
                         echo '</ul>';
                    }
                    
                ?>
                </ul>
                <p></p>

                <hr/>            
        </div>
    </section>
</main>