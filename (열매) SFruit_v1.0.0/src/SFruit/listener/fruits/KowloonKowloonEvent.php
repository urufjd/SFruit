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

class KowloonKowloonEvent extends FruitListener
{
	
	protected $plugin = null;

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 2;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					$name = $player->getName ();
					$ename = $entity->getName ();
					if ($this->plugin->db ["player"] [$ename] ["ability"] === "쿠릉쿠릉") {
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
if ($player->getLevel ()->getFolderName () === "world") {
							return;
						}
						$time = 1;
						CooldownTask::addCooldown ($name, "감전", $time);
						$this->plugin->msg ($player, "상대의 §c쿠릉쿠릉 열매§7 패시브가 발동했습니다. §c감전 1초§7가 부여되었습니다!");
						$this->plugin->msg ($player, "적 §c{$player->getName ()}§7님께서 당신을 공격해서 §c감전 1초§7를 부여했습니다!");
					} else if ($this->plugin->db ["player"] [$name] ["ability"] === "쿠릉쿠릉") {
        $time = 1;
						CooldownTask::addCooldown ($ename, "감전", $time);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "쿠릉쿠릉") {
				if (CooldownTask::isCooldown ($name, "신의 심판")) {
					$this->plugin->msg ($player, "[ §c신의 심판 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "신의 심판") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "신의 심판", 15);
					$this->plugin->msg ($player, "[ §c신의 심판 §7] 스킬을 사용하셨습니다!");
					$block = $event->getBlock ();
					$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
					$pos = new Position ((int) $block->x, (int) $block->y, (int) $block->z, $block->level);
					
					$packet = new AddActorPacket ();
					$packet->entityRuntimeId = Entity::$entityCount ++;
					$packet->position = $pos;
					$packet->type = 93;
					$explosion = new Explosion ($pos, 5);
					$explosion->explodeB ();
					foreach ($pos->level->getPlayers () as $players) {
     
						$players->dataPacket ($packet);
      
						if ($player !== $players) {
						if ($players->distance ($pos) < 5) {
							$time = 2;
							if (CooldownTask::isCooldown ($players->getName (), "감전")) {
								$time += CooldownTask::getCooldown ($players->getName (), "감전");
							}
							CooldownTask::deleteCooldown ($players->getName (), "감전");
							CooldownTask::addCooldown ($players->getName (), "감전", $time);
							$this->plugin->msg ($players, "§c쿠릉쿠릉 열매§7의 [§c 신의 권능§7 ] 의 번개에 맞아서 §c감전 2초§7를 부여받았습니다!");
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "쿠릉쿠릉") {
				if (CooldownTask::isCooldown ($name, "2억볼트 감전")) {
					$this->plugin->msg ($player, "[ §c2억볼트 감전 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "2억볼트 감전") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "2억볼트 감전", 25);
					$this->plugin->msg ($player, "[ §c2억볼트 감전 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->kowloonkowloon2 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "쿠릉쿠릉") {
				if (CooldownTask::isCooldown ($name, "뇌신 아마르")) {
					$this->plugin->msg ($player, "[ §c뇌신 아마르 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "뇌신 아마르") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "뇌신 아마르", 150);
					$this->plugin->msg ($player, "[ §c뇌신 아마르 §7] 스킬을 사용하셨습니다!");
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c쿠릉쿠릉 궁극기§7를 사용하셨습니다.");
					CooldownTask::addCooldown ($name, "뇌신 아마르 모드", 15);
				}
			}
		}
	}
	
	public function handleAttack (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) { //Player
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if (CooldownTask::isCooldown ($player->getName (), "뇌신 아마르 모드")) {
						if ($player->getLevel ()->getFolderName () === "world") {
							return;
						}
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
      if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] !== "쿠릉쿠릉") return;
						$pos = new Position ((int) $entity->x, (int) $entity->y, (int) $entity->z, $entity->level);
						$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
						$packet = new AddActorPacket ();
						$packet->entityRuntimeId = Entity::$entityCount ++;
						$packet->position = $pos;
						$packet->type = 93;
						
						foreach ($pos->level->getPlayers () as $players) {
							$players->dataPacket ($packet);
						}
						
						$explosion = new Explosion ($pos, 1);
						$explosion->explodeB ();
					}
				}
			}
		}
	}
}