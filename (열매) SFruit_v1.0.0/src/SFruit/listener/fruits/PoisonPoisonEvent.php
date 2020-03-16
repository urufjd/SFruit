<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;

use SFruit\Skill;

class PoisonPoisonEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 9;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [$entity->getName ()] ["ability"] === "독독") {
						$player->addEffect (new EffectInstance (Effect::getEffect (19), 20*5, 0));
						if (CooldownTask::isCooldown ($entity->getName (), "베놈데몬 모드")) {
							$player->setHealth ($player->getHealth () - 3);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "독독") {
				if (CooldownTask::isCooldown ($name, "히드라")) {
					$this->plugin->msg ($player, "[ §c히드라 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "히드라") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "히드라", 15);
					$this->plugin->msg ($player, "[ §c히드라 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->poisonpoison1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "독독") {
				if (CooldownTask::isCooldown ($name, "독구름")) {
					$this->plugin->msg ($player, "[ §c독구름 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "독구름") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "독구름", 20);
					$this->plugin->msg ($player, "[ §c독구름 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->poisonpoison2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "독독") {
				if (CooldownTask::isCooldown ($name, "베놈데몬")) {
					$this->plugin->msg ($player, "[ §c베놈데몬 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "베놈데몬") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "베놈데몬", 150);
					$this->plugin->msg ($player, "[ §c베놈데몬 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c독독 궁극기§7를 사용하셨습니다.");
					CooldownTask::addCooldown ($name, "베놈데몬 모드", 15);
				}
			}
		}
	}
}