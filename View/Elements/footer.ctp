<?php
Configure::load('links');
$links = Configure::read('HK.links.social');
?>
<div id="site-footer">
    <div class="footer-divider"></div>
    <div id="footer-widget-container">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <div class="title hidden-xs hidden-sm">
                <?php echo __('Random selection');?>:
            </div>
            <div class="title title-sm visible-xs visible-sm" data-toggle="collapse" data-target=".random-selection-body">
                <span class="pull-left">
                    <span class="sr-only"><?php echo __('Toggle navigation');?></span>
                    <i class="glyphicon glyphicon-list"></i>
                </span>
                <?php echo __('Random selection');?>:
            </div>
            <div class="collapse coll-able random-selection-body">
            <?php
            $randoms=$this->requestAction(array('controller'=>'lyrics','action'=>'random',32));
            if(sizeof($randoms)!=32){
                echo "<h4 align=\"center\">Empty House :)</h4   >";
            }else{
                $i=1;

                foreach($randoms as $random){

                    if($i==1 || ($i-1)%8==0){
                        $classNumber=(($i-1)/8)+1;
                        echo '<div id="footer-widget" class="footer-widget-'.$classNumber.' col-md-3 col-sm-6">';}

                    $content =  $random['Artist']['name']." - ".$random['Lyric']['title'];
                    $date=$this->Time->format(
                                        'd-m-Y',
                                        $random['Lyric']['created'],
                                        null
                                    );

                    $meta =  ''.'<i class="glyphicon glyphicon-eye-open"></i>'.$random['Lyric']['views'].' | <i class="glyphicon glyphicon-user"></i>'.$random['User']['name'].' | <i class="glyphicon glyphicon-calendar small"></i>'.$date;

                    $uri = array(
                        'artist' => $random['Artist']['name'],
                        'album'  => $random['Album']['title'],
                        'year'   => $random['Album']['year'],
                        'title'  => $random['Lyric']['title'],
                    );

                    $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);


                    echo    '<div class="random-selection">'.
                            '<div class="content overflow-fade">',
                                $this->Html->link($content,$url,
                                    array()),
                            '</div><div class="meta overflow-fade">'.
                            $meta.
                            '</div></div>';
                    if($i%8==0){echo '</div>';}

                    $i++;
                }
            }
        ?>
            <div class="clearfix"></div>
        </div>
    </div>


    <div class="col-lg-1"></div>
        <div class="clearfix"></div>
    </div>

    <div id="site-info">
            <div class="social col-lg-2">
                <ul class="socials">
                    <li><a href="<?php echo $links['google'];?>" title="Google+"><i class="glyphicon glyphicon-google"></i></a>
                    <li><a href="<?php echo $links['twitter'];?>" title="Twitter"><i class="glyphicon glyphicon-twitter"></i></a>
                    <li><a href="<?php echo $links['facebook'];?>" title="Facebook"><i class="glyphicon glyphicon-facebook"></i></a>

                </ul>
            </div>
            <div class="info col-lg-8">

                <p>
                    Ji aliyê <a href="http://xbyte.team/" rel="generator">XByte Team</a> ve hatiye afirandin.
                    <span class="sep"> | </span>
                    Mafên gotinan parastîne ji xwediyê wan re.<br/>Hemû gotinên li ser vê malperê bi destê endaman hatiye nivîsandin, ne yasa e ku rast be.
                </p>
                <p>
                    Hemû mafên bikaranîna HK-Gotin parastîne © 2012-<?php echo date('Y');?>.<br>
                    <a href="http://www.hunerakurdi.com">www.HuneraKurdi.com</a>
                </p>
                <br/>
            </div>
        <div class="col-lg-2"></div>
        <div class="clearfix"></div>
    </div>
    <div class="ample"></div>
</div>