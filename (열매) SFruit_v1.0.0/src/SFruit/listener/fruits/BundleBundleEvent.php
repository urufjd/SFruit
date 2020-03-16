<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;


use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;
use pocketmine\Player;

use SFruit\Skill;

class BundleBundleEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 3;
	}

public function a (EntityDamageEvent $event)
{
if(($entity = $event->getEntity ()) instanceof Player){
    if ($event instanceof EntityDamageByEntityEvent){
        if (($player = $event->getDamager ()) instanceof Player){
            if ($this->plugin->db ["player"] [$entity->getName ()] ["ability"] === "뭉개뭉개") {
                $skill = new Skill ();
                $skill->part ($entity);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "뭉개뭉개") {
				if (CooldownTask::isCooldown ($name, "화이트 블로우")) {
					$this->plugin->msg ($player, "[ §c화이트 블로우 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "화이트 블로우") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "화이트 블로우", 10);
					$this->plugin->msg ($player, "[ §c화이트 블로우 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->bundlebundle1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "뭉개뭉개") {
				if (CooldownTask::isCooldown ($name, "화이트 런쳐")) {
					$this->plugin->msg ($player, "[ §c화이트 런쳐 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "화이트 런쳐") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "화이트 런쳐", 20);
					$this->plugin->msg ($player, "[ §c화이트 런쳐 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->bundlebundle2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "뭉개뭉개") {
				if (CooldownTask::isCooldown ($name, "화이트 스네이크")) {
					$this->plugin->msg ($player, "[ §c화이트 스네이크 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "화이트 스네이크") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "화이트 스네이크", 80);
    \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c뭉개뭉개 궁극기§7를 사용하셨습니다.");
					$this->plugin->msg ($player, "[ §c화이트 스네이크 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->bundlebundle3 ($player);
				}
			}
		}
	}
}