<?php

/**
 * Array Helper class
 * @author Thomas Schäfer 
 */
class ArrayHelper
{
  /**
   * holder of values
   * @var array $properties
   */
  private $properties = array();

  private $flat_properties = array();

  /**
   * @var string $_delimiter
   */
  private $_delimiter = '/';


  /**
	* @param null $delim
	*/
  public function __construct($delim=NULL) {
    if($delim) $this->_delimiter = $delim;
  }
  public function __clone() {}

  public function setProperties(array $data)
  {
    $this->properties = $data;
    return $this;
  }

  /**
   * @return ArrayHelper
   */
  public static function init()
  {
    return new ArrayHelper();
  }

  /**
   * check for key
   * @param string $path
   * @return bool
   */
  public function has($path)
  {
    if(strstr($path, $this->getDelimiter()))
    {
      if(substr($path,-1,1)==$this->getDelimiter())
      {
        $path = substr($path,0,-1);
      }
      $path = explode($this->getDelimiter(), $path);
      $key = array_shift($path);
      $path = implode($this->getDelimiter(), $path);
      return $this->hasElement($path, $this->get($key));
    }
    else
    {
      return array_key_exists($path, $this->properties);
    }
  }

  /**
   * returns hidden keys
   * @return array
   */
  public function getKeys()
  {
    return array_keys($this->properties);
  }

  /**
   * get values by path
   * @param string $path
   * @return mixed
   */
  public function get($path=NULL)
  {
    if(empty($path)) return $this->properties;

    if(strstr($path, $this->getDelimiter()))
    {
      if(substr($path,-1,1)==$this->getDelimiter())
      {
        $path = substr($path,0,-1);
      }
      $path = explode($this->getDelimiter(), $path);
      $key = array_shift($path);
      $path = implode($this->getDelimiter(),$path);
      return $this->getElement($path, $this->get($key));
    }
    if(array_key_exists($path, $this->properties))
    {
      return $this->properties[$path];
    }
    return array();
  }

  /**
   * internal element getter
   * @access protected
   * @param string $path
   * @param mixed $data
   * @return mixed
   */
  protected function getElement($path, $data)
  {
    if(!is_array($path)and strstr($path,$this->getDelimiter())){$path = explode($this->getDelimiter(), $path);}
    if(is_array($path))
    {
      $key = array_shift($path);
      $path = implode($this->getDelimiter(),$path);
      return $this->getElement($path, $data[$key]);
    }
    else
    {
      if(is_array($data) and array_key_exists($path, $data))
      {
        return $data[$path];
      }
      else
      {
        return $data;
      }
    }
  }

  /**
   * internal check for element key
   * @param string $path
   * @param mixed $data
   * @return bool
   */
  protected function hasElement($path, $data)
  {
    if(substr($path,-1,1)==$this->getDelimiter())
    {
      $path = substr($path,0,-1);
    }
    if(!is_array($path) and strstr($path, $this->getDelimiter())){
      $path = explode($this->getDelimiter(), $path);
    }
    if(is_array($path))
    {
      $key = array_shift($path);
      $path = implode($this->getDelimiter(),$path);
      
      if(!array_key_exists($key, $data)) return false;
        
      $dat = $this->hasElement($path, $data[$key]);

      if(is_array($dat))
      {
        return $dat;
      }
      elseif(!empty($dat))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return (is_array($data) and array_key_exists($path, $data)?true:false);
    }
  }

  /**
   * first level setter (fluent design)
   * overwrites key
   * @param string $name
   * @param mixed $value
   * @return ArrayHelper
   */
  public function add($name, $value)
  {
    if(!array_key_exists($name, $this->flat_properties))
    {
      $this->flat_properties[$name] = $value;
    }
    if(strstr($name, $this->getDelimiter()))
    {
      $values = $this->insertElements($name, $value);
      $k = key($values);
      if(array_key_exists($k, $this->properties))
      {
        $this->properties = self::array_merge_recursive_distinct($this->properties, $values);
      }
      else
      {
        $this->properties[$k] = $values[$k];
      }
    }
    else
    {
      $this->properties[$name] = $value;
    }
    return $this;
  }

