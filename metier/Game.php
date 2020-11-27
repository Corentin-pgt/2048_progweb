<?php


class Game
{
    private $pseudo;
    private $gagne;
    private $score;

    /**
     * Game constructor.
     * @param $pseudo
     * @param $gagne
     * @param $score
     */
    public function __construct($pseudo)
    {
        $this->pseudo = $pseudo;
        $this->gagne = 0;
        $this->score = 0;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

}