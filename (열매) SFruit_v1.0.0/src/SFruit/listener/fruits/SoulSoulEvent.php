<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\{PlayerInteractEvent, PlayerMoveEvent };
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

class SoulSoulEvent extends FruitListener
{
	
	protected $plugin = null;
	
	protected $life = [];
	
	protected $mode = [];
	
	protected $locate = [];
	
	
	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 98;
	}

public function handleQuit (\pocketmine\event\player\PlayerQuitEvent $event)
{
$player = $event->getPlayer ();
$name = $player->getName ();
if (isset ($this->life [$name])) {
$this->plugin->db ["player"] [$name] ["count"] = $this->life [$name];
}
}

public function handleJoin (\pocketmine\event\player\PlayerJoinEvent $event)
{
$player = $event->getPlayer ();
$name = $player->getName ();
if (isset ($this->plugin->db ["player"] [$name] ["count"])) {
$this->life [$name] = $this->plugin->db ["player"] [$name] ["count"];
}
}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] === "소울소울") {
						if ($player->level->getFolderName () === "world") {
							return;
						}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
$item = $player->getInventory ()->getItemInHand ();
if ($item->getId () !== 0) return;
						if (CooldownTask::isCooldown ($player->getName (), $entity->getName ())) {
							$this->plugin->msg ($player, "해당 플레이어는 3분뒤에 저주가 가능합니다.");
							return;
						}
						if (CooldownTask::isCooldown ($player->getName (), "저주사용")) {
							$this->plugin->msg ($player, "[ §c저주사용 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($player->getName (), "저주사용") . "초§7 남았습니다.");
							return;
						} else {
							$this->plugin->msg ($player, "[ §c저주사용 §7] 스킬을 사용하셨습니다!");
							CooldownTask::addCooldown ($player->getName (), "저주사용", 30);
							CooldownTask::addCooldown ($entity->getName (), "저주", 10);
							CooldownTask::addCooldown ($player->getName (), $entity->getName (), (60*3));
							$this->locate [$entity->getName ()] = [
						'pos' =>		(int)$entity->x.":".(int)$entity->y.":".(int)$entity->z,
								'name' => $player->getName ()
							];
var_dump ($this->locate [$entity->getName ()]);
						}
						if (isset ($this->mode [$player->getName ()])) {
							if ($this->mode [$player->getName ()] === "태양 프로메테우스") {
								$this->life [$player->getName ()] ++;
								if ($this->life [$player->getName ()] >= 4) {
									$entity->setOnFire (5);
									$this->life [$player->getName ()] = 0;
								}
							} else {
								$this->life [$player->getName ()] ++;
								if ($this->life [$player->getName ()] >= 5) {
									$pos = new Position ((int) $entity->x, (int) $entity->y, (int) $entity->z, $entity->level);
									$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
									$packet = new AddActorPacket ();
									$packet->entityRuntimeId = Entity::$entityCount ++;
									$packet->position = $pos;
									$packet->type = 93;
									foreach ($pos->level->getPlayers () as $players) {
										$players->dataPacket ($packet);
									}
									$explosion = new Explosion ($pos, 3);
									$explosion->explodeB ();
								}
							}
						}
					}
				}
			}
			
		}
	}
	
	public function handleMove (PlayerMoveEvent $event)
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		
		if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] === "소울소울") {
			if ($player->level->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}

			if (!CooldownTask::isCooldown ($player->getName (), "태양 프로메테우스 / 뇌운 제우스")) {
				if (!isset ($this->mode [$name])) {
					$this->mode [$name] = "태양 프로메테우스";
				} else if ($this->mode [$name] === "태양 프로메테우스") {
					$this->mode [$name] = "뇌운 제우스";
				} else {
					$this->mode [$name] = "태양 프로메테우스";
				}
				$this->life [$name] = 0;
				CooldownTask::addCooldown ($player->getName (), "태양 프로메테우스 / 뇌운 제우스", 20);
			}
		}
		if (isset ($this->locate [$name] )) {
			$pos = explode (":", $this->locate [$name] ["pos"]);
			$pos = new Position ((int) $pos [0], (int) $pos [1], (int) $pos [2], $player->level);
   if (CooldownTask::isCooldown ($name, "저주")) {
		  	if ($player->distance ($pos) > 7) {
					$player->kill ();
					if (($owner = $this->plugin->getServer ()->getPlayer ($this->locate [$name] ["name"])) !== null) {
						$this->plugin->msg ($owner, "§a{$name}§7님께서 저주를 당해 10년의 수명을 획득하셨습니다.");
					}
				}
			}
			unset ($this->locate [$name]);
		}
	}
	
	public function handleSkil1 (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "소울소울") {
				if (!isset ($this->mode [$name])) {
					if ($this->mode [$name] === "태양 프로메테우스") {
						if (CooldownTask::isCooldown ($name, "헤븐리 포이어")) {
							$this->plugin->msg ($player, "[ §c헤븐리 포이어 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "헤븐리 포이어") . "초§7 남았습니다.");
							return;
						} else {
							CooldownTask::isCooldown ($name, "헤븐리 포이어", 12);
							$this->plugin->msg ($player, "[ §c헤븐리 포이어 §7] 스킬을 사용하셨습니다!");
							$skill = new Skill ();
							$skill->soulsoul1 ($player);
						}
					} else {
						if (CooldownTask::isCooldown ($name, "낙뢰")) {
							$this->plugin->msg ($player, "[ §c낙뢰 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "낙뢰") . "초§7 남았습니다.");
							return;
						} else {
							CooldownTask::isCooldown ($name, "낙뢰", 15);
							$this->plugin->msg ($player, "[ §c낙뢰 §7] 스킬을 사용하셨습니다!");
							$block = $event->getBlock ();
							$pos = new Position ((int) $block->x, (int) $block->y, (int) $block->z, $player->level);
							$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
							$packet = new AddActorPacket ();
							$packet->entityRuntimeId = Entity::$entityCount ++;
							$packet->position = $pos;
							$packet->type = 93;
							foreach ($pos->level->getPlayers () as $players) {
								$players->dataPacket ($packet);
							}
							$explosion = new Explosion ($pos, 5);
							$explosion->explodeB ();
						}
					}
				}
			}
		}
	}
	
	public function handleSkil2 (PlayerInteractEvent $event)
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "소울소울") {
				if ($player->isSneaking ()) {
					if (CooldownTask::isCooldown ($name, "소환")) {
						$this->plugin->msg ($player, "[ §c소환 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "소환") . "초§7 남았습니다.");
						return;
					} else {
						if ($this->life [$name] < 40) {
							$this->plugin->msg ($player, "루크 병사를 소환하실려면 40년의 수명이 필요합니다.");
							return;
						} else {
							CooldownTask::isCooldown ($name, "소환", 10);
							$this->plugin->msg ($player, "[ §c소환 §7] 스킬을 사용하셨습니다!");
							$skill = new Skill ();
							$skill->soulsoul2 ($player, "루크");
						}
					}
				} else {
					if (CooldownTask::isCooldown ($name, "소환")) {
						$this->plugin->msg ($player, "[ §c소환 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "소환") . "초§7 남았습니다.");
						return;
					} else {
						if ($this->life [$name] < 20) {
							$this->plugin->msg ($player, "루크 병사를 소환하실려면 40년의 수명이 필요합니다.");
							return;
						} else {
							CooldownTask::isCooldown ($name, "소환", 5);
							$this->plugin->msg ($player, "[ §c소환 §7] 스킬을 사용하셨습니다!");
							$skill = new Skill ();
							$skill->soulsoul2 ($player, "폰");
						}
					}
				}
			}
		}
	}
}