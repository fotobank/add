<?php

namespace dump_r\Type\String;
use dump_r\Type\StringTypeLen;

class XML extends StringTypeLen {
	function get_nodes() {
		return (array)$this->val;
	}

	// dont show length, or find way to detect uniform subnodes and treat as XML [] vs XML {}
	function get_len() {
		return null;
	}
}
