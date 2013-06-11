<?php
/**
 * ����� ��� ������ � ������� �� ��������� FTP
 * 
 * @category	Networking
 * @author		Sergeev Denis <hharek@yandex.ru>
 * @copyright	2011 Sergeev Denis
 * @license		https://github.com/hharek/zn_ftp/wiki/MIT-License MIT License
 * @version		0.2.3
 * @link		https://github.com/hharek/zn_ftp/
 */
class ZN_FTP
{

	/**
	 * ���������� �����������
	 * 
	 * @var resource
	 */
	private $_conn_id;

	/**
	 * ����
	 * 
	 * @var string
	 */
	private $_host;

	/**
	 * ������������
	 * 
	 * @var string
	 */
	private $_user;

	/**
	 * ������
	 * 
	 * @var string
	 */
	private $_pass;

	/**
	 * ���� �� ��������� (��� ������������� �����)
	 * 
	 * @var string
	 */
	private $_path;

	/**
	 * ����
	 * 
	 * @var int
	 */
	private $_port;

	/**
	 * �������������� ssl
	 * 
	 * @var bool
	 */
	private $_ssl;

	/**
	 * �������
	 * 
	 * @var int
	 */
	private $_timeout = 90;

	/**
	 * ��������� chroot
	 * 
	 * @var bool
	 */
	private $_chroot = false;

	/**
	 * ��������� ����� ��� zip ������
	 * 
	 * @var array
	 */
	private $_zip_tmp_file = array();


  /**
	* ��������� ������ ��� ����������
	*
	* @param string $host
	* @param string $user
	* @param string $pass
	* @param string $path
	* @param int    $port
	* @param bool   $ssl
	*
	* @throws Exception
	* @return \ZN_FTP
	*/

	public function __construct($host, $user, $pass, $path="/", $port=21, $ssl=false)
	{
		/* �������� */
		$host = trim($host);
		if (empty($host))
		{
			throw new Exception("FTP-���� �� �����.", 11);
		}

		$user = trim($user);
		if (empty($user))
		{
			throw new Exception("FTP-������������ �� �����.", 12);
		}

		/* �������� ���� */
		$path = trim($path);
		if (empty($path))
		{
			throw new Exception("�������� ����� ��� FTP-������� �� ������.", 13);
		}
		if (mb_substr($path, 0, 1, "windows-1251") != "/")
		{
			throw new Exception("�������� ����� \"{$path}\" ��� FTP-������� ������ �������.", 14);
		}
		$path = $this->_normalize_path($path);

		$port = (int) $port;
		if (empty($port))
		{
			throw new Exception("FTP-���� �� �����.", 15);
		}

		$ssl = (boolean) $ssl;

		/* ��������� */
		$this->_host = $host;
		$this->_user = $user;
		$this->_pass = $pass;
		$this->_path = $path;
		$this->_port = $port;
		$this->_ssl = $ssl;

		/* ���� ���������� ��� ��������� ������ */
		$this->_conn_id = &$this->_conn_id;
		
		return true;
	}

	/**
	 * ����������
	 * 
	 * @return bool
	 */
	public function __destruct()
	{
	   foreach ($this as $key => $value) {
		 unset($this->$key);
	  }
		 $this->close();
		return true;
	}

	/**
	 * ������������
	 * 
	 * @return bool
	 * @throws Exception
	 */
  public function connect()
	{
		if (empty($this->_conn_id))
		{
			/* ����������� � ����� */
			if ($this->_ssl == false)
			{
				$this->_conn_id = @ftp_connect($this->_host, $this->_port, $this->_timeout);
			}
			else
			{
				$this->_conn_id = @ftp_ssl_connect($this->_host, $this->_port, $this->_timeout);
			}

			if (!$this->_conn_id)
			{
				$error = error_get_last();
				throw new Exception("�� ������� ���������� ���������� � FTP-��������. " . $error['message'], 21);
			}

			/* ��������� ������� */
			if ($this->_timeout != 30)
			{
				@ftp_set_option($this->_conn_id, FTP_TIMEOUT_SEC, $this->_timeout);
			}

			/* ������������� */
			$login = @ftp_login($this->_conn_id, $this->_user, $this->_pass);
			if (!$login)
			{
				$error = error_get_last();
				throw new Exception("����� � ������ ��� FTP-������� ������ �������. " . $error['message'], 22);
			}

			/* ��������� ���������� ������ */
			if (!@ftp_pasv($this->_conn_id, true))
			{
				$error = error_get_last();
				throw new Exception("�� ������� �������� ��������� ����� ��� FTP-�������. " . $error['message'], 23);
			}

			/* ������� ��������� */
			if (!$this->is_dir($this->_path))
			{
				throw new Exception("FTP-����� \"{$this->_path}\" �� ����������.", 24);
			}
		}

		return true;
	}

	/**
	 * ������� ����������
	 * 
	 * @return bool
	 */
	public function close()
	{
		if (!empty($this->_conn_id))
		{
			@ftp_close($this->_conn_id);
		}

		return true;
	}

	/**
	 * ��������� �������
	 * 
	 * @param int $timeout
	 * @return bool
	 */
	public function set_timeout($timeout)
	{
		$timeout = (int) $timeout;
		$this->_timeout = $timeout;

		if (!empty($this->_conn_id))
		{
			if ($this->_timeout != 30)
			{
				@ftp_set_option($this->_conn_id, FTP_TIMEOUT_SEC, $this->_timeout);
			}
		}

		return true;
	}

	/**
	 * ����� �� ���������
	 * 
	 * @param string $path
	 * @return bool
	* @throws Exception
	*/
  public function set_path($path)
	{
		if($path == $this->_path)
		{
			return true;
		}
		
		$path = trim($path);
		if (substr($path, 0, 1) != "/")
		{
			throw new Exception("������������ FTP-����� \"" . func_get_arg(0) . "\" ������ �������.", 31);
		}

		$path = $this->_normalize_path($path);

		if (!empty($this->_conn_id))
		{
			if (!$this->is_dir($path))
			{
				throw new Exception("FTP-����� \"" . func_get_arg(0) . "\" �� ����������.", 32);
			}
		}

		$this->_path = $path;

		return true;
	}

