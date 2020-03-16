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

class DarkDarkEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 6;
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
					if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "어둠어둠") {
						$callEv = new EntityDamageByEntityEvent ($entity, $player, EntityDamageEvent::CAUSE_MAGIC, ($event->getBaseDamage () + 2));
						$entity->attack ($callEv);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "어둠어둠") {
				if (CooldownTask::isCooldown ($name, "어둠의 소용돌이")) {
					$this->plugin->msg ($player, "[ §c어둠의 소용돌이 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "어둠의 소용돌이") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "어둠의 소용돌이", 15);
					$this->plugin->msg ($player, "[ §c어둠의 소용돌이 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->darkdark1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "어둠어둠") {
				if (CooldownTask::isCooldown ($name, "해방")) {
					$this->plugin->msg ($player, "[ §c해방 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "해방") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "해방", 15);
					$this->plugin->msg ($player, "[ §c해방 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->darkdark2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "어둠어둠") {
				if (CooldownTask::isCooldown ($name, "블랙홀")) {
					$this->plugin->msg ($player, "[ §c블랙홀 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "블랙홀") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "블랙홀", 170);
					$this->plugin->msg ($player, "[ §c블랙홀 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c어둠어둠 궁극기§7를 사용하셨습니다.");
					$skill = new Skill ();
					$skill->darkdark3 ($player);
				}
			}
		}
	}
}