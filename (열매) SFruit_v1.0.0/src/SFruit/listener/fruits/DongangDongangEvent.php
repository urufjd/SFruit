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

class DongangDongangEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 11;
	}

 public $items = [
   268, 271, 272, 275, 276, 279, 283, 285, 258, 267
 ];
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [$entity->getName ()] ["ability"] === "동강동강") {
						$item = $player->getInventory ()->getItemInHand ();
						if (in_array ($item->getId (), $this->items)) {
							$event->setCancelled (true);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "동강동강") {
				if (CooldownTask::isCooldown ($name, "비행")) {
					$this->plugin->msg ($player, "[ §c비행 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "비행") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "비행", 20);
					$this->plugin->msg ($player, "[ §c비행 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->dongangdongang1 ($player);
				}
			}
		}
	}
}