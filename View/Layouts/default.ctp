<!DOCTYPE html>
<html lang="ku">
<head>
<?php
$cdn = Configure::read('HK.cdn');
?>
<?php echo $this->Html->charset();?>
<?php echo $this->fetch('meta'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo $this->Html->meta('icon','wene/favicon.png'); ?>

<link rel="stylesheet" href="<?php echo $cdn['bootstrapCss'];?>">
<?php echo $this->Html->css('hk.css'); ?>
<?php echo $this->fetch('css'); ?>
<?php echo $this->fetch('scriptHeader');?>

<title><?php if (isset($title)){echo $title;}else{echo 'Hunera Kurdi';}?></title>
</head>
<body>
<?php echo $this->fetch('beforeBody');?>    
<header id="site-header">
<?php echo $this->element('header');?>
</header>
<?php echo $this->fetch('afterNav');?>
<section id="site-body" class="col-lg-12 clearfix">
    
    <section id="primary" class="content-area col-lg-9 col-md-8  col-sm-12 col-xs-12">
        <?php echo $this->fetch('content'); ?>
    </section>
    <section id="secondary" class="col-lg-3 col-md-4  col-sm-12 col-xs-12">
        <?php echo $this->element('sidebar'); ?>
    </section>
</section>
<footer id="site-footer" class="col-lg-12 clearfix">
    <?php echo $this->element('footer');?>
</footer>
  
<script src="<?php echo $cdn['jqueryJs'];?>" type="text/javascript"></script>
<script src="<?php echo $cdn['bootstrapJs'];?>"></script>
<?php echo $this->Html->script('hk'); ?>
<?php echo $this->fetch('script');?>
<?php echo $this->fetch('scriptBottom');?>
<?php echo $this->Session->flash('flash',array('element'=>"flash"));?> 
<?php if($this->Session->check('Auth.User')):?>

<?php endif;?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62789970-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html> 