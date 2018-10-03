<?php

namespace dump_r\Type\String;
use dump_r\Type\StringTypeLen;

class JSON extends StringTypeLen {
	function get_nodes() {
		return (array)$this->val;
	}
}
