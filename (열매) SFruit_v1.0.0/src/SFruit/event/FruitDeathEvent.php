<?php


namespace SFruit\event;


use pocketmine\event\Event;
use pocketmine\event\Cancellable;

use pocketmine\Player;



class FruitDeathEvent extends Event implements Cancellable
{
    public static $handlerList = null;

    protected $player;

    protected $fruit;


    public function __construct (Player $player, string $fruit)
    {
        $this->player = $player;
        $this->fruit = $fruit;
    }

    public function getPlayer (): Player
    {
        return $this->player;
    }

    public function getFruit (): string
    {
        return $this->fruit;
    }
}