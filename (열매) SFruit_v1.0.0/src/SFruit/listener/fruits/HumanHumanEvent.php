<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;
use pocketmine\Player;

use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\level\Explosion;

use pocketmine\entity\{
  Effect, EffectInstance
};

use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\AddActorPacket;

use SFruit\Skill;

class HumanHumanEvent extends FruitListener
{
	
	protected $plugin = null;
	
	
	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 86;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					$name = $player->getName ();
					$ename = $entity->getName ();
					if ($this->plugin->db ["player"] [$name] ["ability"] === "사람사람") {
						if ($player->getLevel ()->getFolderName () === "world") {
							return;
						}
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
						if (CooldownTask::isCooldown ($name, "대불모드")) {
$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
							$explosion = new Explosion ($entity, 3);
							$explosion->explodeB ();
						}
						return;
					}
					if ($this->plugin->db ["player"] [$ename] ["ability"] === "사람사람") {
						if (CooldownTask::isCooldown ($ename, "대불모드")) {
							$event->setBaseDamage (($event->getBaseDamage () / 60) + 1);
						}
					}
				}
				
			}
		}
	}
	
	public function handleSkill1 (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "사람사람") {
				if (CooldownTask::isCooldown ($name, "충격파")) {
					$this->plugin->msg ($player, "[ §c충격파 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "충격파") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "충격파", 10);
					$this->plugin->msg ($player, "[ §c충격파 §7] 스킬을 사용하셨습니다!");
$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
					$explosion = new Explosion ($event->getBlock (), 5);
					$explosion->explodeB ();
				}
			}
		}
	}
	
	public function handleEndAbility (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "사람사람") {
				if (CooldownTask::isCooldown ($name, "대불")) {
					$this->plugin->msg ($player, "[ §c대불 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "대불") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "대불", 160);
					CooldownTask::addCooldown ($name, "대불모드", 99999);
					$this->plugin->msg ($player, "[ §c대불 §7] 스킬을 사용하셨습니다!");
					$player->setScale (3);
					
				}
			}
		}
	}
	
	public function onMove (\pocketmine\event\player\PlayerMoveEvent $event)
	{
	   $player = $event->getPlayer ();
	   $name = $player->getName ();
	   if (CooldownTask::isCooldown ($name, "대불모드")) {
	      if ($this->plugin->db ["player"] [$name] ["ability"] !== "사람사람") {
	         CooldownTask::addCooldown ($name, "대불모드", 0);
	      }
	   }
	}
}