	/**
	 * �������� ����� �� ���������
	 * @return bool
	 * @return string
	 */
  public function get_path()
	{
		return $this->_path;
	}

	/**
	 * �������� chroot
	 * 
	 * @return bool
	 */
	public function chroot_enable()
	{
		$this->_chroot = true;
		return true;
	}

	/**
	 * ��������� chroot
	 * 
	 * @return bool
	 */
	public function chroot_disable()
	{
		$this->_chroot = false;
		return true;
	}

	/**
	 * �������� �� ������������� �����
	 * 
	 * @param string $file
	 * @return bool
	 */
	public function is_file($file)
	{
		/* �������� */
		$file = $this->_normalize_path($file);
		$this->_check_chroot($file);

		if ($file == "/")
		{
			return false;
		}

		/* ���������� */
		$this->connect();

		/* �������� ����� */
		$type = $this->_get_type_file($file);
		if ($type == "file")
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * �������� �� ������������� ��������
	 * 
	 * @param string $path
	 * @return bool
	 */
	public function is_dir($path)
	{
		/* �������� */
		$path = $this->_normalize_path($path);
		$this->_check_chroot($path);

		if ($path == "/")
		{
			return true;
		}

		 $rtrn=$this->connect();
		 if(true==$rtrn && strlen($path)>0){
			$cur_dir=ftp_pwd($this->_conn_id);
			if(@ftp_chdir($this->_conn_id, $path)){
			  ftp_chdir($this->_conn_id, $cur_dir);
			  $rtrn=true;
			}else $rtrn=false;
//			echo('DIR: '.$cur_dir.$this->ftpInfo['ftproot'].$p_dir);
		 }else $rtrn=false;
		 return $rtrn;
	}


  /**
	 * ������ ��������� � ������ � �����
	 * 
	 * @param string $path
	 * @param string $type (all|dir|file)
	 * @param string $ext
	 * @return array
	 * @throws Exception
	 */
  public function ls($path, $type="all", $ext="")
	{
		/* �������� */
		$path = $this->_normalize_path($path);
		$this->_check_chroot($path);

		$type = trim($type);
		if (!in_array($type, array('all', 'file', 'dir')))
		{
			throw new Exception("��� \"" . func_get_arg(1) . "\" ����� �������. ���������� �������: (all|file|dir).", 41);
		}
		
		$ext = trim($ext);
		if ($type != "file" and mb_strlen($ext, "windows-1251") > 0)
		{
			throw new Exception("���������� ����� ������ ������ ��� ������.", 42);
		}

		if (!empty($ext) and !preg_match("#^[a-zA-Z0-9]{1,5}$#isu", $ext))
		{
			throw new Exception("���������� \"" . func_get_arg(2) . "\" ������ �������.", 43);
		}

		/* ���������� */
		$this->connect();

		/* ������ */
		if (!$this->is_dir($path))
		{
			throw new Exception("FTP-����� \"" . func_get_arg(0) . "\" �� ����������", 44);
		}

		$ls = array();
		$raw_list = @ftp_rawlist($this->_conn_id, $path);
		if (!empty($raw_list))
		{
			foreach ($raw_list as $val)
			{
				$file_settings = $this->_raw_razbor($val);
				if (empty($file_settings) or $file_settings['name'] == "." or $file_settings['name'] == "..")
				{
					continue;
				}

				switch ($type)
				{
					case "all":
					{
						$ls[] = $file_settings;
					}
					break;

					case "dir":
					{
						if ($file_settings['type'] == "dir")
						{
							$ls[] = $file_settings;
						}
					}
					break;

					case "file":
					{
						if ($file_settings['type'] == "file")
						{
							if (substr($file_settings['name'], strlen($file_settings['name']) - mb_strlen($ext), strlen($ext)) == $ext)
							{
								$ls[] = $file_settings;
							}
						}
					}
					break;
				}
			}
		}

		return $ls;
	}

	/**
	 * �������� ���������� �����
	 * 
	 * @param string $file
	 * @return string
	 * @throws Exception
	 */
  public function get($file)
	{
		/* �������� */
		$file = $this->_normalize_path($file);
		$this->_check_chroot($file);

		/* ���������� */
		$this->connect();

		/* ���������� ����� */
		if (!$this->is_file($file))
		{
			throw new Exception("FTP-����� � ������ \"" . func_get_arg(0) . "\" �� ����������.", 51);
		}

		$tmp_file = tmpfile();

		if (!@ftp_fget($this->_conn_id, $tmp_file, $file, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� ��������� FTP-���� \"" . func_get_arg(0) . "\". " . $error['message'], 52);
		}

		fseek($tmp_file, 0);
		$content = "";
		while (!feof($tmp_file))
		{
			$content .= fread($tmp_file, 1024);
		}
		fclose($tmp_file);

		return $content;
	}

	/**
	 * �������� ������ � ����
	 * 
	 * @param string $file
	 * @param string $content 
	 * @return bool
	 * @throws Exception
	 */
	public function put($file, $content)
	{
		/* �������� */
		$file = $this->_normalize_path($file);
		$this->_check_chroot($file);

		/* ���������� */
		$this->connect();

		/* �������� ����� */
		$file_type = $this->_get_type_file($file);
		if ($file_type == "dir")
		{
			throw new Exception("���������� �������� ������ � FTP-�����.", 61);
		}
		elseif ($file_type == "null")
		{
			$file_ar = explode("/", $file);
			$file_name = array_pop($file_ar);
			if (count($file_ar) != 1)
			{
				$file_up = implode("/", $file_ar);
			}
			else
			{
				$file_up = "/";
			}
			$file_up_type = $this->_get_type_file($file_up);
			if ($file_up_type != "dir")
			{
				throw new Exception("��� FTP-����� \"" . func_get_arg(0) . "\" ������ �������.", 62);
			}
		}

		/* �������� */
		$tmp_file = tmpfile();
		fwrite($tmp_file, $content);
		fseek($tmp_file, 0);

		if (!@ftp_fput($this->_conn_id, $file, $tmp_file, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� �������� ������ � FTP-���� \"" . func_get_arg(0) . "\". " . $error['message'], 63);
		}
		fclose($tmp_file);

		return true;
	}

	/**
	 * ������� �����
	 * 
	 * @param string $path 
	 * @return bool
	 * @throws Exception
	 */
	public function mkdir($path)
	{
		/* �������� */
		$path = $this->_normalize_path($path);
		$this->_check_chroot($path);

		/* ���������� */
		$this->connect();

		/* ������� ����� */
		if (!ftp_mkdir($this->_conn_id, $path))
		{
			$error = error_get_last();
			throw new Exception("�� ������� ������� FTP-����� \"" . func_get_arg(0) . "\". " . $error['message'], 71);
		}

		return true;
	}

	/**
	 * ���������� �����
	 * 
	 * @param string $source
	 * @param string $dest
	 * @return bool
	 * @throws Exception
	 */
  public function cp($source, $dest)
	{
		/* �������� */
		$source = $this->_normalize_path($source);
		$this->_check_chroot($source);
		if ($source == "/")
		{
			throw new Exception("FTP-���� �������� \"" . func_get_arg(0) . "\" ����� �������.", 81);
		}

		$dest = $this->_normalize_path($dest);
		$this->_check_chroot($dest);

		/* ���������� */
		$this->connect();



	/*	if( is_file($source))
		{
			throw new Exception("FTP-���� �������� \"" . func_get_arg(0) . "\" ����� �������.", 84);
		}*/

		
		/* ����������� */
		if ($this->is_dir($source) == false)
		{
			if ($this->is_dir($dest) == true)
			{
				$dest .= "/" . basename($source);
				if ($source == $dest)
				{
					throw new Exception("FTP-���� �������� � FTP-���� ���������� - ��� ���� � ��� �� ����.", 82);
				}
			}
			$this->_cp_file($source, $dest);
		}
		else
		{
			$dest .= "/" . basename($source);
			if ($source == $dest)
			{
				throw new Exception("FTP-����� �������� � FTP-����� ���������� - ��� ���� � �� �� �����.", 83);
			}
			$this->_cp_dir($source, $dest);
		}
		
		return true;
	}

	/**
	 * ��������� ��� ������������� ���� ��� �����
	 * 
	 * @param string $source
	 * @param string $dest 
	 * @return bool
	 * @throws Exception
	 */
	public function mv($source, $dest)
	{
		/* �������� */
		$source = $this->_normalize_path($source);
		$this->_check_chroot($source);
		if ($source == "/")
		{
			throw new Exception("FTP-���� �������� \"" . func_get_arg(0) . "\" ����� �������.", 91);
		}

		$dest = $this->_normalize_path($dest);
		$this->_check_chroot($dest);

		/* ���������� */
		$this->connect();

		$type_dest = $this->_get_type_file($dest);
		if ($type_dest == "dir")
		{
			$dest .= "/" . basename($source);
			if ($source == $dest)
			{
				throw new Exception("FTP-���� �������� � FTP-���� ���������� - ��� ���� � ��� �� ����.", 92);
			}
		}

		if (!@ftp_rename($this->_conn_id, $source, $dest))
		{
			$error = error_get_last();
			throw new Exception("�� ������� ��������� \"" . func_get_arg(0) . "\" � \"" . func_get_arg(1) . "\". " . $error['message'], 93);
		}

		return true;
	}

	/**
	 * ������� ���� ��� �����
	 * 
	 * @param string $file 
	 * @return bool
	 * @throws Exception
	 */
	public function rm($file)
	{
		/* �������� */
		$file = $this->_normalize_path($file);
		$this->_check_chroot($file);

		/* ���������� */
		$this->connect();

		$type = $this->_get_type_file($file);
		if ($type == "null")
		{
			throw new Exception("FTP-����� � ������ \"" . func_get_arg(0) . "\" �� ����������.", 101);
		}

		/* �������� */
		if ($type == "file")
		{
			if (!@ftp_delete($this->_conn_id, $file))
			{
				$error = error_get_last();
				throw new Exception("�� ������� ������� FTP-���� \"" . func_get_arg(0) . "\". " . $error['message'], 102);
			}
		}
		elseif ($type == "dir")
		{
			$this->_rm_dir($file);
		}

		return true;
	}

	/**
	 * ������������� ����� ������� � ����� ��� �����
	 * 
	 * @param string $file
	 * @param int $mode
	 * @param bool $recursion 
	 * @return bool
	 * @throws Exception
	 */
	public function chmod($file, $mode, $recursion=true)
	{
		/* �������� */
		$file = $this->_normalize_path($file);
		$this->_check_chroot($file);

		/* ���������� */
		$this->connect();

		$type = $this->_get_type_file($file);
		if ($type == "null")
		{
			throw new Exception("FTP-����� � ������ \"" . func_get_arg(0) . "\" �� ����������.", 111);
		}

		$mode = (int) $mode;
		$recursion = (bool) $recursion;

		/* ���������� ����� ������� */
		if ($recursion == false or $type == "file")
		{
			if (!@ftp_chmod($this->_conn_id, $mode, $file))
			{
				$error = error_get_last();
				throw new Exception("�� ������� ���������� ����� \"" . func_get_arg(1) . "\" �� FTP-���� \"" . func_get_arg(0) . "\". " . $error['message'], 112);
			}
		}
		else
		{
			$this->_chmod_dir($file, $mode);
		}

		return true;
	}

	/**
	 * �������� ������ ����� ��� ����� � ������
	 * 
	 * @param string $file 
	 * @return int
	 * @throws Exception
	 */
	public function size($file)
	{
		/* �������� */
		$file = $this->_normalize_path($file);
		$this->_check_chroot($file);

		/* ���������� */
		$this->connect();

		$type = $this->_get_type_file($file);
		if ($type == "null")
		{
			throw new Exception("FTP-����� � ������ \"" . func_get_arg(0) . "\" �� ����������.", 121);
		}
	   $size = 0;
		/* �������� ������ */
		if ($type == "file")
		{
			$size = $this->_size_file($file);
		}
		elseif ($type == "dir")
		{
			$dir_ar = explode("/", $file);
			$dir_name = array_pop($dir_ar);
			if (count($dir_ar) != 1)
			{
				$dir_up = implode("/", $dir_ar);
			}
			else
			{
				$dir_up = "/";
			}
			$raw_list_up = @ftp_rawlist($this->_conn_id, $dir_up);

			foreach ($raw_list_up as $val)
			{
				$file_settings = $this->_raw_razbor($val);
				if ($file_settings['name'] == $dir_name and $file_settings['type'] == "dir")
				{
					$size = $file_settings['size'];
					break;
				}
			}

			$size += $this->_size_dir($file);
		}

		return $size;
	}

	/**
	 * ��������� ���� �� ftp-������
	 * 
	 * @param string $file
	 * @param string $ftp_file
	 * @param bool $check_form_upload 
	 * @return bool
	 * @throws Exception
	 */
	public function upload($file, $ftp_file, $check_form_upload=false)
	{
		/* �������� */
		$file = trim($file);
	   $test = substr($file, 0, 1);
		if ($test != "/" && $test != "f")
		{
			throw new Exception("��� ����� \"" . func_get_arg(0) . "\" ������ �������.", 131);
		}
	  if ($test != "f")
		 {
		$file = $this->_normalize_path($file);
		 }
		if (!is_file($file))
		{
			throw new Exception("����� \"" . func_get_arg(0) . "\" �� ����������.", 132);
		}

		$ftp_file = $this->_normalize_path($ftp_file);
		$this->_check_chroot($ftp_file);

		$ftp_file_ar = explode("/", $ftp_file); // ������� �� ������
		$ftp_file_name = array_pop($ftp_file_ar); // �������� �� ������� ��������� ������� - ��� ����� ����������
		if (count($ftp_file_ar) != 1)
		{
			$ftp_file_up = implode("/", $ftp_file_ar); // ������� ������ � ������
		}
		else
		{
			$ftp_file_up = "/";
		}

		/* ���������� */
		$this->connect();

		if ($this->is_dir($ftp_file_up) == false)
		{
			throw new Exception("��� FTP-����� \"" . func_get_arg(1) . "\" ������ �������.", 133);
		}
		if($this->is_dir($ftp_file) == true)
		{
			$ftp_file = $ftp_file . "/" . basename($file);
		}

		$check_form_upload = (bool) $check_form_upload;

		if ($check_form_upload)
		{
			if (!is_uploaded_file($file))
			{
				throw new Exception("���� \"" . func_get_arg(0) . "\" �������� �� ��� ������ HTTP POST", 134);
			}
		}

		/* ��������� */
		$fp = @fopen($file, "rb");
		if ($fp === false)
		{
			$error = error_get_last();
			throw new Exception("�� ������� ������� ���� \"" . func_get_arg(0) . "\". " . $error['message'], 135);
		}

		if (!@ftp_fput($this->_conn_id, $ftp_file, $fp, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� �������� � FTP-���� \"" . func_get_arg(1) . "\". " . $error['message'], 136);
		}
		fclose($fp);

		return true;
	}

	/**
	 * ��������� �����
	 * 
	 * @param string $dir
	 * @param string $ftp_dir
	 * @return bool
	 * @throws Exception
	 */
	public function upload_dir($dir, $ftp_dir)
	{
		/* �������� ����� */
		$dir = trim($dir);
		if (substr($dir, 0, 1) != "/")
		{
			throw new Exception("������������ ����� \"" . func_get_arg(0) . "\" ������ �������.", 141);
		}
		$dir = $this->_normalize_path($dir);
		if (!is_dir($dir))
		{
			throw new Exception("����� \"" . func_get_arg(0) . "\" �� ����������.", 142);
		}

		/* �������� FTP-����� */
		$ftp_dir = $this->_normalize_path($ftp_dir);
		$this->_check_chroot($ftp_dir);

		$ftp_dir_ar = explode("/", $ftp_dir);
		$ftp_dir_name = array_pop($ftp_dir_ar);
		if (count($ftp_dir_ar) != 1)
		{
			$ftp_dir_up = implode("/", $ftp_dir_ar);
		}
		else
		{
			$ftp_dir_up = "/";
		}

		/* ���������� */
		$this->connect();

		$ftp_dir_type_up = $this->_get_type_file($ftp_dir_up);
		if ($ftp_dir_type_up != "dir")
		{
			throw new Exception("��� FTP-����� \"" . func_get_arg(1) . "\" ������ �������.", 143);
		}

		$ftp_dir_type = $this->_get_type_file($ftp_dir);

		/* ������� ����� � ������ ���������� */
		if ($ftp_dir_type == "file")
		{
			throw new Exception("FTP-����� \"" . func_get_arg(1) . "\" �������� ������.", 144);
		}
		elseif ($ftp_dir_type == "null")
		{
			if (!@ftp_mkdir($this->_conn_id, $ftp_dir))
			{
				$error = error_get_last();
				throw new Exception("�� ������� ������� FTP-����� \"" . func_get_arg(1) . "\". " . $error['message'], 145);
			}
		}
		elseif ($ftp_dir_type == "dir")
		{
			if ($this->_get_type_file($ftp_dir . "/" . basename($dir)) != "null")
			{
				throw new Exception("FTP-����� \"" . $ftp_dir . "/" . basename($dir) . "\" ��� ����������.", 146);
			}

			if (!@ftp_mkdir($this->_conn_id, $ftp_dir . "/" . basename($dir)))
			{
				$error = error_get_last();
				throw new Exception("�� ������� ������� ����� \"" . $ftp_dir . "/" . basename($dir) . "\". " . $error['message'], 147);
			}

			$ftp_dir = $ftp_dir . "/" . basename($dir);
		}

		/* �������� */
		$this->_upload_dir($dir, $ftp_dir);

		return true;
	}

	/**
	 * ������� ����
	 * 
	 * @param string $ftp_file
	 * @param string $file
	 * @return bool
	 * @throws Exception
	 */
	public function download($ftp_file, $file="")
	{
		/* �������� */
		$ftp_file = $this->_normalize_path($ftp_file);
		$this->_check_chroot($ftp_file);

		if (strlen($file) > 0)
		{
			$file = trim($file);
			if (substr($file, 0, 1) != "/")
			{
				throw new Exception("��� ����� \"" . func_get_arg(1) . "\" ������ �������.", 151);
			}
			$file = $this->_normalize_path($file);
			$fp = @fopen($file, "wb");
			if ($fp === false)
			{
				throw new Exception("��� ����� \"" . func_get_arg(1) . "\" ������ �������.", 152);
			}
			fclose($fp);
		}

		if (!is_file($ftp_file))
		{
			throw new Exception("FTP-���� \"" . func_get_arg(0) . "\" �� ����������.", 153);
		}

		/* ������� */
		$tmp_file = tmpfile();
		if (!@ftp_fget($this->_conn_id, $tmp_file, $ftp_file, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� �������� ���������� FTP-����� \"" . func_get_arg(0) . "\". " . $error['message'], 154);
		}
		fseek($tmp_file, 0);

		/* ��������� */
		if (strlen($file) < 1)
		{
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"" . basename($ftp_file) . "\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: " . $this->_size_file($ftp_file));

			while (!feof($tmp_file))
			{
				echo fread($tmp_file, 4096);
			}

			fclose($tmp_file);
		}
		/* �������� � ���� */
		else
		{
			$fp = fopen($file, "wb");
			while (!feof($tmp_file))
			{
				fwrite($fp, fread($tmp_file, 4096));
			}

			fclose($fp);
			fclose($tmp_file);
		}

		return true;
	}

