<?php
class Gomoku extends game {

	const GRID_SIZE = 19;
	var $board = array(); //Tableau de cellules à implémenter
	var $totalMoves = 0;
	var $player1;
	var $player2;
	var $playing;

	function __construct() {
		game::start();
		$this->player1 = new Player("joueur 1","noir");
		$this->player2 = new Player("joueur 2", "blanc");
		$this->player1->status = "playing";
		$this->playing = $this->player1;
    $this->newBoard();
	}

	function newGame() {
		$this->start();
		$this->totalMoves = 0;
    $this->newBoard();
		$this->switchPlayer();
		$this->player1->count = 0;
		$this->player2->count = 0;
	}

  function newBoard() {
		$this->board = array();
    //Initialise la grille
    for ($x = 0; $x < self::GRID_SIZE; $x++) {
      for ($y = 0; $y < self::GRID_SIZE; $y++) {
          $this->board[$x][$y] = null;
      }
    }
  }

	function playGame($data) {
		if (!$this->isOver() && isset($data['move'])) {
			$this->move($data);
    }
		//Bouton start
		if (isset($data['newgame'])) {
			$this->newGame();
    }
		$this->displayGame();
	}

	function displayGame() {
		//tant que le jeu est en cours
		if (!$this->isOver()) {
			echo "<div id=\"grid\" class=\"col-10\">";
			for ($x = 0; $x < self::GRID_SIZE; $x++) {
				for ($y = 0; $y < self::GRID_SIZE; $y++) {
					echo "<div class=\"cell\">";
					//Si la cellule n'est pas nulle
					if ($this->board[$x][$y]) {
						echo "<img src=\"images/{$this->board[$x][$y]}.jpg\" alt=\"{$this->board[$x][$y]}\" title=\"{$this->board[$x][$y]}\" />";
					} else {
						echo "<select class=\"custom-select\" {$this->isEnabled($x, $y)} name=\"{$x}_{$y}\">
								<option value=\"\"></option>
								<option value=\"{$this->playing->color}\">{$this->playing->color}</option>
							</select>";
					}
					echo "</div>";
				}
				echo "<div class=\"break\"></div>";
			}
			echo "</div>";
			echo "<div class=\"col-2\">";
			echo "<input class=\"btn btn-primary\" type=\"submit\" name=\"move\" value=\"Valider\" /><br/>
				<p>Au tour de : {$this->playing->name}({$this->playing->color})</p>";
			echo "</div>";
		} else {
			echo "<div class=\"endgame\">";
			if (`²` != "draw") {
				echo successAlert("Joueur " . $this->playing->name."(".$this->playing->color."), a gagné !");
			} else if ($this->isOver() == "draw") {
				echo errorAlert("Egalité. Réessayer ?");
			}
			echo "<input class=\"btn btn-primary\" type=\"submit\" name=\"newgame\" value=\"Nouvelle partie\" />";
			echo "</div>";
		}
	}

	function move($data) {
		if ($this->isOver()) {
			return;
		}
		$data = array_unique($data);
		foreach ($data as $key => $value) {
			if ($value == $this->playing->color) {
				//Maj grille
				$coords = explode("_", $key);
				$this->board[$coords[0]][$coords[1]] = $this->playing->color;
				$this->playing->count += 1;
				//Tour suivant
				if ($this->playing == $this->player1) {
					$this->player1->status = "waiting";
					$this->player2->status = "playing";
				}
				else {
					$this->player1->status = "playing";
					$this->player2->status = "waiting";
				}
				$this->totalMoves++;
			}
		}
		if ($this->isOver()){
			return;
		}
		$this->switchPlayer();
	}

	function switchPlayer() {
		if ($this->player1->status == "playing") {
			$this->playing = $this->player1;
		} else if ($this->player2->status == "playing") {
			$this->playing = $this->player2;
		}
	}

