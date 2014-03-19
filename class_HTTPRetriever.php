<?php
/* HTTP Retriever
 * Version v1.1.7
 * Copyright 2004-2006, Steve Blinch
 * http://code.blitzaffe.com
 * ============================================================================
 *
 * DESCRIPTION
 *
 * Provides a pure-PHP implementation of an HTTP v1.1 client, including support
 * for chunked transfer encoding and user agent spoofing.  Both GET and POST
 * requests are supported.
 *
 * This can be used in place of something like CURL or WGET for HTTP requests.
 * Native SSL (HTTPS) requests are also supported if the OpenSSL extension is 
 * installed under PHP v4.3.0 or greater.
 *
 * If native SSL support is not available, the class will also check for the
 * CURL extension; if it's installed, it will transparently be used for SSL
 * (HTTPS) requests.
 *
 * If neither native SSL support nor the CURL extension are available, and
 * libcurlemu (a CURL emulation library available from our web site) is found,
 * the class will also check for the CURL console binary (usually in 
 * /usr/bin/curl); if it's installed, it will transparently be used for SSL
 * requests.
 *
 * In short, if it's possible to make an HTTP/HTTPS request from your server,
 * this class can most likely do it.
 *
 *
 * HISTORY
 *
 * 1.1.7 (18-Apr-2006)
 *		- Added support for automatically following HTTP redirects
 *		- Added ::get_error() method to get any available error message (be
 *		  it an HTTP result error or an internal/connection error)
 *		- Added ::cache_hit variable to determine whether the page was cached
 *
 * 1.1.6 (04-Mar-2006)
 *		- Added stream_timeout class variable.
 *		- Added progress_callback class variable.
 *		- Added support for braindead servers that ignore Connection: close
 *
 *
 * EXAMPLE
 *
 * // HTTPRetriever usage example
 * require_once("class_HTTPRetriever.php");
 * $http = &new HTTPRetriever();
 *
 *
 * // Example GET request:
 * // ----------------------------------------------------------------------------
 * $keyword = "blitzaffe code"; // search Google for this keyword
 * if (!$http->get("http://www.google.com/search?hl=en&q=%22".urlencode($keyword)."%22&btnG=Search&meta=")) {
 *     echo "HTTP request error: #{$http->result_code}: {$http->result_text}";
 *     return false;
 * }
 * echo "HTTP response headers:<br><pre>";
 * var_dump($http->response_headers);
 * echo "</pre><br>";
 * 
 * echo "Page content:<br><pre>";
 * echo $http->response;
 * echo "</pre>";
 * // ----------------------------------------------------------------------------
 *  
 *
 * // Example POST request:
 * // ----------------------------------------------------------------------------
 * $keyword = "blitzaffe code"; // search Google for this keyword
 * $values = array(
 *     "hl"=>"en",
 *     "q"=>"%22".urlencode($keyword)."%22",
 *     "btnG"=>"Search",
 *     "meta"=>""
 * );
 * // Note: This example is just to demonstrate the POST equivalent of the GET
 * // example above; running this script will return a 501 Not Implemented, as
 * // Google does not support POST requests.
 * if (!$http->post("http://www.google.com/search",$http->make_query_string($values))) {
 *     echo "HTTP request error: #{$http->result_code}: {$http->result_text}";
 *     return false;
 * }
 * echo "HTTP response headers:<br><pre>";
 * var_dump($http->response_headers);
 * echo "</pre><br>";
 * 
 * echo "Page content:<br><pre>";
 * echo $http->response;
 * echo "</pre>";
 * // ----------------------------------------------------------------------------
 *
 *
 * LICENSE
 *
 * This script is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *	
 * You should have received a copy of the GNU General Public License along
 * with this script; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// define user agent ID's
define("UA_EXPLORER",0);
define("UA_MOZILLA",1);
define("UA_FIREFOX",2);
define("UA_OPERA",3);

// define progress message severity levels
define('HRP_DEBUG',0);
define('HRP_INFO',1);
define('HRP_ERROR',2);

if (!defined("CURL_PATH")) define("CURL_PATH","/usr/bin/curl");

// if the CURL extension is not loaded, but the CURL Emulation Library is found, try
// to load it
if (!extension_loaded("curl") && !defined('HTTPR_NO_REDECLARE_CURL') && is_readable(dirname(__FILE__)."/libcurlexternal.inc.php")) {
	require_once(dirname(__FILE__)."/libcurlexternal.inc.php");
}

class HTTPRetriever {
	
	// Constructor
	function HTTPRetriever() {
		// default HTTP headers to send with all requests
		$this->headers = array(
			"Referer"=>"",
			"User-Agent"=>"HTTPRetriever/1.0",
			"Connection"=>"close"
		);
		
		// HTTP version (has no effect if using CURL)
		$this->version = "1.1";
		
		// Normally, CURL is only used for HTTPS requests; setting this to
		// TRUE will force CURL for HTTP requests as well.  Not recommended.
		$this->force_curl = false;
		
		// If you don't want to use CURL at all, set this to TRUE.
		$this->disable_curl = false;
		
		// If HTTPS request return an error message about SSL certificates in
		// $this->error and you don't care about security, set this to TRUE
		$this->insecure_ssl = false;
		
		// Set the maximum time to wait for a connection
		$this->connect_timeout = 15;
		
		// Set the maximum time to allow a transfer to run, or 0 to disable.
		$this->max_time = 0;
		
		// Set the maximum time for a socket read/write operation, or 0 to disable.
		$this->stream_timeout = 0;
		
		// If you're making an HTTPS request to a host whose SSL certificate
		// doesn't match its domain name, AND YOU FULLY UNDERSTAND THE
		// SECURITY IMPLICATIONS OF IGNORING THIS PROBLEM, set this to TRUE.
		$this->ignore_ssl_hostname = false;
		
		// If TRUE, the get() and post() methods will close the connection
		// and return immediately after receiving the HTTP result code
		$this->result_close = false;
		
		// If set to a positive integer value, retrieved pages will be cached
		// for this number of seconds.  Any subsequent calls within the cache
		// period will return the cached page, without contacting the remote
		// server.
		$this->caching = false;
		
		// If $this->caching is enabled, this specifies the folder under which
		// cached pages are saved.
		$this->cache_path = '/tmp/';
		
		// Set these to perform basic HTTP authentication
		$this->auth_username = '';
		$this->auth_password = '';
		
		// Optionally set this to a valid callback method to have HTTPRetriever
		// provide progress messages.  Your callback must accept 2 parameters:
		// an integer representing the severity (0=debug, 1=information, 2=error),
		// and a string representing the progress message
		$this->progress_callback = null;
		
		// Set this to TRUE if you HTTPRetriever to transparently follow HTTP
		// redirects (code 301, 302, 303, and 307).  Optionally set this to a
		// numeric value to limit the maximum number of redirects to the specified
		// value.  (Redirection loops are detected automatically.)
		// Note that non-GET/HEAD requests will NOT be redirected except on code
		// 303, as per HTTP standards.
		$this->follow_redirects = false;
	}
	
	// send an HTTP GET request to $url; if $ipaddress is specified, the
	// connection will be made to the selected IP instead of resolving the 
	// hostname in $url
	function get($url,$ipaddress = false) {
		$this->method = "GET";
		$this->post_data = "";
		$this->connect_ip = $ipaddress;
		return $this->_execute_request($url);
	}
	
	// send an HTTP POST request to $url containing the data $data; if
	// $ipaddress is specified, the connection will be made to the selected IP
	// instead of resolving resolving the hostname in $url
	function post($url,$data="",$ipaddress = false) {
		$this->method = "POST";
		$this->post_data = $data;
		$this->connect_ip = $ipaddress;
		return $this->_execute_request($url);
	}
	
	// send an alternate (non-GET/POST) HTTP request to $url
	function custom($method,$url,$data="",$ipaddress = false) {
		$this->method = $method;
		$this->post_data = $data;
		$this->connect_ip = $ipaddress;
		return $this->_execute_request($url);
	}	
	
	// builds a query string from the associative array array $data;
	// returns a string that can be passed to $this->post()
	function make_query_string($data) {
		$output = "";
		if (is_array($data)) {
			foreach ($data as $name=>$value) {
				$output .= urlencode($name)."=".urlencode($value)."&";
			}
		}
		return substr($output,0,strlen($output)-1);
	}
	
	// this is pretty limited... but really, if you're going to spoof you UA, you'll probably
	// want to use a Windows OS for the spoof anyway
	//
	// if you want to set the user agent to a custom string, just assign your string to
	// $this->headers["User-Agent"] directly
	function set_user_agent($agenttype,$agentversion,$windowsversion) {
		$useragents = array(
			"Mozilla/4.0 (compatible; MSIE %agent%; Windows NT %os%)", // IE
			"Mozilla/5.0 (Windows; U; Windows NT %os%; en-US; rv:%agent%) Gecko/20040514", // Moz
			"Mozilla/5.0 (Windows; U; Windows NT %os%; en-US; rv:1.7) Gecko/20040803 Firefox/%agent%", // FFox
			"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT %os%) Opera %agent%  [en]", // Opera
		);
		$agent = $useragents[$agenttype];
		$this->headers["User-Agent"] = str_replace(array("%agent%","%os%"),array($agentversion,$windowsversion),$agent);
	}
	
	// this isn't presently used as it's now handled inline by the request parser
	function remove_chunkiness() {
		$remaining = $this->response;
		$this->response = "";
		
		while ($remaining) {
			$hexlen = strpos($remaining,"\r");
			$chunksize = substr($remaining,0,$hexlen);
			$argstart = strpos($chunksize,';');
			if ($argstart!==false) $chunksize = substr($chunksize,0,$argstart);
			$chunksize = (int) @hexdec($chunksize);

			$this->response .= substr($remaining,$hexlen+2,$chunksize);
			$remaining = substr($remaining,$hexlen+2+$chunksize+2);

			if (!$chunksize) {
				// either we're done, or something's borked... exit
				$this->response .= $remaining;
				return;
			}
		}
	}
	
	// (internal) store a page in the cache
	function _cache_store($token) {
		$values = array(
			"stats"=>$this->stats,
			"result_code"=>$this->result_code,
			"result_text"=>$this->result_text,
			"version"=>$this->version,
			"response"=>$this->response,
			"response_headers"=>$this->response_headers,
			"raw_response"=>$this->raw_response,
		);
		$values = serialize($values);

		$filename = $this->cache_path.$token.'.tmp';

		$fp = @fopen($filename,"w");
		if (!$fp) {
			$this->progress(HRP_DEBUG,"Unable to create cache file");
			return false;
		}
		fwrite($fp,$values);
		fclose($fp);

		$this->progress(HRP_DEBUG,"HTTP response stored to cache");
	}
	
	// (internal) fetch a page from the cache
	function _cache_fetch($token) {
		$this->cache_hit = false;
		$this->progress(HRP_DEBUG,"Checking for cached page value");

		$filename = $this->cache_path.$token.'.tmp';
		if (!file_exists($filename)) {
			$this->progress(HRP_DEBUG,"Page not available in cache");
			return false;
		}
		
		if (time()-filemtime($filename)>$this->caching) {
			$this->progress(HRP_DEBUG,"Page in cache is expired");
			@unlink($filename);
			return false;
		}
		
		if ($values = file_get_contents($filename)) {
			$values = unserialize($values);
			if (!$values) {
				$this->progress(HRP_DEBUG,"Invalid cache contents");
				return false;
			}
			
			$this->stats = $values["stats"];
			$this->result_code = $values["result_code"];
			$this->result_text = $values["result_text"];
			$this->version = $values["version"];
			$this->response = $values["response"];
			$this->response_headers = $values["response_headers"];
			$this->raw_response = $values["raw_response"];
			
			$this->progress(HRP_DEBUG,"Page loaded from cache");
			$this->cache_hit = true;
			return true;
		} else {
			$this->progress(HRP_DEBUG,"Error reading cache file");
			return false;
		}
	}
	
	// Execute the request for a particular URL, and transparently follow
	// HTTP redirects if enabled
	function _execute_request($url) {
		// valid codes for which we transparently follow a redirect
		$redirect_codes = array(301,302,303,307);
		// valid methods for which we transparently follow a redirect
		$redirect_methods = array('GET','HEAD');

		$request_result = false;
		
		$this->followed_redirect = false;

		$previous_redirects = array();
		do {
			// send the request
			$request_result = $this->_send_request($url);
			$url = false;

			// see if a redirect code was received
			if ($this->follow_redirects && in_array($this->result_code,$redirect_codes)) {
				
				// only redirect on a code 303 or if the method was GET/HEAD
				if ( ($this->result_code==303) || in_array($this->method,$redirect_methods) ) {
					$url = $this->response_headers['Location'];
				}
			}
			
			if ( $url && strlen($url) ) {
				
				if (isset($previous_redirects[$url])) {
					$this->error = "Infinite redirection loop";
					$request_result = false;
					break;
				}
				if ( is_numeric($this->follow_redirects) && (count($previous_redirects)>$this->follow_redirects) ) {
					$this->error = "Exceeded redirection limit";
					$request_result = false;
					break;
				}

				$previous_redirects[$url] = true;
			}

		} while ($url && strlen($url));

		// clear headers that shouldn't persist across multiple requests
		$per_request_headers = array('Host','Content-Length');
		foreach ($per_request_headers as $k=>$v) unset($this->headers[$v]);
		
		if (count($previous_redirects)>1) $this->followed_redirect = array_keys($previous_redirects);
		
		return $request_result;
	}
	
	// private - sends an HTTP request to $url
	function _send_request($url) {
		$this->progress(HRP_INFO,"Initiating {$this->method} request for $url");
		if ($this->caching) {
			$cachetoken = md5($url.'|'.$this->post_data);
			if ($this->_cache_fetch($cachetoken)) return true;
		}
		
		$time_request_start = time();
		
		$urldata = parse_url($url);
		if (!$urldata["port"]) $urldata["port"] = ($urldata["scheme"]=="https") ? 443 : 80;
		if (!$urldata["path"]) $urldata["path"] = '/';
		
		if (!empty($urldata['user'])) $this->auth_username = $urldata['user'];
		if (!empty($urldata['pass'])) $this->auth_password = $urldata['pass'];
		
		//echo "Sending HTTP/{$this->version} {$this->method} request for ".$urldata["host"].":".$urldata["port"]." page ".$urldata["path"]."<br>";
		
		if ($this->version>"1.0") $this->headers["Host"] = $urldata["host"];
		if ($this->method=="POST") {
			$this->headers["Content-Length"] = strlen($this->post_data);
			if (!$this->headers["Content-Type"]) $this->headers["Content-Type"] = "application/x-www-form-urlencoded";
		}
		
		if ( !empty($this->auth_username) || !empty($this->auth_password) ) {
			$this->headers['Authorization'] = 'Basic '.base64_encode($this->auth_username.':'.$this->auth_password);
		} else {
			unset($this->headers['Authorization']);
		}
		
		if (($this->method=="GET") && (!empty($urldata["query"]))) $urldata["path"] .= "?".$urldata["query"];
		$request = $this->method." ".$urldata["path"]." HTTP/".$this->version."\r\n";
		$request .= $this->build_headers();
		$request .= $this->post_data;
		
		$this->response = "";

		// Native SSL support requires the OpenSSL extension, and was introduced in PHP 4.3.0
		$php_ssl_support = extension_loaded("openssl") && version_compare(phpversion(),"4.3.0")>=0;
		
		// if this is a plain HTTP request, or if it's an HTTPS request and OpenSSL support is available,
		// natively perform the HTTP request
		if ( ( ($urldata["scheme"]=="http") || ($php_ssl_support && ($urldata["scheme"]=="https")) ) && (!$this->force_curl) ) {
			$curl_mode = false;

			$hostname = $this->connect_ip ? $this->connect_ip : $urldata['host'];
			if ($urldata["scheme"]=="https") $hostname = 'ssl://'.$hostname;
			
			$time_connect_start = time();

			$this->progress(HRP_INFO,'Opening socket connection to '.$hostname.' port '.$urldata['port']);

			$fp = @fsockopen ($hostname,$urldata["port"],$errno,$errstr,$this->connect_timeout);
			$connect_time = time() - $time_connect_start;
			if ($fp) {
				if ($this->stream_timeout) stream_set_timeout($fp,$this->stream_timeout);
				$this->progress(HRP_INFO,"Connected; sending request");
				fputs ($fp, $request);
				
				if ($this->stream_timeout) {
					$meta = socket_get_status($fp);
					if ($meta['timed_out']) {
						$this->error = "Exceeded socket write timeout of ".$this->stream_timeout." seconds";
						$this->progress(HRP_ERROR,$this->error);
						return false;
					}
				}
				
				$this->progress(HRP_INFO,"Request sent; awaiting reply");
				
				$headers_received = false;
				$data_length = false;
				$chunked = false;
				while (!feof($fp)) {
		
					if ($data_length>0) {
						$line = fread($fp,$data_length);
						$data_length -= strlen($line);
					} else {
						$line = fgets($fp,10240);
						if ($chunked) {
							$line = trim($line);
							if (!strlen($line)) continue;
							
							list($data_length,) = explode(';',$line);
							$data_length = (int) hexdec(trim($data_length));
							
							if ($data_length==0) {
								$this->progress(HRP_DEBUG,"Done");
								// end of chunked data
								break;
							}
							$this->progress(HRP_DEBUG,"Chunk length $data_length (0x$line)");
							continue;
						}
					}

					$this->response .= $line;
					
					// some dumbass webservers don't respect Connection: close and just
					// leave the connection open, so we have to be diligent about
					// calculating the content length so we can disconnect at the end of
					// the response
					if ( (!$headers_received) && (trim($line)=="") ) {
						$headers_received = true;

						if (preg_match('/\nContent-Length: ([0-9]+)/i',$this->response,$matches)) {
							$data_length = (int) $matches[1];
							$this->progress(HRP_DEBUG,"Content length is $data_length");
						}
						if (preg_match("/\nTransfer-Encoding: chunked/i",$this->response,$matches)) {
							$chunked = true;
							$this->progress(HRP_DEBUG,"Chunked transfer encoding requested");
						}
						
					}
					
					//$this->progress(HRP_INFO,"Next [$line]");
					if ($this->stream_timeout) {
						$meta = socket_get_status($fp);
						if ($meta['timed_out']) {
							$this->error = "Exceeded socket read timeout of ".$this->stream_timeout." seconds";
							$this->progress(HRP_ERROR,$this->error);
							return false;
						}
					}
					
					// check time limits if requested
					if ($this->max_time>0) {
						if (time() - $time_request_start > $this->max_time) {
							$this->error = "Exceeded maximum transfer time of ".$this->max_time." seconds";
							$this->progress(HRP_ERROR,$this->error);
							return false;
							break;
						}
					}
					if ($this->result_close) {
						if (preg_match_all("/HTTP\/([0-9\.]+) ([0-9]+) (.*?)[\r\n]/",$this->response,$matches)) {
							$resultcodes = $matches[2];
							foreach ($resultcodes as $k=>$code) {
								if ($code!=100) {
									$this->progress(HRP_INFO,'HTTP result code received; closing connection');

									$this->result_code = $code;
									$this->result_text = $matches[3][$k];
									fclose($fp);
																		
									return ($this->result_code==200);
								}
							}
						}
					}
				}
				fclose ($fp);
				$this->progress(HRP_INFO,'Request complete');
			} else {
				$this->error = strtoupper($urldata["scheme"])." connection to ".$hostname." port ".$urldata["port"]." failed";
				$this->progress(HRP_ERROR,$this->error);
				return false;
			}

		// perform an HTTP/HTTPS request using CURL
		} elseif ( !$this->disable_curl && ( ($urldata["scheme"]=="https") || ($this->force_curl) ) ) {
			$this->progress(HRP_INFO,'Passing HTTP request for $url to CURL');
			$curl_mode = true;
			if (!$this->_curl_request($url)) return false;
			
		// unknown protocol
		} else {
			$this->error = "Unsupported protocol: ".$urldata["scheme"];
			$this->progress(HRP_ERROR,$this->error);
			return false;
		}
		
		$this->raw_response = $this->response;

		$totallength = strlen($this->response);
		
		do {
			$headerlength = strpos($this->response,"\r\n\r\n");

			$response_headers = explode("\r\n",substr($this->response,0,$headerlength));
			$http_status = trim(array_shift($response_headers));
			foreach ($response_headers as $line) {
				list($k,$v) = explode(":",$line,2);
				$this->response_headers[trim($k)] = trim($v);
			}
			$this->response = substr($this->response,$headerlength+4);
	
			/* // Handled in-transfer now
			if (($this->response_headers['Transfer-Encoding']=="chunked") && (!$curl_mode)) {
				$this->remove_chunkiness();
			}
			*/
		
			if (!preg_match("/^HTTP\/([0-9\.]+) ([0-9]+) (.*?)$/",$http_status,$matches)) {
				$matches = array("",$this->version,0,"HTTP request error");
			}
			list (,$response_version,$this->result_code,$this->result_text) = $matches;

			// skip HTTP result code 100 (Continue) responses
		} while (($this->result_code==100) && ($headerlength));
		
		// record some statistics, roughly compatible with CURL's curl_getinfo()
		if (!$curl_mode) {
			$total_time = time() - $time_request_start;
			$transfer_time = $total_time - $connect_time;
			$this->stats = array(
				"total_time"=>$total_time,
				"connect_time"=>$connect_time,
				"url"=>$url,
				"content_type"=>$this->response_headers["Content-Type"],
				"http_code"=>$this->result_code,
				"header_size"=>$headerlength,
				"request_size"=>$totallength,
				"filetime"=>strtotime($this->response_headers["Date"]),
				"pretransfer_time"=>$connect_time,
				"size_download"=>$totallength,
				"speed_download"=>$transfer_time > 0 ? round($totallength / $transfer_time) : 0,
				"download_content_length"=>$totallength,
				"upload_content_length"=>0,
				"starttransfer_time"=>$connect_time,
			);
		}
		
		
		$ok = ($this->result_code==200);
		if ($ok && $this->caching) $this->_cache_store($cachetoken);

		return $ok;
	}
	
	function build_headers() {
		$headers = "";
		foreach ($this->headers as $name=>$value) {
			$value = trim($value);
			if (empty($value)) continue;
			$headers .= "{$name}: $value\r\n";
		}
		$headers .= "\r\n";
		
		return $headers;
	}
	
	function _replace_hostname(&$url,$new_hostname) {
		$parts = parse_url($url);
		$old_hostname = $parts['host'];
		
		$parts['host'] = $new_hostname;
		
		$url = $parts['scheme'].'://';
		
		if ($parts['user'] || $parts['pass']) {
			$url .= $parts['user'];
			if ($parts['pass']) {
				if ($parts['user']) $url .= ':';
				$url .= $parts['pass'];
			}
			$url .= '@';
		}
		
		$url .= $parts['host'];
		if ($parts['port']) $url .= ':'.$parts['port'];
		
		$url .= $parts['path'];
		
		if ($parts['query']) $url .= '?'.$parts['query'];
		if ($parts['fragment']) $url .= '#'.$parts['fragment'];
		
		return $old_hostname;
	}
	
	function _curl_request($url) {
		$this->error = false;

		// if a direct connection IP address was specified,	replace the hostname
		// in the URL with the IP address, and set the Host: header to the
		// original hostname
		if ($this->connect_ip) {
			$old_hostname = $this->_replace_hostname($url,$this->connect_ip);
			$this->headers["Host"] = $old_hostname;
		}
		

		unset($this->headers["Content-Length"]);
		$headers = explode("\n",$this->build_headers());
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url); 
		curl_setopt($ch,CURLOPT_USERAGENT, $this->headers["User-Agent"]); 
		curl_setopt($ch,CURLOPT_HEADER, 1); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1); 
//		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1); // native method doesn't support this yet, so it's disabled for consistency
		curl_setopt($ch,CURLOPT_TIMEOUT, 10);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		
		if ($this->method=="POST") {
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$this->post_data);
		}
		if ($this->insecure_ssl) {
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		}
		if ($this->ignore_ssl_hostname) {
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
		}
		
		$this->response = curl_exec ($ch);
		if (curl_errno($ch)!=0) {
			$this->error = "CURL error #".curl_errno($ch).": ".curl_error($ch);
		}
		
		$this->stats = curl_getinfo($ch);
		curl_close($ch);
		
		return ($this->error === false);
	}
	
	function progress($level,$msg) {
		if (is_callable($this->progress_callback)) call_user_func($this->progress_callback,$level,$msg);
	}
	
	// Gets any available HTTPRetriever error message (including both internal
	// errors and HTTP errors)
	function get_error() {
		return $this->error ? $this->error : 'HTTP ' . $this->result_code.': '.$this->result_text;
	}
	
}
?>