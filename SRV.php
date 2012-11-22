<?php
class SRV_Checker {

	private function parseAddress($address){
	
		//Fix checks that are done on SRV records that have :25565 added on the end.
		if (strstr($address, ":")){
			$dat = explode(":", $address);
			$server_hostname = $dat[0];
			$server_port = $dat[1];
			if ($server_port=="25565"){
				return $server_hostname;
			}
			else {
				return NULL;
			}
		}
		
		return $address;
	}

	function checkAddress($address) {
	
		$check_address = $this->parseAddress($address);
		if ($check_address==NULL){
			return $address;
		}
		
		//Start the actual SRV record check.
		$result = dns_get_record("_minecraft._tcp.$check_address", DNS_SRV);
		if ($result){
			$priority = 0;
			$valid = 0;
			foreach ($result as $v){
				$type = $v['type'];
				$pri = $v['pri'];
				$port = $v['port'];
				$target = $v['target'];
				if ($type=="SRV"){
					if ($valid==0 || $pri <= $priority){
						$address = ''.$target.':'.$port.'';
						$priority = $pri;
						$valid = 1;
					}
				}
			}
		}
		
		return $address;
	}
}
?>