	/**
	 * ������� �����
	 * 
	 * @param string $ftp_dir
	 * @param string $dir
	 * @return bool
	 * @throws Exception
	 */
	public function download_dir($ftp_dir, $dir)
	{
		/* �������� */
		$ftp_dir = $this->_normalize_path($ftp_dir);
		$this->_check_chroot($ftp_dir);
		if (!$this->is_dir($ftp_dir))
		{
			throw new Exception("FTP-����� \"" . func_get_arg(0) . "\" �� ����������.", 161);
		}

		$dir = trim($dir);
		if (substr($dir, 0, 1) != "/")
		{
			throw new Exception("������������ ����� \"" . func_get_arg(1) . "\" ������ �������.", 162);
		}
		$dir = $this->_normalize_path($dir);
		if (!is_dir($dir))
		{
			$dir_ar = explode("/", $dir);
			$dir_name = array_pop($dir_ar);
			if (count($dir_ar) != 1)
			{
				$dir_up = implode("/", $dir_ar);
			}
			else
			{
				$dir_up = "/";
			}

			if (!is_dir($dir_up))
			{
				throw new Exception("����� \"" . func_get_arg(1) . "\" ������ �������.", 163);
			}
			else
			{
				if (!@mkdir($dir))
				{
					$error = error_get_last();
					throw new Exception("�� ������� ������� ����� \"" . func_get_arg(1) . "\". " . $error['message'], 164);
				}
			}
		}
		else
		{
			$dir = $dir . "/" . basename($ftp_dir);
			if (!@mkdir($dir))
			{
				$error = error_get_last();
				throw new Exception("�� ������� ������� ����� \"" . func_get_arg(1) . "\". " . $error['message'], 165);
			}
		}

		/* ������� */
		$this->_download_dir($ftp_dir, $dir);

		return true;
	}

