<?php

namespace dump_r\Rend\String;
use dump_r\Rend, dump_r\Rend\StringTypeLen;

class SQL extends StringTypeLen {
	public function get_val($node) {
		if (Rend::$sql_pretty)
			return \SqlFormatter::format($node->raw, false);
		else
			return parent::get_val($node);
	}
}
