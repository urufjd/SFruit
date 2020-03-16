<?php


namespace SFruit\tasks;

use pocketmine\scheduler\Task;
use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\ByteArrayTag;

use pocketmine\Player;

use SFruit\entity\FruitMonster;
use SFruit\entity\FruitHuman;

use SJob\JobAPI;

class HumanSpawnTask extends Task{
	
	protected $player = null;
	
	protected $entity = null;
	
	public function __construct (Player $player)
	{
		$this->player = $player;
	}
	
	public function spawn ()
	{
		$player = $this->player;
		if ($player->isOnline ()) {
			$pos = new Position ((int) $player->x, (int) $player->y + 1, (int) $player->z, $player->level);
			
			$nbt = Entity::createBaseNBT ($pos->asVector3 (), null, 0, 0);
			$nbt->setTag (new CompoundTag ("Skin", [
				new StringTag ("Name", $player->getSkin ()->getSkinId ()),
				new ByteArrayTag ("Data", $player->getSkin ()->getSkinData ()),
			]));
			
			$entity = new FruitHuman ($pos->level, $nbt);
			$entity->setOwner ($player);
			$entity->setNameTagAlwaysVisible (true);
			$entity->setHealth ($player->getHealth ());
			$entity->setMaxHealth ($player->getMaxHealth ());
			$entity->setJob (JobAPI::getSubJob ($player->getName ()));
			$entity->setNameTag ("§l§c< {$player->getName ()}§f님의 분신 §c>");
			
			if ($entity instanceof FruitHuman and $entity instanceof FruitMonster) {
				$entity->spawnToAll ();
				
				$this->entity = $entity;
			}
		}
	}
	
	public function onRun (int $currentTick)
	{
		if ($this->entity instanceof FruitHuman) {
			$this->entity->close ();
		}
	}
}