	/**
	 * ������� ����� � ����� ����� �������
	 * 
	 * @param array|string $ftp_paths
	 * @param string $file_name
	 * @param string $zip_file
	 * @return bool
	 * @throws Exception
	 */
	public function zip($ftp_paths, $file_name="", $zip_file="")
	{
		/* �������� */
		if (empty($ftp_paths))
		{
			throw new Exception("�� ������ FTP-�����.", 171);
		}

		if (!is_array($ftp_paths) and !is_scalar($ftp_paths))
		{
			throw new Exception("FTP-�����, ������ �������", 172);
		}

		if (is_scalar($ftp_paths))
		{
			$ftp_paths = (array)$ftp_paths;
		}

		/* ������������ ���� */
		$this->connect();
		$ftp_basename = array();
		$ftp_path_all = array();
		foreach ($ftp_paths as $key => $val)
		{
			$path_old = $val;
			$path = $this->_normalize_path($val);
			$this->_check_chroot($path);
			$type = $this->_get_type_file($path);
			if ($type == "null")
			{
				throw new Exception("FTP-����� \"{$path_old}\" �� ����������.", 173);
			}

			$ftp_path_all[$key]['name'] = $this->_add_unique_name(basename($path), $ftp_basename);
			$ftp_path_all[$key]['type'] = $type;
			$ftp_path_all[$key]['path'] = $path;
		}

		/* filename */
		if (strlen($file_name) < 1)
		{
			$file_name = "default.zip";
		}

		$file_name = trim($file_name);
		if ($file_name == "." or $file_name == "/")
		{
			throw new Exception("��� ����� \"" . func_get_arg(1) . "\" ������ �������.", 174);
		}
		$file_name = $this->_normalize_path($file_name);
		$file_name = basename($file_name);

		/* zip_file */
		if (strlen($zip_file) > 0)
		{
			$zip_file = trim($zip_file);
			if (substr($zip_file, 0, 1) != "/")
			{
				throw new Exception("������������ zip-����� \"" . func_get_arg(2) . "\" ������ �������.", 175);
			}
			$zip_file = $this->_normalize_path($zip_file);
			$zfp = @fopen($zip_file, "wb");
			if ($zfp === false)
			{
				throw new Exception("��� zip-����� \"" . func_get_arg(2) . "\" ������ �������.", 176);
			}
			fclose($zfp);
			unlink($zip_file);
		}
		else
		{
			$zip_file = tempnam(sys_get_temp_dir(), "znf");
		}

		/* ������� zip-���� */
		$zip = new ZipArchive();
		$result = $zip->open($zip_file, ZIPARCHIVE::CREATE);
		if ($result !== true)
		{
			throw new Exception("�� ������� ������� zip-����� � ����� \"" . func_get_arg(2) . "\".", 177);
		}

		/* �������������� */
		foreach ($ftp_path_all as $val)
		{
			if ($val['type'] == "dir")
			{
				$this->_zip_dir($zip, $val['name'], $val['path']);
			}
			elseif ($val['type'] == "file")
			{
				$this->_zip_file($zip, $val['name'], $val['path']);
			}
		}

		$zip->close();

		/* ������� ��������� ����� */
		if (!empty($this->_zip_tmp_file))
		{
			foreach ($this->_zip_tmp_file as $val)
			{
				@unlink($val);
			}
		}

		/* ������ */
		$func_args = func_get_args();
		if (mb_strlen($func_args[2], "windows-1251") < 1)
		{
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"{$file_name}\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: " . filesize($zip_file));

			$zp = fopen($zip_file, "rb");
			while (!feof($zp))
			{
				echo fread($zp, 4096);
			}
			fclose($zp);

			unlink($zip_file);
		}

