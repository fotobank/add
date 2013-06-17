<?php

namespace dump_r\Type;
use dump_r\Type;

class Object extends Type {
	const VIS_PUBL = 2;
	const VIS_PROT = 1;
	const VIS_PRIV = 0;

	public function chk_ref() {
		$this->id = spl_object_hash($this->raw);

		if (array_key_exists($this->id, Type::$dic))
			return true;
		else
			Type::$dic[$this->id] = $this->id;

		return false;
	}

	public function get_sub() {
		$sub = parent::get_sub();

		$class = get_class($this->raw);

		if ($class)
			$sub[] = $class;

		return $sub;
	}

	public function get_nodes() {
		// hack access to protected and private props
		$nodes = (array)$this->raw;

		$this->vis = $this->get_vis($nodes);

		return array_combine(array_keys($this->vis), $nodes);
	}

	// removes protected and private indics from array-casted objects
	// returns array of clean_key => vislevel
	public function get_vis($nodes) {
		$keys = array();

		foreach ($nodes as $k => $v) {
			$vis = self::VIS_PUBL;
			if (preg_match('/\x0(\w+|\*)\x0/', $k, $m)) {
				// clean up NUL, *, className
				$k = str_replace("\x00{$m[1]}\x00", '', $k);

				$vis = $m[1] === '*' ? self::VIS_PROT : self::VIS_PRIV;
			}

			$keys[$k] = $vis;
		}

		return $keys;
	}
}