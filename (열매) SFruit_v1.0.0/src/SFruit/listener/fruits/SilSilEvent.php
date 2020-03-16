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

class SilSilEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 10;
	}
	
	public function handlePassive (PlayerMoveEvent $event): void
	{
		$player = $event->getPlayer ();
		if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "실실") {
			if (!CooldownTask::isCooldown ($name, "실실 회복")) {
				$player->setHealth ($player->getHealth () + 10);
				CooldownTask::addCooldown ($name, "실실 회복", 20);
    $player->sendPopup ("봉합 수술이 됐습니다.");
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "실실") {
				if (CooldownTask::isCooldown ($name, "오버히트")) {
					$this->plugin->msg ($player, "[ §c오버히트 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "오버히트") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "오버히트", 10);
					$this->plugin->msg ($player, "[ §c오버히트 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->silsil1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "실실") {
				if (CooldownTask::isCooldown ($name, "비행")) {
					$this->plugin->msg ($player, "[ §c비행 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "비행") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "비행", 20);
					$this->plugin->msg ($player, "[ §c비행 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->silsil2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "실실") {
				if (CooldownTask::isCooldown ($name, "블랙나이트")) {
					$this->plugin->msg ($player, "[ §c블랙나이트 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "블랙나이트") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "블랙나이트", 50);
					$this->plugin->msg ($player, "[ §c블랙나이트 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->silsil3 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "실실") {
				if (CooldownTask::isCooldown ($name, "16발의 성스러운 흉탄")) {
					$this->plugin->msg ($player, "[ §c16발의 성스러운 흉탄 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "16발의 성스러운 흉탄") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "16발의 성스러운 흉탄", 200);
					$this->plugin->msg ($player, "[ §c16발의 성스러운 흉탄 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c실실 궁극기§7를 사용하셨습니다.");
					$skill = new Skill ();
					$skill->silsilend ($player);
				}
			}
		}
	}
	
}