		return true;
	}

	/**
	 * �������� ����
	 * 
	 * @param string $path
	 * @return bool
	 * @throws Exception
	 */
	private function _check_path($path)
	{
		$path = (string) $path;

		/* ������ ������ */
		$path = trim($path);
		if (strlen($path) < 1)
		{
			throw new Exception("���� ����� �������. ������ ������.", 181);
		}

		/* ������ "." */
		if ($path == "." or $path == "/")
		{
			return true;
		}

		/* ������ � ������� �������� */
		$strlen_before = strlen($path);
		$path = str_replace(chr(0), '', $path);
		$strlen_after = strlen($path);
		if ($strlen_before != $strlen_after)
		{
			throw new Exception("���� ����� �������. ������� ������.", 182);
		}


		/* ����� ������� ������ */
		if (strlen($path) > 1024)
		{
			throw new Exception("���� ����� �������. ����� ������� ������.", 184);
		}

		/* ������������ ������� */
		$result = strpbrk($path, "\n\r\t\v\f\$\\");
		if ($result !== false)
		{
			throw new Exception("���� ����� �������. ������������ �������.", 185);
		}

		/* ������� ������� ����� � ������ � ����� */
		if (substr($path, 0, 1) == "/")
		{
			$path = substr($path, 1, mb_strlen($path) - 1);
		}

		if (substr($path, strlen($path) - 1, 1) == "/")
		{
			$path = mb_substr($path, 0, mb_strlen($path) - 1);
		}

	  /* �������� ������, ���� ������� �� � windows-1251,UTF-8 */
	  $result = mb_detect_encoding($path, "windows-1251,UTF-8");
	  if ($result === false)
		 {
			throw new Exception("���� ����� �������. �������� ������, ���� ������� �� � windows-1251 ��� UTF-8", 183);
		 }

		/* ������ */
		$path_ar = explode("/", $path);
	   $ftp = '';
		foreach ($path_ar as $val)
		{
			/* �������� � ���� ".." � "." */
			if ($val == "." or $val == "..")
			{
				throw new Exception("���� \"" . func_get_arg(0) . "\" ����� �������. ������������ ��� ����� ��� \"..\" � \".\" ���������.", 186);
			}

			/* ������ � ���������� ��� ��������� ��������� */
			$strlen = strlen($val);
			$strlen_trim = strlen(trim($val));
			if ($strlen != $strlen_trim)
			{
				throw new Exception("���� \"" . func_get_arg(0) . "\" ����� �������. ������� � ������ ��� � ����� ����� �����.", 187);
			}

			/* �� ������� ��� ����� */
			$val_trim = trim($val);
			if (strlen($val_trim) < 1 && $ftp != 'ftp:')
			{
				throw new Exception("���� \"" . func_get_arg(0) . "\" ����� �������. �� ������ ��� �����.", 188);
			}
		  $ftp = $val;
		}

		return true;
	}

	/**
	 * �������� ���� � ����������� ����
	 * 
	 * @param string $path
	 * @return string
	 */
	private function _normalize_path($path)
	{
		/* �������� */
		$this->_check_path($path);
		$path = (string) $path;
		$path = trim($path);

		/* ������ "." */
		if ($path == ".")
		{
			return $this->_path;
		}

		/* ������ */
		if ($path == "/")
		{
			return $path;
		}

		/* ������������ */
		if (substr($path, 0, 1) != "/")
		{
			$path = ($this->_path == '/') ? $this->_path.$path : $this->_path."/".$path;
		}

		if (substr($path, strlen($path) - 1, 1) == "/")
		{
			$path = substr($path, 0, strlen($path) - 1);
		}

		return $path;
	}


  /**
	* @param        $resource
	* @param string $directory
	*
	* @return array
	*/
  function listDetailed($resource, $directory = '.') {
	 $items = array();
	 if (is_array($children = @ftp_rawlist($resource, $directory))) {
		foreach ($children as $child) {
		  $chunks = preg_split("/\s+/", $child);
		  list($item['rights'], $item['number'], $item['user'], $item['group'], $item['size'], $item['month'], $item['day'], $item['time']) = $chunks;
		  $item['type'] = $chunks[0]{0} === 'd' ? 'dir' : 'file';
		  array_splice($chunks, 0, 8);
		  $items[implode(" ", $chunks)] = $item;
		}
	 }
	 return $items;
  }


  /**
	 * �������� ��� ����� (null|file|dir)
	 * 
	 * @param string $file
	 * @return string
	 */
	/*private function _get_type_file($file)
	{*/
		/* ������������ */
		/*if ($file == "/")
		{
			return "dir";
		}*/

		/* ��� ����� */
