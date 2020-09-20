<?php
class Game {

	var $over;
	var $won;

	function start() {
		$this->over = false;
		$this->won = false;
	}

	function end() {
		$this->over = true;
	}

	function isOver() {
		if ($this->won)
			return true;

		if ($this->over)
			return true;

		if ($this->health < 0)
			return true;

		return false;
	}
}

function errorAlert($msg) {
	return "<div class=\"alert alert-danger\" role=\"alert\">$msg</div>";
}

function successAlert($msg) {
	return "<div class=\"alert alert-success\" role=\"alert\">$msg</div>";
}
