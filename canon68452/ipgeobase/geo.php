<?php
	class Geo
    {
	public $ip=0;
	public $charset=null;

        public function __construct($options = null) {
            
           // $this->dirname = dirname(__file__);
            
            // ip
            if(!isset($options['ip']) OR !$this->is_valid_ip($options['ip']))
                $this->ip = $this->get_ip(); 
            elseif($this->is_valid_ip($options['ip']))          
                $this->ip = $options['ip'];
            // ���������
            if(isset($options['charset']) && $options['charset'] && $options['charset']!='windows-1251')
                $this->charset = $options['charset'];
        }

	  public function setIp($ip) {
		 if($this->is_valid_ip($ip)) {
			$this->ip = $ip;
		 } else {
			debugHC('�������������� ip �����');
		 }
	  }

        /**
         * ������� ��������� ���������� �������� �� ����������� ������� ������ �� ip
         * @param string - ���� �������. ���� ���������� ���������� ��������. 
         * ���� ����� ���� ������ 'inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'
         * @param bolean - ������������� ������� ������ � ���� ��� ���
         * ���� true, �� � ���� ����� �������� ������ �� ip � ��������� ������� �� ipgeobase ����������� �� �����.
         * ���� false, �� ������ ��������� ����� ������������� � ipgeobase
         * @return array OR string - ������������� ������� ����������� ������ �������.
         */
        function get_value($key = false, $cookie = true)
        {
            $key_array = array('inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng');
            if(!in_array($key, $key_array))
                $key = false;            
            
            // ���� ���������� ���� � �������� ��� �������, �� ������� � ���������� ������ �� ����
            if($cookie && isset($_COOKIE[preg_replace('/\./i','_',$this->ip)]))
            {
                $data = unserialize($_COOKIE[preg_replace('/\./i','_',$this->ip)]);
            } 
            else
            {
                $data = $this->get_geobase_data();
                setcookie($this->ip, serialize($data), time()+3600*24*7); //������������� ���� �� ������
            }            
            if($key && isset($data[$key]))
                return $data[$key]; // ���� ������ ����, ���������� ������ � ������� �������
            else
                return '------';
        }
        
        /**
         * ������� �������� ������ �� ip.
         * @return array - ���������� ������ � �������
         */
        function get_geobase_data()
        {
            // �������� ������ �� ip
            $link = 'ipgeobase.ru:7020/geo?ip='.$this->ip;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            $string = curl_exec($ch);    
            
            // ���� ������� ��������� �������� �� windows-1251, �������� ���������
            if(isset($this->charset)) {
                $string = iconv('windows-1251', $this->charset, $string);
				}
            $data = $this->parse_string($string);
                
            return $data;
        }
        
        /**
         * ������� ������ ���������� � XML ������ � ������, ���� �� ������� �� ����������� ���������� Simplexml
         * @return array - ���������� ������ � �������
         */
        
        function parse_string($string)
        {
            $pa['inetnum'] = '#<inetnum>(.*)</inetnum>#is';
            $pa['country'] = '#<country>(.*)</country>#is';
            $pa['city'] = '#<city>(.*)</city>#is';
            $pa['region'] = '#<region>(.*)</region>#is';
            $pa['district'] = '#<district>(.*)</district>#is';
            $pa['lat'] = '#<lat>(.*)</lat>#is';
            $pa['lng'] = '#<lng>(.*)</lng>#is';
            $data = array();
            foreach($pa as $key => $pattern)
            {
                if(preg_match($pattern, $string, $out))
                {
                    $data[$key] = trim($out[1]);
                }
            }
            return $data;
        }
        
        /**
         * ������� ���������� ip ����� �� ����������� ������� $_SERVER
         * ip ������ ����������� ������� � �������������, ��� ����������� ���������� ������������� ������
         * @return ip-�����
         */
        function get_ip()
        {
            $ip = false;
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipa[] = trim(strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ','));
            
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipa[] = $_SERVER['HTTP_CLIENT_IP'];       
            
            if (isset($_SERVER['REMOTE_ADDR']))
                $ipa[] = $_SERVER['REMOTE_ADDR'];
            
            if (isset($_SERVER['HTTP_X_REAL_IP']))
                $ipa[] = $_SERVER['HTTP_X_REAL_IP'];
            
            // ��������� ip-������ �� ���������� ������� � �������������.
            foreach($ipa as $ips)
            {
                //  ���� ip �������� �������� ����, ��������� ip ����� � ���������� ���
                if($this->is_valid_ip($ips))
                {                    
                    $ip = $ips;
                    break;
                }
            }
            return $ip;
            
        }
        
        /**
         * ������� ��� �������� ���������� ip ������
         * @param ip ����� � ������� 1.2.3.4
         * @return bolean : true - ���� ip ��������, ����� false
         */
        function is_valid_ip($ip=null)
        {
            if(preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip))
                return true; // ���� ip-����� �������� ��� ���������� ���������, ���������� true
            
            return false; // ����� ���������� false
        }
        

    }
?>