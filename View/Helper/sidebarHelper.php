<?php



App::uses('Lyric', 'Lyric.Model');


class SidebarHelper extends AppHelper {

	public function latestLyrics(){
		$this->loadModel('Lyric');
		$latest=$this->Lyrics->find('all');

	
	return($latest);
	
	}

}