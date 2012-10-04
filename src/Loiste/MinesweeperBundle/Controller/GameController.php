<?php

namespace Loiste\MinesweeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Loiste\MinesweeperBundle\Model\Game;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller {

    /**
     * 
     * @return array gamearea, int status
     * @todo game supports only 10x20 grid .. game class needs work
     *  
     */
    public function startAction(Request $request) {
        // Setup an empty game. To keep things very simple for candidates, we just store info on the session.
        $game = new Game(5, 8, 8); // (mines, rows, columns)
        if ($request->getMethod() == 'POST') {


            /*
              $game->setColumns($request->request->get('columns'));
              $game->setRows($request->request->get('rows'));
             * 
             */


            $postDataForm = $request->request->get('form');


            $game->setColumns($postDataForm['columns']);
            $game->setRows($postDataForm['rows']);
            $game->setNumberOfMines($postDataForm['numberOfMines']);

            /**
             * create mine locations.
             */
            $game->setMineLocations();

            //Put mines in grid...
            $game->createGameObjects();

            //count how many mines around cell..
            $game->countNumberOfMines();
            
            if (!isset($session)) {
            $session = new Session();
            $session->start();
            }
            $session->set('game', $game);

            $game->status = 1;
            return $this->render('LoisteMinesweeperBundle:Default:index.html.twig', array(
                        'gameArea' => $game->gameArea,
                        'status' => $game->status,
                        'rows' => $game->rows,
                        'columns' => $game->columns
                    ));
        } else {

            if (!isset($session)) {
            $session = new Session();
            $session->start();
            }
            /**
             * create mine locations.
             */
            $game->setMineLocations();

            //Put mines in grid...
            $game->createGameObjects();

            //count how many mines around cell..
            $game->countNumberOfMines();
            $session->set('game', $game);

            $form = $this->createFormBuilder($game)
                    
                    ->add('numberOfMines', 'choice', array(
                        'choices' => array('5' => '5%','10' => '10%', '20' => '20%'),
                        'data' => 5,
                        'label' => 'Mines :'
                    ))
                    ->add('rows', 'choice', array(
                        'choices' => array('8' => '8', '12' => '12', '30' => '30'),
                        'label' => 'Rows :'
                        
                    ))
                    ->add('columns', 'choice', array(
                        'choices' => array('8' => '8', '16' => '16', '30' => '30'),
                        'label' => 'Columns :'
                        
                    ))
                    ->getForm();

            return $this->render('LoisteMinesweeperBundle:Default:index.html.twig', array(
                        'gameArea' => $game->gameArea,
                        'status' => $game->status,
                        'rows' => $game->rows,
                        'columns' => $game->columns,
                        'form' => $form->createView()
                    ));
        }
    }

    /**
     * 
     * @return array gamearea, int status
     * @todo Description
     */
    public function makeMoveAction() {

        $row = $this->getRequest()->get('row'); // Retrieves the row index.
        $column = $this->getRequest()->get('column'); // Retrieves the column index.
        
        if (!isset($session)) {
        $session = new Session();
        $session->start();
        $game = $session->get('game');
        }

        /** @var $game Game */
        if ($game->gameArea[$row][$column]->isMine()) {
            $game->gameArea[$row][$column]->type = 4;

            // game over ---->
            $game->showMines();
            $game->status = 3; //game lost
        } else {

            if ($game->gameArea[$row][$column]->numberOfNeighbours > 0) {
                $game->gameArea[$row][$column]->type = 3;
            } else {

                $game->gameArea[$row][$column]->type = 2;
                //start checking cells around..
                $game->checkAroundCell($row, $column);
            }
            $game->status = $game->checkWin();
        }




        return $this->render('LoisteMinesweeperBundle:Default:index.html.twig', array(
                    'gameArea' => $game->gameArea,
                    'status' => $game->status,
                    'rows' => $game->rows,
                    'columns' => $game->columns
                ));
    }

}
