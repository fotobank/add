<?php

namespace dump_r\Type\String;
use dump_r\Type\StringType;

class JSON extends StringType {
	function get_nodes() {
		return (array)$this->val;
	}
}
