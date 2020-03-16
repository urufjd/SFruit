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

class DoongSDoongSEvent extends FruitListener
{
	
	protected $plugin = null;
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 14;
	}
	
	public function handlePassive (PlayerMoveEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		if ($this->plugin->db ["player"] [$name] ["ability"] === "둥실둥실") {
			if (!$player->isCreative ()) {
				if ($player->level->getFolderName () !== "world") {
					$player->setAllowFlight (true);
					$player->setFlying (true);
				} else {
					$player->setAllowFlight (false);
					$player->setFlying (false);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "둥실둥실") {
				if (CooldownTask::isCooldown ($name, "천공 떨구기")) {
					$this->plugin->msg ($player, "[ §c천공 떨구기 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "천공 떨구기") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "천공 떨구기", 80);
					$this->plugin->msg ($player, "[ §c천공 떨구기 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c둥실둥실 궁극기§7를 사용하셨습니다.");
$skill = new Skill ();
$skill->doongsend ($player);
					//TODO..
				}
			}
		}
	}
}