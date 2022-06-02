<?php
class Vote extends Utils
{
    private string $villageois_EMAIL;
    private int $proposition_ID;
    protected int $points_atribues;
    protected DateTime $vote_date;

    public function __construct(string $villageois_EMAIL = "", int $proposition_ID = 0, int $points_atribues = 0, string $vote_date = "")
    {
        $this->villageois_EMAIL = $villageois_EMAIL;
        $this->proposition_ID = $proposition_ID;
        $this->points_atribues = $points_atribues;
        $this->vote_date = empty($vote_date) ? new DateTime() : new DateTime($vote_date);
    }

    public function villageois(): Villageois
    {
        return Villageois::getByEmail($this->villageois_EMAIL);
    }
    public function proposition(): Proposition
    {
        return Proposition::getById($this->proposition_ID);
    }
}
