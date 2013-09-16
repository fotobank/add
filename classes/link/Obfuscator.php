<?php

 /**
 * linkObfuscator manages a simple way of validating links: starting from a session, an user can browse exclusively those links that are performed by this page.
 * to do this, a random seed is generated and a special code (named go) is attached to each link.
 * each page that has to be obfuscated needs this class and a $linkObfuscator::check() to validate the user.
 **/

class link_Obfuscator
{
	var $seed=0;
	var $referralSeed=0;


	function link_Obfuscator($referralSeed=false)
				{
					// new seed, to obfuscate new pages
								srand();
								$this->seed= rand();
							 $session = check_Session::getInstance();
					// old seed, to check access
					if($referralSeed===false or !is_numeric($referralSeed)) {
						  $this->referralSeed=$referralSeed;
					} else if(is_numeric($session->get('referralSeed'))) {
						  $this->referralSeed=$session->get('referralSeed');
								$session->set('referralSeed', $this->seed);
					}
				}

	function _obfuscate($aLink,$aSeed)
	{
		$sep=(strpos('?',$aLink)===false)?'?':'&';
	//  $test = (md5($aSeed .$aLink));
		return $aLink. $sep ."go=".md5($aSeed .$aLink);
	}
	
	function obfuscate($aLink)
	{
		return $this->_obfuscate($aLink,$this->seed);
	}
	
	function check($anObfuscatedLink)
	{
		$theLink=preg_replace('/(&|\?)go=(\w)+/','',$anObfuscatedLink);
//    $thisRef = $this->referralSeed;
//				dump_r($this->_obfuscate($theLink,$this->referralSeed));
		if($this->_obfuscate($theLink,$this->referralSeed)==$anObfuscatedLink)
			return true;
			
		return false;
	}
}
?>