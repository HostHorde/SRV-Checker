<?php
class SRV_Checker {

    
    private function parseAddress($address){
    
        //Fix checks that are done on SRV records that have :25565 added on the end.
        if (!strstr($address, ":")){
            return $address;
        }
        
        $dat = explode(":", $address);
        $server_hostname = $dat[0];
        $server_port = $dat[1];
        if ($server_port=="25565"){
            return $server_hostname;
        }
        
        return NULL;
    }
    
    
    function checkAddress($address) {
    
        $check_address = $this->parseAddress($address);
        if ($check_address==NULL){
            return $address;
        }
        
        //Start the actual SRV record check.
        $result = dns_get_record("_minecraft._tcp.$check_address", DNS_SRV);
        if ($result){
            $lowest_priority = 0;
            $valid_record = false;
            foreach ($result as $record){
                $record_type = $record['type'];
                $record_pri = $record['pri'];
                $record_port = $record['port'];
                $record_target = $record['target'];
                if ($record_type=="SRV" && ($valid_record==false || $record_pri <= $lowest_priority)){
                    $address = $record_target.':'.$record_port;
                    $lowest_priority = $record_pri;
                    $valid_record = true;
                }
            }
        }
        
        return $address;
    }
    
    
}
?>