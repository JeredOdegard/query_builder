<?php
	class QueryString {
		private $url = '';
		
		function __construct($url) {
			$this->url = $url;
		}
		
		function addArguments($key_value) {
			$this->addToURL($key_value);
			return $this->url;
		}
		
		function getURL() {
			return $this->url;
		}
		
		private function addToURL($argument) {
			$this->replaceQueryString($this->generateQueryString($argument));
		}
		
		private function generateQueryString($new_keys) {
			$new_arguments = $this->convertToQuery($new_keys);
			$current_arguments = $this->currentURLArgs();
			if (empty($current_arguments)) return $new_arguments;
			return $current_arguments . '&' . $new_arguments;
		}
		
		private function replaceQueryString($query_string) {
			if (strpos($this->url, '?')) {
				$start_url = substr($this->url, 0, strpos($this->url, '?') + 1);
			} 
			else {
				$start_url = $this->url . '?';	
			}
			
			$this->url = $start_url . $query_string;
		}
		
		private function convertToQuery($keys) {
			return http_build_query($keys);
		}
		
		private function currentURLArgs() {
			$parsed_url = parse_url($this->url);
			return $parsed_url['query'];
		}
	}
	
	$myQs = new QueryString('ftp://google.com');
	$myQs->addArguments(array('dog' => 'meow', 'friends' => 12, 'house' => 'red'));
	echo $myQs->getURL();
?>