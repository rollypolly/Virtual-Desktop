<?php

require_once (LIB_CORE .'plugin.class.php');

class logs extends plugin {
	
	private $logFile = null;
	
	/**
	 *
	 */
	
	public function __construct() {
		parent::__construct();
		
		$this->logFile = dirname(__FILE__). '/test.log';
	}
	
	/**
	 *
	 */
	
	protected function show() {
		return array (
			'name'			=> 'Log file',
			'description'	=> '',
			'logsList'		=> $this->makeList()
		);
	}
	
	/**
	 *
	 */
	
	public function write($module, $message) {
		
		if (!empty($message) && !is_array($message)) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$date = date('Y-m-d');
			
			$this->logFile = dirname(__FILE__). '/test.log';
			$handle = fopen($this->logFile, 'a');
			fwrite($handle, $date ."\t". $ip ."\t". $module ."\t". $message ."\n");
			fclose($handle);
		}
	}
	
	/**
	 *
	 */
	
	private function makeList() {
		
		if (file_exists($this->logFile)) {
			$handle = fopen($this->logFile, 'r');
			
			$date = null;
			$ip = null;
			$module = null;
			$message = null;
			
			$i=1;
			while (!feof($handle)) {
				$buffer = fgets($handle, 4096);
				if (!empty($buffer)) {
					list($date, $ip, $module, $message) = explode("\t", $buffer);
					
					$ret [] = array (
						'id'		=> $i,
						'date'		=> $date,
						'ip'		=> $ip,
						'module'	=> $module,
						'message'	=> $message
					);
					++$i;
				}
			}
			fclose($handle);
			return $ret;
		} else {
			return array();
		}		
	}
}