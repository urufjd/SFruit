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

use pocketmine\level\Explosion;
use pocketmine\level\Position;

use SFruit\Skill;

class HdleHdleEvent extends FruitListener
{
	
	protected $plugin = null;
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 15;
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "흔들흔들") {
				if (CooldownTask::isCooldown ($name, "격진")) {
					$this->plugin->msg ($player, "[ §c격진 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "격진") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "격진", 10);
					$this->plugin->msg ($player, "[ §c격진 §7] 스킬을 사용하셨습니다!");
					$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*4, 4));
					$pos = $event->getBlock ()->add (mt_rand (-5, 5), 1, mt_rand (-5, 5));
					$pos = new Position ($pos->x, $pos->y, $pos->z, $player->level);
					$explosion = new Explosion ($pos, 2);
					$explosion->explodeB ();
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "흔들흔들") {
				if (CooldownTask::isCooldown ($name, "대격진")) {
					$this->plugin->msg ($player, "[ §c대격진 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "대격진") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "대격진", 30);
					$this->plugin->msg ($player, "[ §c대격진 §7] 스킬을 사용하셨습니다!");
					$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*7, 10));
					$pos = $event->getBlock ()->add (mt_rand (-5, 5), 1, mt_rand (-5, 5));
$pos = new Position ($pos->x, $pos->y, $pos->z, $player->level);
					$explosion = new Explosion ($pos, 2);
					$explosion->explodeB ();
					
					$pos = $event->getBlock ()->add (mt_rand (-5, 5), 1, mt_rand (-5, 5));
$pos = new Position ($pos->x, $pos->y, $pos->z, $player->level);
					$explosion = new Explosion ($pos, 2);
					$explosion->explodeB ();
					
					$pos = $event->getBlock ()->add (mt_rand (-5, 5), 1, mt_rand (-5, 5));
$pos = new Position ($pos->x, $pos->y, $pos->z, $player->level);
					$explosion = new Explosion ($pos, 2);
					$explosion->explodeB ();
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "흔들흔들") {
				if (CooldownTask::isCooldown ($name, "섬 흔들기")) {
					$this->plugin->msg ($player, "[ §c섬 흔들기 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "섬 흔들기") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "섬 흔들기", 180);
					$this->plugin->msg ($player, "[ §c섬 흔들기 §7] 스킬을 사용하셨습니다!");
               $player->addEffect (new EffectInstance (Effect::getEffect (11), 20*7, 10));
               $pos = $event->getBlock ()->add (mt_rand (-5, 5), 1, mt_rand (-5, 5));
$pos = new Position ($pos->x, $pos->y, $pos->z, $player->level);
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c흔들흔들 궁극기§7를 사용하셨습니다.");
					$this->plugin->getScheduler ()->scheduleDelayedTask (new class ($pos) extends \pocketmine\scheduler\Task{
                  protected $pos;

                  public function __construct (Position $pos) {
                     $this->pos = $pos;
                  }

                  public function onRun (int $currentTick)
                  {
                     $explosion = new Explosion ($this->pos, 2);
					      $explosion->explodeB ();
                  }
               }, 50);
				}
			}
		}
	}
}