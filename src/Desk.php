<?php

class Desk {
    private $figures = [];
    private $process = null;

    public function __construct() {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);
        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);

        $this->figures['a'][8] = new Rook(true);
        $this->figures['b'][8] = new Knight(true);
        $this->figures['c'][8] = new Bishop(true);
        $this->figures['d'][8] = new Queen(true);
        $this->figures['e'][8] = new King(true);
        $this->figures['f'][8] = new Bishop(true);
        $this->figures['g'][8] = new Knight(true);
        $this->figures['h'][8] = new Rook(true);
    }

    public function move($move) {
        if (!preg_match('/^([a-h])(\d)-([a-h])(\d)$/', $move, $match)) {
            throw new \Exception("Incorrect move");
        }

        $xFrom = $match[1];
        $yFrom = $match[2];
        $xTo   = $match[3];
        $yTo   = $match[4];

        // Если цвет фигуры на предыдущем ходе совпадает с текущим
        if ($this->process !== null && $this->process == $this->figures[$xFrom][$yFrom]->isBlack) {
            throw new \Exception("Incorrect move");
        }
        print_r([$this->figures, $this->figures[$xFrom][$yFrom+1], $this->figures[$xFrom][$yFrom-1], $xFrom.$yFrom+1 .'-'.$xFrom.$yFrom-1]);
        if (
            get_class($this->figures[$xFrom][$yFrom]) === 'Pawn' // Если пешка
            && !(($yFrom == 2 && in_array($yTo, [3, 4])) || ($yFrom == 7 && in_array($yTo, [6, 5]))) // Если в начале
            && !($xFrom == $xTo && ($yFrom+1 == $yTo || $yFrom-1 == $yTo)) // Ходим по вертикали на одну клетку
            && ($xFrom == $xTo && (isset($this->figures[$xTo][$yFrom+1]) || isset($this->figures[$xTo][$yTo-1])))
            ) {
            echo "<pre>";print_r([$xFrom.$yFrom .'-'.$xTo.$yTo ]);echo "</pre>";
            throw new \Exception("Incorrect move");
        }

        $this->process = $this->figures[$xFrom][$yFrom]->isBlack;
        if (isset($this->figures[$xFrom][$yFrom])) {
            $this->figures[$xTo][$yTo] = $this->figures[$xFrom][$yFrom];
        }
        unset($this->figures[$xFrom][$yFrom]);
    }

    public function dump() {
        for ($y = 8; $y >= 1; $y--) {
            echo "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    echo $this->figures[$x][$y];
                } else {
                    echo '-';
                }
            }
            echo "\n";
        }
        echo "  abcdefgh\n";
    }
}
