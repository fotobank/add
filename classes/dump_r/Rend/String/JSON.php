<?php

namespace dump_r\Rend\String;
use dump_r\Rend, dump_r\Rend\StringTypeLen;

class JSON extends StringTypeLen {
	public function get_val($node) {
		if (Rend::$json_pretty)
			return json_encode($node->val, JSON_PRETTY_PRINT);
		else
			return parent::get_val($node);
	}
}
