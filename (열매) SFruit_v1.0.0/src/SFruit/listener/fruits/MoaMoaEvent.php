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

class MoaMoaEvent extends FruitListener
{
	
	protected $plugin = null;
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}
	
	public static function getEventId (): int
	{
		return 16;
	}
	
	public function handleSkill1 (EntityDamageEvent $event)
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "모아모아") {
						$item = $player->getInventory ()->getItemInHand ();
						if ($item->getId () === 369) {
							if ($player->getLevel ()->getFolderName () === "world") {
								return;
							}
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
							if (CooldownTask::isCooldown ($name, "모아모이 펀치")) {
								$this->plugin->msg ($player, "[ §c모아모아 펀치 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "모아모아 펀치") . "초§7 남았습니다.");
								return;
							} else {
								CooldownTask::addCooldown ($name, "모아모아 펀치", 10);
								$this->plugin->msg ($player, "[ §c모아모아 펀치 §7] 스킬을 사용하셨습니다!");
								$event->setBaseDamage (mt_rand (5, 40));
							}
						}
					}
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "모아모아") {
				if (CooldownTask::isCooldown ($name, "모아모아속")) {
					$this->plugin->msg ($player, "[ §c모아모아속 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "모아모아속") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "모아모아속", 15);
					$this->plugin->msg ($player, "[ §c모아모아속 §7] 스킬을 사용하셨습니다!");
					$player->addEffect (new EffectInstance (Effect::getEffect(1), 20*2, 2));
				}
			}
		}
	}
	
	public function handleEndAbility (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		if ($item->getId () ===437) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "모아모아") {
				if (CooldownTask::isCooldown ($name, "모아모아 포")) {
					$this->plugin->msg ($player, "[ §c모아모아 포 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "모아모아 포") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "모아모아 포", 160);
					$this->plugin->msg ($player, "[ §c모아모아 포 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c모아모아 궁극기§7를 사용하셨습니다.");
					$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*7, 10));
      $pos = $event->getBlock ()->add (mt_rand (-5, 5), 1, mt_rand (-5, 5));
					$this->plugin->getScheduler ()->scheduleDelayedTask (new class ($pos) extends \pocketmine\scheduler\Task{
          protected $pos;

          public function __construct (Position $pos) {
              $this->pos = $pos;
          }

          public function onRun (int $currentTick)
          {
              $explosion = new \pocketmine\entity\Explosion ($this->pos, 2);
						        $explosion->explodeB ();
          }
       }, 50);
				}
			}
		}
	}
}