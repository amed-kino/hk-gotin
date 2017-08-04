<?php


//            [artistUnique] => 0FFICEeKQ
//            [artistName] => Miço Kendeş
//            [albumTitle] => Memê Alan
//            [albumYear] => 2001
//            [albumImage] => mem_alan.gif
//            [lyricUnique] => Isu40pL1M
//            [lyricTitle] => Êmo
//            [lyricFile] => Miço Kendeş/Miço Kendeş - Êmo.mp3


?>$(document).ready(function(){

	new jPlayerPlaylist({
		jPlayer: "#hk-player",
		cssSelectorAncestor: "#hk-player-container"
	}, [
		<?php foreach ($data as $items):
                 $songHref = '';
    
                if (strstr($items['lyricFile'], 'http')){
                    $songHref = $items['lyricFile'];
                }else{
                    $songHref = FULL_BASE_URL.'/stran/'.$items['lyricFile'];
                }
                ?>
{
                    title : "<?php echo $items['lyricTitle'];?>",
                    mp3 : "<?php echo $songHref;?>",
                    Unique : "<?php echo $items['lyricUnique'];?>",
                    artistUnique : "<?php echo $items['artistUnique'];?>",
                    artist : "<?php echo $items['artistName'];?>",
                    albumTitle : "<?php echo $items['albumTitle'];?>",
                    albumYear : "<?php echo $items['albumYear'];?>",
                    albumImage : "<?php echo $items['albumImage'];?>",
                    
                    
		},
                <?php endforeach; ?>
	], {
		swfPath: "",
		supplied: "mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true
	});
});