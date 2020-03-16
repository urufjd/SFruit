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

class IceIceEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 8;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] === "얼음얼음") {

						if (CooldownTask::isCooldown ($entity->getName (), "빙결")) {
							CooldownTask::deleteCooldown ($entity->getName (), "빙결");
							$event->setBaseDamage (10);
						}
					}
				}
			}
		}
	}
	
	public function handleSkill1 (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					$item = $player->getInventory ()->getItemInHand ();
					if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "얼음얼음") {
						if ($player->getLevel ()->getFolderName () === "world") {
							return;
						}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
						if ($item->getId () !== 369) {
							return;
						}
						if (CooldownTask::isCooldown ($name, "아이스 타임")) {
							$this->plugin->msg ($player, "[ §c아이스 타임 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "아이스 타임") . "초§7 남았습니다.");
							return;
						} else {
							CooldownTask::addCooldown ($name, "아이스 타임", 3);
							$this->plugin->msg ($player, "[ §c아이스 타임 §7] 스킬을 사용하셨습니다!");
							CooldownTask::addCooldown ($entity->getName (), "빙결", 3);
						}
					}
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "얼음얼음") {
				if (CooldownTask::isCooldown ($name, "아이스 타임:캡슐")) {
					$this->plugin->msg ($player, "[ §c아이스 타임:캡슐 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "아이스 타임:캡슐") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "아이스 타임:캡슐", 15);
					$this->plugin->msg ($player, "[ §c아이스 타임:캡슐 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->iceice2 ($player);
				}
			}
		}
	}
	
	public function handleSkill3 (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		if ($item->getId () === 378) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "얼음얼음") {
				if (CooldownTask::isCooldown ($name, "아이스 블록 페전트 빅")) {
					$this->plugin->msg ($player, "[ §c아이스 블록 페전트 빅 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "아이스 블록 페전트 빅") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "아이스 블록 페전트 빅", 30);
					$this->plugin->msg ($player, "[ §c아이스 블록 페전트 빅 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->iceice3 ($player);
				}
			}
		}
	}
	
	public function handleEndAbility (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		if ($item->getId () === 437) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "얼음얼음") {
				if (CooldownTask::isCooldown ($name, "아이스 에이지")) {
					$this->plugin->msg ($player, "[ §c아이스 에이지 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "아이스 에이지") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "아이스 에이지", 200);
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c얼음얼음 궁극기§7를 사용하셨습니다.");
					$this->plugin->msg ($player, "[ §c아이스 에이지 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->iceice4 ($player);
				}
			}
		}
	}
}