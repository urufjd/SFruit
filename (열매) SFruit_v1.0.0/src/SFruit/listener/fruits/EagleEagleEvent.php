<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;
use SFruit\SFruit;
use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;
use pocketmine\Player;

use pocketmine\entity\{
  Effect, EffectInstance
};
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\level\Explosion;

use SFruit\Skill;

class EagleEagleEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 1;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			$name = $entity->getName ();
			if ($this->plugin->db ["player"] [$name] ["ability"] === "이글이글") {
				if (
					$event->getCause () === EntityDamageEvent::CAUSE_LAVA ||
					$event->getCause () === EntityDamageEvent::CAUSE_FIRE ||
					$event->getCause () === EntityDamageEvent::CAUSE_FIRE_TICK
				) {
					$event->setCancelled (true);
					$entity->sendPopup ("§l§c<<§f 패시브로 인해 불데미지를 받지 않습니다. §c>>");
				}
			}
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					$pname = $player->getName ();
					$ename = $entity->getName ();
					if ($this->plugin->db ["player"] [$ename] ["ability"] === "이글이글") {
						$player->setOnFire (3);
						return;
					}
					if ($this->plugin->db ["player"] [$pname] ["ability"] === "이글이글") {
						$entity->setOnFire (3);
						return;
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "이글이글") {
				if (CooldownTask::isCooldown ($name, "불주먹")) {
					$this->plugin->msg ($player, "[ §c불주먹 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "불주먹") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "불주먹", 15);
					$this->plugin->msg ($player, "[ §c불주먹 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->eagleeagle1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "이글이글") {
				if (CooldownTask::isCooldown ($name, "반딧불/불꽃")) {
					$this->plugin->msg ($player, "[ §c반딧불/불꽃 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "반딧불/불꽃") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "반딧불/불꽃", 25);
					$this->plugin->msg ($player, "[ §c반딧불/불꽃 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->eagleeagle2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "이글이글") {
				if (CooldownTask::isCooldown ($name, "대염계 염제")) {
					$this->plugin->msg ($player, "[ §c대염계 염제 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "대염계 염제") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "대염계 염제", 150);
     CooldownTask::addCooldown ($name, "정신집중", 3);
					$this->plugin->msg ($player, "3초뒤 10칸 주변 플레이어들에게 대염계 염제의 불꽃을 시젼합니다.");
    $player->addEffect (new EffectInstance (Effect::getEffect (11), 20*5, 4));
    \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c이글이글 궁극기§7를 사용하셨습니다.");
					$this->plugin->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
						protected $player;
						
						public function __construct (Player $player)
						{
							$this->player = $player;
						}
						
						public function onRun (int $currentTick)
						{
							foreach ($this->player->getLevel ()->getPlayers () as $players) {
								if ($players->distance ($this->player) <= 10) {
									$pos = new Position ((int) $this->player->x, (int) $this->player->y, (int) $this->player->z, $this->player->level);
									$exp = new Explosion ($pos, 10);
									$exp->explodeB ();
									$players->setOnFire (7);
								}
							}
						}
					}, 75);
				}
			}
		}
	}
}