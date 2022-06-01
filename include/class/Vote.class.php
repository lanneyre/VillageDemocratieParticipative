<?php
class Vote extends Utils
{
    protected Villageois $villageois;
    protected Proposition $proposition;
    protected int $points_atribues;
    protected DateTime $vote_date;

    public function __construct(Villageois $villageois = null, Proposition $proposition = null, int $points_atribues = 0, string $vote_date = "")
    {
        $this->villageois = $villageois;
        $this->proposition = $proposition;
        $this->points_atribues = $points_atribues;
        $this->vote_date = empty($vote_date) ? new DateTime() : new DateTime($vote_date);
    }
}
