<?php
echo $this->Html->meta(array('name' => 'description', 'content' => 'HK malpera gotinê stranê Kurdî. Civakeke her kes dikare beşdarî bibe. Bi hêsanî destpê bike, stranê ku tu jê hezdikî daxe û beşdar be.'),'',array('inline'=>false));
echo $this->element('basic_meta_keywords');
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Hunera Kurdî - Malpera gotinê strana'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-hk-logo.jpg'),'',array('inline'=>false));