//		$type = "null";

		/* �� ������� ������ */
		/*$file_ar = explode("/", $file);
		$file_name = array_pop($file_ar);
		if (count($file_ar) != 1)
		{
			$file_up = implode("/", $file_ar);
		}
		else
		{
			$file_up = "/";
		}*/

		/* FTP raw */
//		$raw_list_up = ftp_rawlist($this->_conn_id, $file_up);
	 //  $raw_list_up = $this->listDetailed($this->_conn_id, $file_up);
	/*	if (empty($raw_list_up))
		{
			return $type;
		}
		foreach ($raw_list_up as $val)
		{
			$file_settings = $this->_raw_razbor($val);
			if (strtolower($file_settings['name']) == strtolower($file_name))
			{
				$type = $file_settings['type'];
			}
		}

		return $type;
	}*/



	/**
	 * ������ ������ ���������� �������� ftp_rawlist
	 * 
	 * @param string $str
	 * @return array 
	 */
	/*private function _raw_razbor($str)
	{
		if (!preg_match("#([-d][rwxstST-]+).* ([0-9]*) ([a-zA-Z0-9]+).* ([a-zA-Z0-9]+).* ([0-9]*) ([a-zA-Z]+[0-9: ]*[0-9])[ ]+(([0-9]{2}:[0-9]{2})|[0-9]{4}) (.+)#isu", $str, $sovpal))
		{
			return false;
		}

		$file_settings = array();
		if (mb_substr($sovpal[1], 0, 1) == "d")
		{
			$file_settings['type'] = "dir";
		}
		else
		{
			$file_settings['type'] = "file";
		}

		$file_settings['line'] = $sovpal[0];
		$file_settings['rights'] = $sovpal[1];
		$file_settings['number'] = $sovpal[2];
		$file_settings['user'] = $sovpal[3];
		$file_settings['group'] = $sovpal[4];
		$file_settings['size'] = $sovpal[5];
		$file_settings['date'] = date("d.m.Y", strtotime($sovpal[6]));
		$file_settings['time'] = $sovpal[7];
		$file_settings['name'] = $sovpal[9];

		return $file_settings;
	}*/

	/**
	 * ���������� ����
	 *
	 * @param string $source
	 * @param string $dest
	 * @return bool
	 * @throws Exception
	 */
	private function _cp_file($source, $dest)
	{
		$tmp_file = tmpfile();
		if (!@ftp_fget($this->_conn_id, $tmp_file, $source, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� �������� ���������� FTP-����� \"{$source}\". " . $error['message'], 191);
		}
		fseek($tmp_file, 0);
		if (!@ftp_fput($this->_conn_id, $dest, $tmp_file, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� ��������� ������ � FTP-���� \"{$dest}\". " . $error['message'], 192);
		}
		fclose($tmp_file);

		return true;
	}

	/**
	 * ���������� �����
	 *
	 * @param string $source
	 * @param string $dest
	 * @return bool
	 */
	private function _cp_dir($source, $dest)
	{
		if (!$this->is_dir($dest))
		{
			$this->mkdir($dest);
		}

		$files = $this->ls($source);
		if (!empty($files))
		{
			foreach ($files as $val)
			{
				/* ���������� ���� */
				if ($val['type'] == "file")
				{
					$this->_cp_file($source . "/" . $val['name'], $dest . "/" . $val['name']);
				}
				/* ���������� ����� */
				elseif ($val['type'] == "dir")
				{
					$this->_cp_dir($source . "/" . $val['name'], $dest . "/" . $val['name']);
				}
			}
		}

		return true;
	}

	/**
	 * ������� �����
	 *
	 * @param string $dir
	 * @return bool
	 * @throws Exception
	 */
	private function _rm_dir($dir)
	{
		/* ������ ������ */
		$files = $this->ls($dir);

		if (!empty($files))
		{
			foreach ($files as $val)
			{
				/* ������� ���� */
				if ($val['type'] == "file")
				{
					if (!@ftp_delete($this->_conn_id, $dir . "/" . $val['name']))
					{
						$error = error_get_last();
						throw new Exception("�� ������� ������� FTP-���� \"." . $dir . "/" . $val['name'] . "\". " . $error['message'], 201);
					}
				}
				/* ������� ����� */
				elseif ($val['type'] == "dir")
				{
					$this->_rm_dir($dir . "/" . $val['name']);
				}
			}
		}

		/* ������� ������ ����� */
		if (!@ftp_rmdir($this->_conn_id, $dir))
		{
			$error = error_get_last();
			throw new Exception("�� ������� ������� FTP-����� \"{$dir}\". " . $error['message'], 202);
		}

		return true;
	}

	/**
	 * ���������� ���������� ����� �� �����
	 * 
	 * @param  $dir
	 * @param  $mode
	 * @return bool
	 * @throws Exception
	 */
  private function _chmod_dir($dir, $mode)
	{
		/* ������� ����� */
		if (!@ftp_chmod($this->_conn_id, $mode, $dir))
		{
			$error = error_get_last();
			throw new Exception("�� ������� ���������� ����� \"{$mode}\" �� FTP-����� \"{$dir}\". " . $error['message'], 211);
		}

		$files = $this->ls($dir);
		if (!empty($files))
		{
			foreach ($files as $val)
			{
				/* ���� */
				if ($val['type'] == "file")
				{
					if (!@ftp_chmod($this->_conn_id, $mode, $dir . "/" . $val['name']))
					{
						$error = error_get_last();
						throw new Exception("�� ������� ���������� ����� \"{$mode}\" �� FTP-���� \"" . $dir . "/" . $val['name'] . "\". " . $error['message'], 212);
					}
				}
				/* ����� */
				elseif ($val['type'] == "dir")
				{
					$this->_chmod_dir($dir . "/" . $val['name'], $mode);
				}
			}
		}

		return true;
	}

	/**
	 * �������� ������ �����
	 * 
	 * @param string $file
	 * @return int 
	 */
	private function _size_file($file)
	{
		$raw_list = ftp_rawlist($this->_conn_id, $file);
		$file_raw = array_pop($raw_list);
		$file_settings = $this->_raw_razbor($file_raw);
		$size = $file_settings['size'];

		return $size;
	}

	/**
	 * �������� ������ ����� � ������
	 * 
	 * @param string $dir
	 * @return int
	 */
	private function _size_dir($dir)
	{
		$size = 0;

		$files = $this->ls($dir);
		if (!empty($files))
		{
			foreach ($files as $val)
			{
				if ($val['type'] == "file")
				{
					$size += $val['size'];
				}
				elseif ($val['type'] == "dir")
				{
					$size += $val['size'];
					$size += $this->_size_dir($dir . "/" . $val['name']);
				}
			}
		}

		return $size;
	}

	/**
	 * �������� �����
	 * 
	 * @param string $dir
	 * @param string $ftp_dir
	 * @return bool
	 * @throws Exception
	 */
	private function _upload_dir($dir, $ftp_dir)
	{
		$ls = scandir($dir);
		if (!empty($ls))
		{
			foreach ($ls as $val)
			{
				/* ����� */
				if ($val == "." or $val == "..")
				{
					continue;
				}

				/* ����� */
				if (is_dir($dir . "/" . $val))
				{
					if (!@ftp_mkdir($this->_conn_id, $ftp_dir . "/" . $val))
					{
						$error = error_get_last();
						throw new Exception("�� ������� ������� FTP-����� \"" . $ftp_dir . "/" . $val . "\". " . $error['message'], 221);
					}

					$this->_upload_dir($dir . "/" . $val, $ftp_dir . "/" . $val);
				}

				/* ���� */
				if (is_file($dir . "/" . $val))
				{
					$fp = fopen($dir . "/" . $val, "rb");
					if (!@ftp_fput($this->_conn_id, $ftp_dir . "/" . $val, $fp, FTP_BINARY))
					{
						$error = error_get_last();
						throw new Exception("�� ������� �������� � FTP-���� \"" . $ftp_dir . "/" . $val . "\". " . $error['message'], 222);
					}
					fclose($fp);
				}
			}
		}

		return true;
	}

	/**
	 * ������� �����
	 * 
	 * @param string $ftp_dir
	 * @param string $dir
	 * @return bool
	 * @throws Exception
	 */
	private function _download_dir($ftp_dir, $dir)
	{
		$ls = array();
		$raw_list = ftp_rawlist($this->_conn_id, $ftp_dir);
		if (!empty($raw_list))
		{
			foreach ($raw_list as $val)
			{
				$file_settings = $this->_raw_razbor($val);
				if (empty($file_settings) or $file_settings['name'] == "." or $file_settings['name'] == "..")
				{
					continue;
				}

				if ($file_settings['type'] == "dir")
				{
					if (!@mkdir($dir . "/" . $file_settings['name']))
					{
						$error = error_get_last();
						throw new Exception("�� ������� ������� ����� \"" . $dir . "/" . $file_settings['name'] . "\". " . $error['message'], 231);
					}

					$this->_download_dir($ftp_dir . "/" . $file_settings['name'], $dir . "/" . $file_settings['name']);
				}
				elseif ($file_settings['type'] == "file")
				{
					$ftp_file = $ftp_dir . "/" . $file_settings['name'];
					$fp = fopen($dir . "/" . $file_settings['name'], "wb");
					if (!@ftp_fget($this->_conn_id, $fp, $ftp_file, FTP_BINARY))
					{
						$error = error_get_last();
						throw new Exception("�� ������� �������� ���������� FTP-����� \"{$ftp_file}\". " . $error['message'], 232);
					}
					fclose($fp);
				}
			}
		}

		return true;
	}

	/**
	 * �������� ���������� ���
	 * 
	 * @param string $name
	 * @param array $paths 
	 * @return string
	 */
	private function _add_unique_name($name, &$paths)
	{
		if (in_array($name, $paths))
		{
			$name = "_" . $name;
			$name = $this->_add_unique_name($name, $paths);
		}

		$paths[] = $name;
		return $name;
	}

	/**
	 * ������� FTP ����� � ��������� � zip-�����
	 * 
	 * @param ZipArchive $zip
	 * @param string $name
	 * @param $ftp_dir
	 * @return bool
	 */
	private function _zip_dir(&$zip, $name, $ftp_dir)
	{
		$zip->addEmptyDir($name);

		$raw_list = ftp_rawlist($this->_conn_id, $ftp_dir);
		if (!empty($raw_list))
		{
			foreach ($raw_list as $val)
			{
				$file_settings = $this->_raw_razbor($val);
				if (empty($file_settings) or $file_settings['name'] == "." or $file_settings['name'] == "..")
				{
					continue;
				}

				if ($file_settings['type'] == "dir")
				{
					$this->_zip_dir($zip, $name . "/" . $file_settings['name'], $ftp_dir . "/" . $file_settings['name']);
				}
				elseif ($file_settings['type'] == "file")
				{
					$this->_zip_file($zip, $name . "/" . $file_settings['name'], $ftp_dir . "/" . $file_settings['name']);
				}
			}
		}

		return true;
	}

	/**
	 * ������� ���� � ��������� � zip �����
	 * 
	 * @param ZipArchive $zip
	 * @param string $name
	 * @param string $ftp_file
	 * @return bool
	 * @throws Exception
	 */
	private function _zip_file(&$zip, $name, $ftp_file)
	{
		$tmpfile = tempnam(sys_get_temp_dir(), "znf");
		$fp = fopen($tmpfile, "wb");
		if (!@ftp_fget($this->_conn_id, $fp, $ftp_file, FTP_BINARY))
		{
			$error = error_get_last();
			throw new Exception("�� ������� �������� ���������� FTP-����� \"{$ftp_file}\". " . $error['message'], 241);
		}
		fclose($fp);

		$zip->addFile($tmpfile, $name);
		$this->_zip_tmp_file[] = $tmpfile;

		return true;
	}

	/**
	 * ��������� ���� �� chroot
	 * 
	 * @param string $path
	 * @return bool
	 * @throws Exception
	 */
	private function _check_chroot($path)
	{
		if ($this->_chroot)
		{
			if (mb_substr($path, 0, mb_strlen($this->_path, "windows-1251"), "windows-1251") != $this->_path)
			{
				throw new Exception("���� \"{$path}\" ����� �� ������� chroot.", 251);
			}

			if (mb_strlen($path, "windows-1251") > mb_strlen($this->_path, "windows-1251"))
			{
				if (mb_substr($path, mb_strlen($this->_path, "windows-1251"), 1, "windows-1251") != "/")
				{
					throw new Exception("���� \"{$path}\" ����� �� ������� chroot.", 252);
				}
			}
		}

		return true;
	}

}

?>
