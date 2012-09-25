<?php

namespace Loiste\MinesweeperBundle\Model;

/**
 * This class represents a game model.
 */
class Game {

    /**
     * A two dimensional array of game objects.
     *
     * E.x.: $gameArea[3][2] instance of GameObject
     *
     * @var array
     */
    public $gameArea;
    public $win = FALSE;
    public $numberOfMines;
    public $rows;
    public $columns;
    public $mineLocations = array();

    /**
     * 
     * @param type $numberOfMines
     * @param type $rows
     * @param type $columns
     */
    public function __construct($numberOfMines, $rows, $columns) {
        // Upon constructing a new game instance, setup an empty game area.
        $this->gameArea = array();
        $this->rows = $rows;
        $this->columns = $columns;
        $this->numberOfMines = $numberOfMines;


        /**
         * create mine locations.
         */
        $this->setMineLocations();

        //Put mines in grid...
        $this->createGameObjects();

        //count how many mines around cell..
        $this->countNumberOfMines();
    }

    /**
     * Count how many mines around cell..
     * @todo supports only 20x10 grid needs bit rewriting... 
     * 
     */
    public function countNumberOfMines() {

        for ($row = 0; $row < $this->rows; $row++) {

            $temp = array();
            $prevIsMine = false;
            for ($column = 0; $column < $this->columns; $column++) {

                if ($this->gameArea[$row][$column]->isMine()) {
                    $prevIsMine = TRUE;
                    // cells left and right
                    if (($column >= 0 ) && ($column <= 19)) {

                        if ($column > 0) {

                            $tempRow = $row;
                            $tempColumn = $column - 1;
                            $this->setNumbers($tempRow, $tempColumn);
                        }

                        if ($row > 0 && $row < 10) {

                            //cell above
                            $tempRow = $row - 1;
                            $tempColumn = $column;
                            $this->setNumbers($tempRow, $tempColumn);

                            //cell above left

                            if ($column > 0) {

                                $tempRow = $row - 1;
                                $tempColumn = $column - 1;
                                $this->setNumbers($tempRow, $tempColumn);
                            }

                            //cell above right
                            if ($column < 19) {
                                $tempRow = $row - 1;
                                $tempColumn = $column + 1;
                                $this->setNumbers($tempRow, $tempColumn);
                            }
                        }
                        if ($row >= 0 && $row < 9) {

                            //cell below
                            $tempRow = $row + 1;
                            $tempColumn = $column;
                            $this->setNumbers($tempRow, $tempColumn);

                            //cell below left
                            if ($column > 0) {
                                $tempRow = $row + 1;
                                $tempColumn = $column - 1;
                                $this->setNumbers($tempRow, $tempColumn);
                            }

                            //cell below right
                            if ($column < 19) {

                                $tempRow = $row + 1;
                                $tempColumn = $column + 1;
                                $this->setNumbers($tempRow, $tempColumn);
                            }
                        }
                    }
                } else {

                    if ($prevIsMine) {
                        $numberOfNeighbours = $this->gameArea[$row][$column]->getNumber();
                        $this->gameArea[$row][$column]->setNumber(1 + $numberOfNeighbours);
                        $prevIsMine = FALSE;
                    }
                }
            }
        }
    }

    /**
     * Create random mines
     * 
     * @param int $numberOfMines number of mines..
     * @param type $gridSize Total of cells
     * @return arry
     * 
     * @todo return array of row and column pairs..
     */
    public function setMineLocations() {

        $gridSize = $this->rows * $this->columns;
        $randomNum = 0;
        $temp = array();
        $i = 0;
        while (count($temp) < $this->numberOfMines) {
            $randomNum = floor(mt_rand(0, ($gridSize - 1)));
            if (!(in_array($randomNum, $temp))) {

                $temp[$i] = $randomNum;
                $i++;
            }
        }
        $this->mineLocations = $temp;
    }

    /**
     * Show all mines
     */
    public function showMines() {

        $row = 0;
        foreach ($this->gameArea as $cells) {
            $column = 0;
            foreach ($cells as $item) {
                $currentCellType = $this->gameArea[$row][$column]->type;
                if (($currentCellType == 1)) {
                    $this->gameArea[$row][$column]->type = 5;
                }
                $column++;
            }
            $row++;
        }
    }