  public function set($name, $value)
  {
    if(!array_key_exists($name, $this->flat_properties))
    {
      $this->flat_properties[$name] = $value;
    }
    $data = $this->properties;
    $a = new ArrayHelper($this->getDelimiter());
    $a->add($name, $value);
    $a = $a->getAll();
    $this->properties = self::array_merge_recursive_distinct ($data, $a);
    unset($a);
    return $this;
  }

  public function find($value)
  {
    if(($x = array_search($value, $this->flat_properties))) return $x;
    return false;
  }

  /**
   * Flatten an array so that resulting array is of depth 1.
   * If any value is an array itself, it is merged by parent array, and so on.
   *
   * @param array $array
   * @param bool $preserver_keys OPTIONAL When true, keys are preserved when mergin nested arrays (=> values with same key get overwritten)
   * @return array
   */
  public function flatten($array, $preserve_keys = false)
  {
    if (!$preserve_keys) {
        // ensure keys are numeric values to avoid overwritting when array_merge gets called
        $array = array_values($array);
    }

    $flattened_array = array();
    foreach ($array as $k => $v)
    {
      if (is_array($v)) {
          $flattened_array = array_merge($flattened_array, $this->flatten($v, $preserve_keys));
      } elseif ($preserve_keys) {
          $flattened_array[$k] = $v;
      } else {
          $flattened_array[] = $v;
      }
    }
    return $flattened_array;
  }

  public static function array_merge_recursive_distinct ( array &$array1, array &$array2 )
  {
    $merged = $array1;
    foreach ( $array2 as $key => &$value )
    {
      if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
      {
        $merged [$key] = self::array_merge_recursive_distinct ( $merged [$key], $value );
      }
      else
      {
        $merged [$key] = $value;
      }
    }
    return $merged;
  }

  /**
   * check for existance of value
   * @param string $name
   * @param mixed $value
   * @return bool
   */
  public function isIn($name, $value)
  {
    if(strstr($name,$this->getDelimiter()))
    {
      $path = explode($this->getDelimiter(), $name);
      $key = array_shift($path);
      $path = implode($this->getDelimiter(),$path);
      $data = $this->getElement($path,$this->properties[$key]);
      if(is_array($data))
      {
        return (in_array($value, $data));
      }
      else
      {
        return false;
      }
    }
    else
    {
      $data = $this->properties[$name];
      if(is_array($data))
      {
        return (in_array($value, $data));
      }
      else
      {
        return false;
      }
    }
  }

  /**
   * change delimiter sign
   * @param string $delimiter used to split path levels
   * @return string
   */
  public function setDelimiter($delimiter='/')
  {
    if (0==strlen($delimiter)|| empty($delimiter))
    {
       return $this;
    }
    $this->_delimiter = $delimiter;
  }

  /**
   * @return string
   */
  public function getDelimiter()
  {
    return $this->_delimiter;
  }

  /**
   * @static
   * @param string|array $path
   * @param mixed $data
   * @return mixed
   */
  private function insertElements($path, $data)
  {
    if(is_array($path) and count($path)==1)
    {
      $path = array_shift($path);
    }
    elseif(is_array($path) and count($path)==1)
    {
      return $path;
    }
    if(is_string($path) and substr($path,-1,1)==$this->getDelimiter())
    {
      $path = substr($path,0,-1);
    }
    if(!is_array($path)){
      $path = explode($this->getDelimiter(), $path);
    }
    // take last and add as key to properties
    if (($key = array_pop($path)))
    {
      return $this->insertElements($path, array($key=>$data));
    }
    return $data;
  }

  /**
   * returns properties
   * @return array
   */
  public function getAll()
  {
    $return = $this->properties;
    $this->properties = NULL;
    return $return;
  }  
  public function fetchAll()
  {
    $return = $this->properties;
    return $return;
  }

  /**
   * unset properties
   * @return ArrayHelper
   */
  public function clear()
  {
    $this->properties = NULL;
    return $this;
  }

}

