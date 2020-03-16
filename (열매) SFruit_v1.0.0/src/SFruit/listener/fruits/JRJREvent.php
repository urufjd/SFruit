<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;
use pocketmine\Player;

use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\level\Explosion;

use pocketmine\entity\{
  Effect, EffectInstance
};

use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\AddActorPacket;

use SFruit\Skill;

class JRJREvent extends FruitListener
{
	
	protected $plugin = null;
	
	
	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 96;
	}
	
	public function handlePassive (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		
		if ($player->getLevel ()->getFolderName () === "world") {
			return;
		}
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
		if ($this->plugin->db ["player"] [$name] ["ability"] === "중력중력") {
  $item = $player->getInventory ()->getItemInHand ();
   if ($item->getId () !== 0) return;
			if (CooldownTask::isCooldown ($name, "중력 비행")) {
$this->plugin->msg ($player, "[ §c중력 비행 §7] 재사용 쿨타임이 §c" . CooldownTask::getCooldown ($name, "중력 비행") . "초§7 남았습니다.");
return;
}
			$this->plugin->msg ($player, "비해애애애애애애애ㅐ애애애애애ㅐ애애애애애애");
			if (!$player->isCreative ()){
				$player->setAllowFlight (true);
				$player->setFlying (true);
			}
		
			$this->plugin->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
				protected $player;
			
				public function __construct (Player $player)
				{
					$this->player = $player;
				}
			
				public function onRun (int $currentTick)
				{
					if (!$this->player->isCreative ()) {
						$this->player->setAllowFlight (false);
						$this->player->setFlying (false);
					}
				}
			}, 25 * 5);
			CooldownTask::addCooldown ($name, "중력 비행", 20);
		}
	}
	
	public function handleSkill1 (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "중력중력") {
				if (CooldownTask::isCooldown ($name, "중력 강화")) {
					$this->plugin->msg ($player, "[ §c중력 강화 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "중력 강화") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "중력 강화", 20);
					$this->plugin->msg ($player, "[ §c중력 강화 §7] 스킬을 사용하셨습니다!");
					foreach ($player->getLevel ()->getPlayers () as $players) {
						if ($player !== $players and $players->distance ($player) <= 10) {
							CooldownTask::addCooldown ($players->getName (), "이동 불가", 3);
						}
					}
				}
			}
		}
	}
	
	public function handleSkill2 (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "중력중력") {
				if (CooldownTask::isCooldown ($name, "운석 소환")) {
					$this->plugin->msg ($player, "[ §c운석 소환 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "운석 소환") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "운석 소환", 100);
					CooldownTask::addCooldown ($name, "정신집중", 3);
					$this->plugin->msg ($player, "[ §c운석 소환 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->doongsend ($player);
$this->plugin->getScheduler ()->scheduleDelayedTask (new class($player) extends \pocketmine\scheduler\Task{
private $player;

public function __construct (Player $player)
{
$this->player = $player;
}

public function onRun (int $currentTick)
{
$exp = new Explosion ($this->player, 10);
$exp->explodeB ();
}
}, 25 * 4);
				}
			}
		}
	}
	
	public function handleEndAbility (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "중력중력") {
				if (CooldownTask::isCooldown ($name, "맹호")) {
					$this->plugin->msg ($player, "[ §c맹호 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "맹호") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "맹호", 160);
					CooldownTask::addCooldown ($name, "정신 집중", 3);
					$this->plugin->msg ($player, "[ §c맹호 §7] 스킬을 사용하셨습니다!");
					foreach ($player->getLevel ()->getPlayers () as $players) {
						if ($player !== $players and $players->distance ($player) <= 20) {
							$players->teleport ($players->add (mt_rand (-15, 15), 0, mt_rand (-15, 15)));
							$players->setHealth ($players->getHealth () - 10);
						}
					}
					
				}
			}
		}
	}
}