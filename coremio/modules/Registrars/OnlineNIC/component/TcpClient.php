<?php
/**
 * 
 * Tcp Client
 * @author CHENWP
 *
 */
class TcpClient {
	protected $link;
	protected $lastMessage;
	
	public function __construct(&$link) {
		$this->link = &$link;
		$this->getResponse();
	}
	
	static public function connect($config) {
		$errno = '';
		$errstr = '';
		$link = fsockopen($config['server'], $config['port'], $errno, $errstr, $config['timeout']);
		if ( $link ) {
			return new TcpClient($link);
		}
		return false;
	}
	
		public function getResponse() {
		stream_set_timeout($this->link, 60);
		$response = '';
		while ( !feof($this->link) ) {
			$rs = fread($this->link,8192);
			$info = stream_get_meta_data($this->link);
			if ( $info['timed_out'] ) {
				$rs = 'Timed out';
				break;
			}
			$response .= $rs;
			if ( preg_match('|</response>|', $response) ) {
				break;
			}
		}
		if ( $response == '' && $rs ) $response = $rs;
		$this->lastMessage = $response;
		return $response;
	}

	
	public function sendCommand($cmd) {
		fwrite($this->link, $cmd);
		return $this->getResponse();
	}
	
	public function disconnect() {
		if ( $this->link ) {
			fclose($this->link);
		}
	}
	
	public function getLastMessage() {
		return $this->lastMessage;
	}
	
	public function __destruct() {
		$this->disconnect();
	}
}
