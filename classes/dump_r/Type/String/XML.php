<?php

namespace dump_r\Type\String;
use dump_r\Type\StringType;

class XML extends StringType {
	function get_nodes() {
		return (array)$this->val;
	}

	// dont show length, or find way to detect uniform subnodes and treat as XML [] vs XML {}
	function get_len() {
		return null;
	}
}
