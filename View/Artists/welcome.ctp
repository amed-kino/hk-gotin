<?php
echo $this->Element('basic_meta');
?>
<section id="home">
    <div id="hk-player" class="block col-lg-12">
       
        <div class="text-container col-lg-12 clearfix">
            <a href="https://hunerakurdi.com/player" title="HK-Player vebike">
                <?php echo $this->Html->image('Player.HKPlay-Logo_200x200.png',array());?>
            </a>
           
            <br/>
           <p>
               
               Hûn dikarin nuha stranan li pey hev guhdarkin. <br/><small>Bi rêya HK-Player (guhartoya Beta).</small><br/></p>
        </div>
    </div>
    <div class="welcome block col-lg-12">
        <div class="icon-container col-lg-3 clearfix">
            <?php echo $this->Html->image('logo.png',array());?>
        </div>
        <div class="text-container col-lg-9">
            <header class="page-header">
                <h1 class="page-title">
                    Bi xêr hatî malpera <a href="https://hunerakurdi.com">HuneraKurdî.com</a>
                </h1>
            </header>
            <section class="text">
                <p>
                    Ev malpera civaka stranhezan û gotinhezan e.<br/>
                    <span id="general-statics">Ta niha <span class="date"><?php echo date('d-m-Y');?></span> <span class="lyrics"><span class="number"><?php echo $statics['Lyric'];?></span>  Stran</span>, <span class="albums"><span class="number"><?php echo $statics['Album'];?></span> Berhem</span> û <span class="artists"><span class="number"><?php echo $statics['Artist'];?></span> Hunermend </span>  hatine danîn.</span>
                </p>
                <p>
                    Her kesê ku bi ziman zanibe dikare beşdarî vê civakê bibe û gotinê stranên ku jê hez dike bi dilsozî daxîne.<br/>Ne tenê endam xwediyê vê civakê ne, her kesê ku bibe mêvanê me, ku nenas be jî, ew ji civakê ye.
                </p>
            </section>
        </div>
    </div>
    
    <div class="search block col-lg-12 clearfix">
        <div class="icon-container col-lg-3 col-lg-push-9 clearfix">
            <?php echo $this->Html->image('search.png',array());?>
        </div>
        <div class="text-container col-lg-9 col-lg-pull-3">
            <header class="page-header">
                <div class="page-title">
                   Di nava malperê de bigere
                </div>
            </header>
            <section class="text">
                <p>Tu dikarî li Stran, Berhem û Hunermendan bigerî di rêya vê lêgerînê re.<br>Her bi tenê tiştekî binivîsîne û pêlî 'bigere' bike.</p>
                Tiştekî binvîse û destpê bike.
            <?php echo $this->element('find/search_bar');?>
            </section>
        </div>
    </div>

    <div class="users block col-lg-12">
        <div class="icon-container col-lg-3 clearfix">
            <?php echo $this->Html->image('user.png',array());?>
        </div>
        <div class="text-container col-lg-9">
            <header class="page-header">
                <div class="page-title">
                   Bibe endamê HKyê
                </div>
            </header>
            <section class="text">
                
                <p>Her kes dikare bibe endam û gotinên strana bi azadî pareveke.<br/>
                Civaka <small><em>HuneraKurdî</em></small> civakeke azad e, her kurdek bi zimanê xwe zanibe binvîse dikare bi navê xwe li ser civakê stranan daxe û paraveke. <?php echo $this->Html->link(__('Signup'),array('controller'=>'users','action'=>'signup'));?></p>
                <p>Ger tu endam bî, here <?php echo $this->Html->link(__('Login'),array('controller'=>'users','action'=>'login'));?></p>
            </section>
        </div>
    </div>
    
    <div class="request block col-lg-12 clearfix">
        <div class="icon-container col-lg-3 col-lg-push-9 clearfix">
            <?php echo $this->Html->image('request.png',array());?>
        </div>
        <div class="text-container col-lg-9 col-lg-pull-3">
            <header class="page-header">
                <div class="page-title">
                   Têkiliyê bike
                </div>
            </header>
            <section class="text">
                <p>Cihê dilxweşiyê ye ku hûn bi azadî nerînên xwe rêkin bo pêşxistina civaka HK<br/>yan heger nerîn tune bin, tu dikarî tiştê dilê xwe rê bikî.<br/>Ger tiştek di dilê te de tune be peyameke vala rê bike. 
                    <?php echo $this->Html->link(__('Contact'),array('controller' => 'pages', 'action' => 'contact'));?>
                </p>
            </section>
        </div>
    </div>

</section>