	function isOver() {
		//Lignes
		foreach ($this->board as $key) {
			for($i = 0; $i < self::GRID_SIZE - 4; $i++) {
				if ($key[$i] == $key[$i+1] && $key[$i+1] == $key[$i+2] && $key[$i+2] == $key[$i+3] && $key[$i+3] == $key[$i+4]
				 && isset($key[$i]) && isset($key[$i+1]) && isset($key[$i+2]) && isset($key[$i+3]) && isset($key[$i+4])) {
					return $key[$i];
				}
			}
		}
		//Colonnes
		for($i = 0; $i < self::GRID_SIZE - 4; $i++) {
			$values = array_column($this->board,$i);
			for($j = 0; $j < self::GRID_SIZE - 4; $j++) {
				if ($values[$j] == $values[$j+1] && $values[$j+1] == $values[$j+2] && $values[$j+2] == $values[$j+3] && $values[$j+3] == $values[$j+4]
				 && isset($values[$j]) && isset($values[$j+1]) && isset($values[$j+2]) && isset($values[$j+3]) && isset($values[$j+4])) {
					return $values[$j];
				}
			}
		}
		//Diagonale left-right
		for($i = 0; $i < self::GRID_SIZE - 4; $i++) {
			for($j = 0; $j < self::GRID_SIZE - 4; $j++) {
						$cell1 = $this->board[$i][$j];
						$cell2 =  $this->board[$i+1][$j+1];
						$cell3 =  $this->board[$i+2][$j+2];
						$cell4 =  $this->board[$i+3][$j+3];
						$cell5 =  $this->board[$i+4][$j+4];
						if ($cell1 == $cell2 && $cell2 == $cell3 && $cell3 == $cell4 && $cell4 == $cell5 &&
						isset($cell1) && isset($cell2) && isset($cell3) && isset($cell4) && isset($cell5)) {
							return $cell1;
						}
			}
		}
		//Diagonale right-left
		for($i = 0; $i < self::GRID_SIZE - 4; $i++) {
			for($j = 4; $j < self::GRID_SIZE; $j++) {
				$cell1 = $this->board[$i][$j];
				$cell2 =  $this->board[$i+1][$j-1];
				$cell3 =  $this->board[$i+2][$j-2];
				$cell4 =  $this->board[$i+3][$j-3];
				$cell5 =  $this->board[$i+4][$j-4];
				if ($cell1 == $cell2 && $cell2 == $cell3 && $cell3 == $cell4 && $cell4 == $cell5 &&
				isset($cell1) && isset($cell2) && isset($cell3) && isset($cell4) && isset($cell5)) {
					return $cell1;
				}
			}
		}
		if ($this->totalMoves >= 120) {
			return "draw";
		}
	}

	function isEnabled($x, $y) {
		//Case centrale
		if ($x == intdiv(self::GRID_SIZE,2) && $y == intdiv(self::GRID_SIZE,2)) {
			return "enabled";
		}
		//Angles
		if ($x == 0 && $y == 0) { //Angle sup gauche
			if ($this->board[$x][$y+1] || $this->board[$x+1][$y+1] || $this->board[$x+1][$y]) {
				return "enabled";
			}
		}
		if ($x == 0 && $y == self::GRID_SIZE-1) { //Angle sup droit
			if ($this->board[$x+1][$y] || $this->board[$x][$y-1] || $this->board[$x+1][$y-1]) {
				return "enabled";
			}
		}
		if ($x == self::GRID_SIZE-1 && $y == 0) { //Angle inf gauche
			if ($this->board[$x][$y+1] || $this->board[$x-1][$y+1] || $this->board[$x-1][$y]) {
				return "enabled";
			}
		}
		if ($x == self::GRID_SIZE-1 && $y == self::GRID_SIZE-1) { //Angle inf droit
			if ($this->board[$x][$y-1] || $this->board[$x-1][$y-1] || $this->board[$x-1][$y]) {
				return "enabled";
			}
		}
		if ($x == 0 && $y != 0 && $y != self::GRID_SIZE-1) { //Bord sup
			if ($this->board[$x][$y+1] || $this->board[$x+1][$y+1] || $this->board[$x+1][$y] || $this->board[$x+1][$y-1] || $this->board[$x][$y-1]) {
				return "enabled";
			}
		}
		if ($x == self::GRID_SIZE-1 && $y != self::GRID_SIZE-1 && $y != 0) { //Bord inf
			if ($this->board[$x][$y+1] || $this->board[$x][$y-1] || $this->board[$x-1][$y-1] || $this->board[$x-1][$y] || $this->board[$x-1][$y+1]) {
				return "enabled";
			}
		}
		if ($y == 0 && $x != 0 && $x != self::GRID_SIZE-1) { //Bord gauche
			if ($this->board[$x][$y+1] || $this->board[$x+1][$y+1] || $this->board[$x+1][$y] || $this->board[$x-1][$y] || $this->board[$x-1][$y+1]) {
				return "enabled";
			}
		}
		if ($y == self::GRID_SIZE-1 && $x != 0 && $x != self::GRID_SIZE-1) { //Bord droit
			if ($this->board[$x+1][$y] || $this->board[$x+1][$y-1] || $this->board[$x][$y-1] || $this->board[$x-1][$y-1] || $this->board[$x-1][$y]) {
				return "enabled";
			}
		}
		if ($x != 0 && $x != self::GRID_SIZE-1 && $y != 0 && $y != self::GRID_SIZE-1) {
			//Si case sans bordure
			if ($this->board[$x][$y+1] || $this->board[$x+1][$y+1] || $this->board[$x+1][$y] || $this->board[$x+1][$y-1] || $this->board[$x][$y-1] ||
			$this->board[$x-1][$y-1] || $this->board[$x-1][$y] || $this->board[$x-1][$y+1]) {
				return "enabled";
			}
		}
		return "disabled";
	}

}
