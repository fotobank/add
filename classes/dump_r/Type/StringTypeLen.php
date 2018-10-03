<?php

namespace dump_r\Type;
use dump_r\Type;

class StringTypeLen extends Type {
	function get_len() {
		return strlen($this->raw);
	}
}