    /**
     * create gameobjects  
     */
    private function createGameObjects() {
        $i = 0;

        for ($row = 0; $row < $this->rows; $row++) {

            $temp = array();
            for ($column = 0; $column < $this->columns; $column++) {

                if ((in_array($i, $this->mineLocations))) {
                    $temp[] = new GameObject(1);
                } else {
                    $temp[] = new GameObject(0);
                }
                $i++;
            }

            $this->gameArea[] = $temp;
        }
    }

    /**
     * Check if there is cells to find ..
     * @return boolean true if zero cells to find
     */
    public function checkWin() {

        $numberOfCells = ($this->rows * $this->columns);
        $cellsToFind = $numberOfCells - $this->numberOfMines;

        $row = 0;
        foreach ($this->gameArea as $cells) {
            $column = 0;
            foreach ($cells as $item) {
                $currentCellType = $this->gameArea[$row][$column]->type;
                if (($currentCellType == 2) || ($currentCellType == 3)) {
                    $cellsToFind--;
                }
                $column++;
            }
            $row++;
        }
        if ($cellsToFind == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param int $tempRow
     * @param int $tempColumn
     */
    private function setNumbers($tempRow, $tempColumn) {

        $numberOfNeighbours = $this->gameArea[$tempRow][$tempColumn]->getNumber();
        $this->gameArea[$tempRow][$tempColumn]->setNumber($numberOfNeighbours + 1);
    }

    /**
     * set cell type and check cells around if type Discovered Empty
     * 
     * @param int $tempRow
     * @param int $tempColumn
     */
    private function checkCell($tempRow, $tempColumn) {

        if ($this->gameArea[$tempRow][$tempColumn]->numberOfNeighbours > 0) {
            //this is number -> show it
            $this->gameArea[$tempRow][$tempColumn]->type = 3;
        } else {
            if ($this->gameArea[$tempRow][$tempColumn]->type == 0) {
                //empty celll
                $this->gameArea[$tempRow][$tempColumn]->type = 2;
                $this->checkAroundCell($tempRow, $tempColumn, 10, 20);
            }
        }
    }

    /**
     * Search cells around given x and y if cell 0 > serch neigbours neigbours..
     * recurcive check cells around .
     * @todo check logic Litle problems with xdebug!! xdebug.max_nesting_level=500 7
     * now in my php.ini.
     * 
     * @param int $row Starting row
     * @param int $column Starting column
     * @param int $rows Number of rows 
     * @param int $columns Number of colums
     * 
     */
    public function checkAroundCell($row, $column, $rows, $columns) {



        //check max row
        if ($row < ($rows - 1)) {
            //N
            $tempRow = $row + 1;
            $tempColumn = $column;
            $this->checkCell($tempRow, $tempColumn);

            //NW
            $tempRow = $row + 1;
            $tempColumn = $column + 1;

            if ($column < ($columns - 1)) {
                $this->checkCell($tempRow, $tempColumn);
            }
            //NE 
            $tempRow = $row + 1;
            $tempColumn = $column - 1;

            if ($column > 0) {
                $this->checkCell($tempRow, $tempColumn);
            }
        }

        //W
        $tempRow = $row;
        $tempColumn = $column - 1;

        if ($column > 0) {
            $this->checkCell($tempRow, $tempColumn);
        }

        //E 
        $tempRow = $row;
        $tempColumn = $column + 1;

        if ($column < ($columns - 1)) {
            $this->checkCell($tempRow, $tempColumn);
        }

        //check min row
        if ($row > 0) {

            //S
            $tempRow = $row - 1;
            $tempColumn = $column;

            $this->checkCell($tempRow, $tempColumn);

            //SW
            $tempRow = $row - 1;
            $tempColumn = $column - 1;

            if ($column > 0) {
                $this->checkCell($tempRow, $tempColumn);
            }

            //SE 
            $tempRow = $row - 1;
            $tempColumn = $column + 1;

            if ($column < ($columns - 1)) {
                $this->checkCell($tempRow, $tempColumn);
            }
        }
    }

}