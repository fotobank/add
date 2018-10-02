<?php



       /**
        * Class Soap
        */
       class Soap {

              static $soap_server = 'http://your.site.com/utp/ws/ss?wsdl',
                     $login = 'login',
                     $password = 'password';


              public static function get_xml_from_soap($method, $params = array()) {

                     $param = array(
                            // Stuff for development.
                            'trace'      => 1,
                            'exceptions' => true,
                            'cache_wsdl' => WSDL_CACHE_NONE,
                            'features'   => SOAP_SINGLE_ELEMENT_ARRAYS,
                            // Auth credentials for the SOAP request.
                            'login'      => self::$login,
                            'password'   => self::$password,
                            // Charset
                            'encoding'   => 'utf-8',
                            'style'      => "document",
                     );
                     $client = new SoapClient(self::$soap_server, $param);
                     $result = $client->__soapCall($method, array('parameters' => $params));

                     return simplexml_load_string($result->return);
              }
       }
