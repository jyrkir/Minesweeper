<?php

namespace Loiste\MinesweeperBundle\Model;

/**
 * This class represents a game object.
 */
class GameObject {

    const TYPE_UNDISCOVERED = 0;
    const TYPE_MINE = 1;
    const TYPE_EMPTY = 2; // Discovered.
    const TYPE_NUMBER = 3; // Discovered.
    const TYPE_EXPLOSION = 4; // Damn we hit a mine!
    const TYPE_MINE_DISCOVERED = 5;

    public $type;
    //numberOfNeighbours of neighboring mines for cell
    public $numberOfNeighbours = 0;

    public function __construct($type = 0) {
        $this->type = $type;
    }

    public function isMine() {
        return $this->type === GameObject::TYPE_MINE;
    }

    public function isNumber() {
        return $this->type === GameObject::TYPE_NUMBER;
    }

    public function isEmpty() {
        return $this->type === GameObject::TYPE_EMPTY;
    }

    /**
     * set the number of mines around cell
     * 
     * @return int
     */
    public function getNumber() {
        //return floor(mt_rand(0, 7)) + 1;
        return $this->numberOfNeighbours;
    }

    /**
     * set the number of mines around this cell
     * 
     * @param int $numberOfNeighbours
     */
    public function setNumber($numberOfNeighbours) {
        $this->numberOfNeighbours = $numberOfNeighbours;
    }

}