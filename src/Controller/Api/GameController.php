<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Game;


class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
        $games = $this->getDoctrine()
        ->getRepository(Game::class)
        ->findAll();

        $response = [];

        foreach ($games as $game) {
            $response [] = [
                'id' => $game->getId(),
                'name' => $game->getName(),
            ];
        }

        return $this->json($response);
    }

    /**
     * @Route(
     *      "/game/{id}",
     *      name="game_detail",
     *      requirements={"id"="\d+"}
     * )
     */
    public function game($id)
    {
        $game = $this->getDoctrine()
        ->getRepository(Game::class)
        ->find($id);

        if(!$game){
            throw $this->createNotFoundException('L\'editeur n\'existe pas');
        }

        $editor = $game->getEditor();

        $response = [
            'id' => $game->getId(),
            'name' => $game->getName(),
            'date' => $game->getDate()->format('Y-m-d'),
            'editor' => [
                'id' => $editor->getId(),
                'name' => $editor->getName(),
            ]
        ];

        return $this->json($response);
    }
}
