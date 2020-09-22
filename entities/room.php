<?php
class Room {

  var $game;
  var $status;
  var $players;

  function __construct($game) {
    $this->status = "waiting";
    $this->game = $game;
    $this->players = array();
	}

}
