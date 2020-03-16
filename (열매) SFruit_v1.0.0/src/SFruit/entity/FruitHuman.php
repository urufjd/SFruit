<?php

namespace SFruit\entity;

use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class FruitHuman extends FruitMonster
{
	
	public $owner = null;
	
	public $job = null;
	
	
	public function __construct (Level $level, CompoundTag $nbt)
	{
		parent::__construct ($level, $nbt);
	}
	
	public function setOwner (Player $player)
	{
		$this->owner = $player;
	}
	
	public function getOwner (): Player
	{
		return $this->owner;
	}
	
	public function setJob (string $job)
	{
		$this->job = $job;
	}
	
	public function getJob (): string
	{
		return $this->job ?? "해적";
	}
}