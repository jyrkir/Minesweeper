<?php

namespace Loiste\MinesweeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Loiste\MinesweeperBundle\Model\Game;

class GameController extends Controller {

    /**
     * 
     * @return array gamearea, boolean win
     * @todo game supports only 10x20 grid .. game class needs work
     *  
     */
    public function startAction() {
        // Setup an empty game. To keep things very simple for candidates, we just store info on the session.


        $game = new Game(20, 10, 20); // (mines, rows, columns) 
        $session = new Session();
        $session->start();
        $session->set('game', $game);

        return $this->render('LoisteMinesweeperBundle:Default:index.html.twig', array(
                    'gameArea' => $game->gameArea,
                    'boolWin' => $game->win
                ));
    }

    /**
     * 
     * @return array gamearea, boolean win
     * @todo Description
     */
    public function makeMoveAction() {

        $row = $this->getRequest()->get('row'); // Retrieves the row index.
        $column = $this->getRequest()->get('column'); // Retrieves the column index.

        $session = new Session();
        $session->start();
        $game = $session->get('game');

        /** @var $game Game */
        if ($game->gameArea[$row][$column]->isMine()) {
            $game->gameArea[$row][$column]->type = 4;
            
            // game over ---->
            $game->showMines();

            
        } else {
            if ($game->gameArea[$row][$column]->numberOfNeighbours > 0) {
                $game->gameArea[$row][$column]->type = 3;
            } else {
                $game->gameArea[$row][$column]->type = 2;
                $game->checkAroundCell($row, $column, 10, 20);
            }
        }
        
        $game->win = $game->checkWin();


        return $this->render('LoisteMinesweeperBundle:Default:index.html.twig', array(
                    'gameArea' => $game->gameArea,
                    'boolWin' => $game->win
                ));
    }

}
