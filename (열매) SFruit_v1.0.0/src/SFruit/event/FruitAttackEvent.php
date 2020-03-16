<?php


namespace SFruit\event;


use pocketmine\event\Event;
use pocketmine\event\Cancellable;

use pocketmine\Player;



class FruitAttackEvent extends Event implements Cancellable
{
    public static $handlerList = null;

    protected $player;

    protected $myFruit;
    
    protected $targetFruit;


    public function __construct (Player $player, string $myFruit, string $targetFruit)
    {
        $this->player = $player;
        $this->myFruit = $myFruit;
        $this->targetFruit = $targetFruit;
    }

    public function getPlayer (): Player
    {
        return $this->player;
    }

    public function getMyFruit (): string
    {
        return $this->myFruit;
    }
    
    public function getTargetFruit (): string
    {
        return $this->targetFruit;
    }
}