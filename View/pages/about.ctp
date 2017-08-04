<?php
echo $this->Html->meta(array('name' => 'description', 'content' => 'Kultûra Kurdî dewlemend e bi wêje, çîrok û destanên ku nifşan bi şêweyeke devokî bi hev de maye.HK malpera gotinê stranê Kurdî ye, civakeke her kes dikare beşdarî bibe.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Derbarî Malpera Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-hk-logo.jpg'),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li class="active"><?php echo __('About');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="about">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-hk"></i></div>
                <div class="text-container">
                    <div class="info">
                        <div class="title"><?php echo __('About');?></div>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
                
         
            <h4>HK çî ye?</h4>
            <p>
                Malpereke gotinên stranên Kurdî ye.Civakeke vekiriye bo her kesê ku bi zimanê xwe zane.
            </p><br/>
            <h4>HK bo kê ye?</h4>
            <p>
                Ev malpera bo yên ku ji starn û kultûra Kurdî hez dikine.
            </p><br/>
            
            
            <h4>Armanc ji HK çî ye?</h4>
            <p>
                Kultûra Kurdî dewlemend e bi wêje, çîrok û destanên ku nifşan bi şêweyeke devokî bi hev de maye lê ta niha çarçoveyek  bo  wê nehatiye peydakirin. Belku divê weku zaniyariyên hejmarî bihêt ezberkirin da ku lêvegereke sûd wergirtinê be ji lêkolînerên di warê ziman û dîrok/mêjû/ê  de dixebitin .
                Em di rêya ev malperê hewldidin didin ku  stranên nezelal tevî peyv û çîrokên wan bêhtir zelal bikin û  wan bûyerên weku stran tên pêşkêş kirin bi guhdarê hêja binasînin  .
            </p><br/>
            
            <hr/>
            <h4>Tîma HK</h4><br/>
            
            <div class="hk-authors">
                
                <div class="author">
                    <div class="picture">
                        <a target="_blank" href="https://www.facebook.com/amed.kino9">
                            <img class="img-circle" alt="" src="https://graph.facebook.com/563790487/picture?width=100&height=100">
                        </a>
                    </div>
                    <div class="info">
                        <div class="title">
                            <a target="_blank" href="https://www.facebook.com/amed.kino9">Amed Kino</a>
                        </div>
                        <div class="desc"></div>
                    </div>
                </div>
                
                
                <div class="author">
                    <div class="picture">
                        <a target="_blank" href="https://www.facebook.com/xebato">
                            <img class="img-circle" alt="" src="https://graph.facebook.com/100008289856473/picture?width=100&height=100">
                        </a>
                    </div>
                    <div class="info">
                        <div class="title">
                            <a target="_blank" href="https://www.facebook.com/xebato">Xebat Îbrahîm</a>
                        </div>
                        <div class="desc"></div>
                    </div>
                </div>
                
                
                <div class="author">
                    <div class="picture">
                        <a target="_blank" href="https://www.facebook.com/amedoebdi">
                            <img class="img-circle" alt="" src="https://graph.facebook.com/100008888802881/picture?width=100&height=100">
                        </a>
                    </div>
                    <div class="info">
                        <div class="title">
                            <a target="_blank" href="https://www.facebook.com/amedoebdi">Amed Ebdî</a>
                        </div>
                        <div class="desc"></div>
                    </div>
                </div>
                
            </div>
            
            <hr/>
            
            <br/>
            <br/>
            <p>Melper herdem belaş e, ne têkildar e bi rêklaman û têkildar nabe.</p>
            <br/>
            <p>Peywendî bi birêvebirên malperê re dê di riya  e-peyama <a href="mailto:info@hunerakurdi.com">info@hunerakurdi.com</a> re be.</p>
            <br/><br/>
            <div class="dedicate">
                <p>
                    <em>
                        <strong>
                            <i class="glyphicon glyphicon-heart"></i> 
                            Diyarî ew kesên bi pêlavên wan ax pîroz bû, ew kesên bi navê xwe tenê mane. 
                        </strong>
                    </em>
                </p>
            </div>       
        </div>
    </section>
</main>