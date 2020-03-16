<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;

use SFruit\Skill;

class DoTomDoTomEvent extends FruitListener
{
	
	protected $plugin = null;
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}
	
	public static function getEventId (): int
	{
		return 17;
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "도톰도톰") {
				if (CooldownTask::isCooldown ($name, "압력포")) {
					$this->plugin->msg ($player, "[ §c압력포 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "압력포") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "압력포", 25);
					$this->plugin->msg ($player, "[ §c압력포 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->dotomdotom1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "도톰도톰") {
				if (CooldownTask::isCooldown ($name, "순간이동")) {
					$this->plugin->msg ($player, "[ §c순간이동 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "순간이동") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "순간이동", 5);
					$this->plugin->msg ($player, "[ §c순간이동 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->dotomdotom2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "도톰도톰") {
				if (CooldownTask::isCooldown ($name, "우르수스쇼크")) {
					$this->plugin->msg ($player, "[ §c우르수스쇼크 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "우르수스쇼크") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "우르수스쇼크", 170);
     CooldownTask::addCooldown ($name, "정신집중", 2.5);
					$this->plugin->msg ($player, "[ §c우르수스쇼크 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c도톰도톰 궁극기§7를 사용하셨습니다.");
					$skill = new Skill ();
					$skill->dotomdotomend ($player);
				}
			}
		}
	}
}