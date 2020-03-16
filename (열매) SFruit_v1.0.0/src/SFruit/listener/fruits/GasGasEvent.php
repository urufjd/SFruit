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

class GasGasEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 4;
	}
public function handlePassive (\pocketmine\event\player\PlayerMoveEvent $event)
{
$player = $event->getPlayer ();
$name = $player->getName ();
if ($this->plugin->db ["player"] [$name] ["ability"] === "가스가스") {
     if ($player->hasEffect (19)) $player->removeEffect (19);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "가스가스") {
				if (CooldownTask::isCooldown ($name, "가스로브")) {
					$this->plugin->msg ($player, "[ §c가스로브 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "가스로브") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "가스로브", 15);
					$this->plugin->msg ($player, "[ §c가스로브 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->gasgas1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "가스가스") {
				if (CooldownTask::isCooldown ($name, "블루소드")) {
					$this->plugin->msg ($player, "[ §c블루소드 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "블루소드") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "블루소드", 20);
					$this->plugin->msg ($player, "[ §c블루소드 §7] 스킬을 사용하셨습니다!");
					CooldownTask::addCooldown ($name, "블루소드 모드", 7);
				}
			}
		}
	}
	
	public function handleAttack (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent ) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] === "가스가스") {
						if (CooldownTask::isCooldown ($player->getName (), "블루소드")) {
							$entity->setOnFire (3);
							$this->plugin->msg ($player, "§c블루소드§7 로 인해 적에게 §c화상 3초§7를 입혔습니다.");
						}
					}
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "가스가스") {
				if (CooldownTask::isCooldown ($name, "무공세계")) {
					$this->plugin->msg ($player, "[ §c무공세계 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "무공세계") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "무공세계", 130);
					$this->plugin->msg ($player, "[ §c무공세계 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c가스가스 궁극기§7를 사용하셨습니다.");
					$skill = new Skill ();
					$skill->gasgas3 ($player);
				}
			}
		}
	}
}