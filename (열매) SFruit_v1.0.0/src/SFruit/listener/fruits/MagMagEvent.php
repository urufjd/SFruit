<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;
use pocketmine\Player;

use SFruit\Skill;

class MagMagEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 7;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($player->level->getFolderName () === "world") {
						return;
					}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
					if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "마그마그") {
      if ($entity !== $player) {
					   	$player->setOnFire (4);
      }
					}
				}
			}
		}
	}
	
	public function handleSkill1 (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		if ($item->getId () === 369) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "마그마그") {
				if (CooldownTask::isCooldown ($name, "대분화")) {
					$this->plugin->msg ($player, "[ §c대분화 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "대분화") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "대분화", 20);
					$this->plugin->msg ($player, "[ §c대분화 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->magmag1 ($player);
				}
			}
		}
	}
	
	public function handleSkill2 (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		if ($item->getId () === 377) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "마그마그") {
				if (CooldownTask::isCooldown ($name, "유성화산")) {
					$this->plugin->msg ($player, "[ §c유성화산 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "유성화산") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "유성화산", 25);
					$this->plugin->msg ($player, "[ §c유성화산 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->magmag2 ($player);
				}
			}
		}
	}
	
	public function handleEndAbility (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($player->getInventory ()->getItemInHand ()->getId () !== 437) {
						return;
					}
					if ($player->level->getFolderName () === "world") {
						return;
					}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
					if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "마그마그") {
						if (CooldownTask::isCooldown ($name, "명구")) {
							$this->plugin->msg ($player, "[ §c명구 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "명구") . "초§7 남았습니다.");
							return;
						} else {
							CooldownTask::addCooldown ($name, "명구", 60);
							$this->plugin->msg ($player, "[ §c명구 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c마그마그 궁극기§7를 사용하셨습니다.");
							if ($entity->getHealth () >= 21) {
								$entity->setHealth ($entity->getHealth () - 20);
							} else {
								$entity->setHealth ($entity->getHealth () - 15);
							}
							$entity->setOnFire (6);
						}
					}
				}
			}
		}
	}
}