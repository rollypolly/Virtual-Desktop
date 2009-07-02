<?php

require_once (LIB_CORE .'tools.class.php');

class stats implements module {
	
	private $path;
	private $user;
	private $conf;
	
	/**
	 *
	 */
	
	public function __construct($path, $user) {
		$this->path = $path;
		$this->user = $user;
		
		$this->conf = config::get();
	}
	
	/**
	 *
	 */
	
	public function run($action_method = 'show') {
		
		switch ($action_method) {
			case 'show':
				return array(
					'name'			=> 'Statistics',
					'description'	=> 'stats of your folders',
					'stats'			=> $this->show(),
					'menuItems'		=> $this->getMenuItems()
				);
				break;
		}
	}
	
	/**
	 *
	 */
	 
	private function getMenuItems() {
		return array (
			0	=> array (
				'url'	=> 'Mon url',
				'name'	=> 'Statistics',
				'class'	=> 'current'
			)
		);
	}
	
	/**
	 *
	 */
	
	private function show() {
		$directory = $this->conf['general']['dataPath'] . $this->user .'/';
		$space = $this->GetFolderSize($directory);
		
		return tools::getSymbolByQuantity($space);
	}
	
	/**
	 *
	 */
	
	private function GetFolderSize($d ="." ) {
		// � kasskooye and patricia benedetto
		$h = @opendir($d);
		$sf = 0;
		if ($h == 0) return 0;

		while ($f = readdir($h)){
			if ($f != "..") {
				$sf += filesize($nd = $d ."/". $f);
				if ($f != "." && is_dir($nd)){
					$sf += $this->GetFolderSize($nd);
				}
			}
		}
		closedir($h);
		return $sf ;
	}
}