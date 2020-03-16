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

class TParentTParentEvent extends FruitListener
{
	
	protected $plugin = null;
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 13;
	}
	
	public function handlePassive (PlayerMoveEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		if ($this->plugin->db ["player"] [$name] ["ability"] === "투명투명") {
			if (!CooldownTask::isCooldown ($name, "은신")) {
				CooldownTask::addCooldown ($name, "은신", 10);
				$player->addEffect (new EffectInstance (Effect::getEffect(14), 20*2, 0));
			}
		}
	}
	
	public function handleSkill1 (PlayerInteractEvent $event): void
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "투명투명") {
				if (CooldownTask::isCooldown ($name, "은신1")) {
					$this->plugin->msg ($player, "[ §c은신1 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "은신1") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "은신1", 20);
					$this->plugin->msg ($player, "[ §c은신1 §7] 스킬을 사용하셨습니다!");
					$player->addEffect (new EffectInstance (Effect::getEffect(14), 20*5, 0));
					$player->addEffect (new EffectInstance (Effect::getEffect(1), 20*2, 2));
				}
			}
		}
	}
	
	public function handleSkill2 (EntityDamageEvent $event)
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "투명투명") {
						$item = $player->getInventory ()->getItemInHand ();
						if ($item->getId () === 378) {
							if ($player->getLevel ()->getFolderName () === "world") {
								return;
							}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
							if ($this->plugin->db ["player"] [$name] ["ability"] === "투명투명") {
								if (CooldownTask::isCooldown ($name, "은신2")) {
									$this->plugin->msg ($player, "[ §c은신2 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "은신2") . "초§7 남았습니다.");
									return;
								} else {
									CooldownTask::addCooldown ($name, "은신2", 30);
									$this->plugin->msg ($player, "[ §c은신2 §7] 스킬을 사용하셨습니다!");
									$player->addEffect (new EffectInstance (Effect::getEffect(14), 20*5, 0));
									$player->addEffect (new EffectInstance (Effect::getEffect(1), 20*2, 2));
									$entity->addEffect (new EffectInstance (Effect::getEffect(14), 20*5, 0));
									$entity->addEffect (new EffectInstance (Effect::getEffect(1), 20*2, 2));
								}
							}
						}
					}
				}
			}
		}
	}
}