<?php
/**
* Ninuxoo 2.0
*
* PHP Version 5.3
*
* @copyright 2013-2014 Alessandro Gubitosi / Gubi (http://iod.io)
* @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
* @link https://github.com/gubi/Ninuxoo-2.0
*/

/**
* A class for executes thing in mdns
*
* _
*
* @package	Ninuxoo 2.0
* @author		Alessandro Gubitosi <gubi.ale@iod.io>
* @license 	http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
* @access		public
* @link		https://github.com/gubi/Ninuxoo-2.0/blob/master/common/include/classes/mdns.class.php
* @uses		simple_html_dom.php Simple_html_dom Class
*/
class mdns {
	/**
	* Construct
	*
	* Initialize the class
	*
	* @global string $this->class_dir Current class directory
	* @global string $this->include_path Parent path of class directory
	* @return void
	*/
	function __construct() {
		$this->class_dir = __DIR__;
		$this->include_path = str_replace("classes", "", $this->class_dir);
	}
	/**
	* Check the trusted directory
	*
	* @see mdns::__construct() Construct
	* @return array $trusted The devices marked as TRUSTED
	* @access  public
	*/
	public function check_trusted() {
		foreach(glob($this->include_path . "conf/trusted/*.pem") as $filename) {
			$trusted[] = str_replace(array($this->include_path . "conf/trusted/", ".pem"), "", $filename);
		}
		return $trusted;
	}
	/**
	* Check the untrusted directory
	*
	* @see mdns::__construct() Construct
	* @return array $untrusted The devices marked as UNTRUSTED
	* @access  public
	*/
	public function check_untrusted() {
		foreach(glob($this->include_path . "conf/untrusted/*.pem") as $filename) {
			$untrusted[] = str_replace(array($this->include_path . "conf/untrusted/", ".pem"), "", $filename);
		}
		return $untrusted;
	}
	/**
	* Lookup pgp.mit.edu and return data about owner of a given key
	*
	* @param string $key The PGP owner key
	* @return array $o The owner data (name and email)
	* @subpackage simple_html_dom.php
	* @access public
	*/
	public function get_owner($key) {
		require_once($this->include_path . "lib/simplehtmldom_1_5/simple_html_dom.php");
		
		$mit = "http://pgp.mit.edu:11371";
		if($own = @file_get_html($mit . "/pks/lookup?search=0x" . trim($key, '"'))) {
			$ret = $own->find("a");
			$owner = array();
			foreach($ret as $a) {
				if(strpos($a->href, "lookup") !== false) {
					$owner[] = $a->plaintext;
				}
			}
			$o["name"] = trim(preg_replace("/&lt;(.*?)&gt;/i", "", $owner[1]));
			$o["email"] = trim(preg_replace("/.*?&lt;|&gt;/i", "", $owner[1]));
			return $o;
		}
	}
	/**
	* Search in pgp.mit.edu and return the PGP key of a given email address
	*
	* @param string $email The PGP owner key
	* @return string $owner_key The owner PGP key
	* @subpackage simple_html_dom.php
	* @access public
	*/
	public function get_owner_key($email) {
		require_once($this->include_path . "lib/simplehtmldom_1_5/simple_html_dom.php");
		
		$mit = "http://pgp.mit.edu:11371";
		if($own = @file_get_html($mit . "/pks/lookup?search=" . urlencode($email))) {
			$ret = $own->find("a");
			$owner = array();
			foreach($ret as $a) {
				if(strpos($a->href, "lookup")) {
					$owner_key[] = $a->plaintext;
				}
			}
			return trim($owner_key[0]);
		}
	}
	
	/**
	* Extract the IP addresses (IPv4 and IPv6) from a given avahi output
	*
	* @param string $out The avahi output
	* @param string $hostname The hostname to filter
	* @return array $oo The filtered hostname IP addresses
	* @access private
	*/
	private function get_address($out, $hostname) {
		foreach($out as $kp => $parsed) {
			$o = explode(";", $parsed);
			if(stripcslashes($o[2]) == $hostname) {
				if($o[1] == "IPv6") {
					$o[6] = "[" . $o[6] . "]";
				}
				$oo[] = $o[6];
			}
		}
		return $oo;
	}
	
	/**
	* Detect reachability from a given avahi output
	*
	* @param string $out The avahi output
	* @return string $oo The filtered avahi output
	* @access private
	*/
	private function return_reachability($out) {
		foreach($out as $k => $v) {
			$o[] = $v[1];
		}
		if(count($o) > 1) {
			sort($o);
			$oo = implode(", ", $o);
		} else {
			$oo = $o[0];
		}
		return $oo;
	}
	
	/**
	* Queries avahi declaration
	*
	* @param bool $get_owner Output owner data
	* @param string $filter (deprecated)
	* @see mdns::__construct() Construct
	* @see mdns::check_trusted() Check_trusted
	* @see mdns::check_untrusted() Check_untrusted
	* @see mdns::get_owner() Get_owner
	* @see mdns::return_reachability() Return_reachability
	* @see mdns::get_address() Get_address
	* @return array $ndata Avahi output
	* @access public
	*/
	public function scan($get_owner = false, $filter = "") {
		$avh = shell_exec("avahi-browse _dns-sd._udp -prtl");
		preg_match_all("/\=\;(.*?)\n/is", $avh, $out);
		
		foreach($out as $kp => $vp) {
			foreach($vp as $kkp => $parsed) {
				$o[$kkp] = explode(";", $parsed);
				$msg[$kkp] = explode(":", $o[$kkp][8]);
			}
		}
		foreach ($msg as $mk => $mv) {
			if (is_array($mv)) {
				$message = explode("::", base64_decode($mv[1]));
				if (is_array($message) && trim($message[1]) !== "") {
					if(is_array($this->check_trusted()) && in_array("" . $message[2], $this->check_trusted())) {
						$status = "trusted";
					} else if(is_array($this->check_untrusted()) && in_array("" . $message[2], $this->check_untrusted())) {
						$status = "untrusted";
					} else {
						$status = "unknown";
					}
					if($o[$mk][3] == "_dns-sd._udp" && $o[$mk][7] == 64689 && trim($mv[0], '"') == "Hello guys I'm a Ninuxoo device") {
						$ips = array_filter(array_map("trim", explode(" ", shell_exec("hostname  -I"))));
						
						if(!in_array($o[6], $ips)) {
							if($get_owner == true) {
								$ndata[stripcslashes($o[$mk][2])]["owner"] = $this->get_owner($message[0]);
							}
							$ndata[stripcslashes($o[$mk][2])]["owner"]["key"] = trim($message[0], '"');
							$ndata[stripcslashes($o[$mk][2])]["geo_zone"] = trim($message[1]);
							$ndata[stripcslashes($o[$mk][2])]["reachability"][] = $this->return_reachability($o);
							$ndata[stripcslashes($o[$mk][2])]["token"] = base64_encode($message[2]);
							$ndata[stripcslashes($o[$mk][2])]["status"] = $status;
							$ndata[stripcslashes($o[$mk][2])]["address"] = $this->get_address($out[1], stripcslashes($o[$mk][2]));
						}
					}
				}
			}
			return $ndata;
		}
	}
	
	/**
	* Check if a given IP address declares avahi
	*
	* @param bool $ip The IP address to filter
	* @return bool
	* @access public
	*/
	public function check_ip($ip) {
		return (shell_exec("nc -zu " . $ip . " 64689; echo $?") == 0) ? true : false;
	}
}
?>