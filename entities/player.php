<?php
class Player {

  var $status;
  var $count; //Max 60
  var $color;
  var $name;

  function __construct($name, $color) {
    $this->status = "waiting";
    $this->count = 0;
    $this->name = $name;
    $this->color = $color;
	}

}
