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

class LightLightEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 5;
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "빛빛") {
				if (CooldownTask::isCooldown ($name, "야타의 거울")) {
					$this->plugin->msg ($player, "[ §c야타의 거울 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "야타의 거울") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "야타의 거울", 10);
					$this->plugin->msg ($player, "[ §c야타의 거울 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->lightlight1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "빛빛") {
				if (CooldownTask::isCooldown ($name, "아마테라스")) {
					$this->plugin->msg ($player, "[ §c아마테라스 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "아마테라스") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "아마테라스", 15);
					$this->plugin->msg ($player, "[ §c아마테라스 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->lightlight2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "빛빛") {
				if (CooldownTask::isCooldown ($name, "팔척경곡옥")) {
					$this->plugin->msg ($player, "[ §c팔척경곡옥 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "팔척경곡옥") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "팔척경곡옥", 150);
					$this->plugin->msg ($player, "[ §c팔척경곡옥 §7] 스킬을 사용하셨습니다!");
    \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c빛빛 궁극기§7를 사용하셨습니다.");
					$skill = new Skill ();
					$skill->lightlight3 ($player);
				}
			}
		}
	}
	public function handlePassive (PlayerInteractEvent $event): void
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "빛빛") {
     if (!CooldownTask::isCooldown ($player->getName (), "레이저")) {
						if ($player->getLevel ()->getFolderName () === "world") {
							return;
						}
      $item = $player->getInventory ()->getItemInHand ();
      if ($item->getId () !== 378) return;
						CooldownTask::addCooldown ($player->getName (), "레이저", 10);
						$skill = new Skill ();
						$skill->lightpassive ($player);
					}
				}
			
		}
	}
}