<?php

/**
 *
 * Password Entropy Estimator
 * Version: 1.0.0
 * Date: 2013-10-13
 * Copyright (c) 2012-2013 Peter Kahl. All rights reserved.
 * Use of this source code is governed by a GNU General Public License
 * that can be found in the LICENSE file.
 *
 * https://github.com/peterkahl/password-entropy-estimator
 *
 */



class password_entropy_estimator {

	function entropy($str = '') {

		if (empty($str)) return 0;
		$len = strlen($str);
		$n = 0;

		// only numeric decimal
		if (preg_match('#^[\d]+$#', $str)) {
			$n = 10;
		}
		// only hexadecimal
		elseif ($this->detect_hexadecimal($str)) {
			$n = 16;
		}
		// alpha (lower and upper case) and NO numerals
		elseif ($this->detect_az_both($str) && !$this->detect_numerals($str)) {
			$n = 54;
		}
		// alpha (lower and upper case) and numeric
		elseif ($this->detect_az_both($str) && $this->detect_numerals($str)) {
			$n = 63;
		}
		// alpha (lower OR upper case) and numeric
		elseif ($this->detect_az_upper($str) && $this->detect_numerals($str)) {
			$n = 36;
		}
		// alpha (lower OR upper case) and numeric
		elseif ($this->detect_az_lower($str) && $this->detect_numerals($str)) {
			$n = 36;
		}
		// alpha (lower case) and NO numerals
		elseif ($this->detect_az_lower($str) && !$this->detect_numerals($str)) {
			$n = 26;
		}
		// alpha (lower case) and numeric
		elseif ($this->detect_az_lower($str) && $this->detect_numerals($str)) {
			$n = 36;
		}
		// only alpha upper case
		elseif ($this->detect_az_upper($str) && !$this->detect_numerals($str)) {
			$n = 27;
		}

		// special characters
		if ($this->detect_special($str)) $n += 36;

		$h = ($len*log($n, 2)) - 1;

		if ($h >= 10) return floor($h);
		else return round($h, 2);
	}

	private function detect_special($str) {
		$special = '`~!@#$€£₤§%^&*()-_=+[{]};:\'"\|,<.>/?'; // 36 chars
		$arr = str_split($special);
		foreach ($arr as $char) {
			if (strpos($str, $char) !== false) return true;
		}
		return false;
	}

	private function detect_numerals($str) {
		return preg_match('#[0-9]#', $str);
	}

	private function detect_hexadecimal($str) {
		return preg_match('#^[a-f0-9]+$#', strtolower($str));
	}

	private function detect_az_lower($str) {
		return (preg_match('#[a-z]#', $str) && !preg_match('#[A-Z]#', $str));
	}

	private function detect_az_upper($str) {
		return (preg_match('#[A-Z]#', $str) && !preg_match('#[a-z]#', $str));
	}

	private function detect_az_both($str) {
		return (preg_match('#[a-z]#', $str) && preg_match('#[A-Z]#', $str));
	}

}

//----------------------------------------------------------------------

