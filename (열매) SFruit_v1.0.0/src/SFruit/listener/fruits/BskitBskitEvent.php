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
use pocketmine\entity\Skin;

use pocketmine\entity\Entity;
use pocketmine\nbt\tag\CompoundTag;

use pocketmine\nbt\tag\StringTag;

use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\network\mcpe\protocol\AddActorPacket;

use SFruit\Skill;

class BskitBskitEvent extends FruitListener
{
	
	protected $plugin = null;
	
	public $position = [];
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 102;
	}
	
	public function handlePassive (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "비스킷비스킷") {
				if ($event->getFinalDamage() >= $entity->getHealth()) {
					if (CooldownTask::isCooldown ($name, "비스킷 갑주")) {
						$this->plugin->msg ($entity, "[ §c비스킷 갑주 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "비스킷 갑주") . "초§7 남았습니다.");
						return;
					} else {
						CooldownTask::addCooldown ($name, "비스킷 갑주", 50);
						$this->plugin->msg ($entity, "[ §c비스킷 갑주 §7] 스킬을 사용하셨습니다!");
						$this->plugin->getServer ()->broadcastMessage ("§b >> 비스킷비스킷 열매§7의 복용자 §b{$name}§7 님의 본체가 들어났습니다.");
						$event->setCancelled (true);
						$entity->setHealth ($entity->getMaxHealth ());
					}
				}
			}
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "비스킷비스킷") {
						if (!CooldownTask::isCooldown ($name, "비스킷 갑주")) {
							$event->setBaseDamage ($event->getBaseDamage () / 40);
						}
						return;
					}
					if ($this->plugin->db ["player"] [($pname = $player->getName ())] ["ability"] === "비스킷비스킷") {
						if (!CooldownTask::isCooldown ($pname, "비스킷 갑주")) {
							$event->setBaseDamage ($event->getBaseDamage () + 2);
						}
						return;
					}
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
	/*		if ($player->getLevel ()->getFolderName () === "island") {
				return;
			}*/
			if ($this->plugin->db ["player"] [$name] ["ability"] === "비스킷비스킷") {
				if (CooldownTask::isCooldown ($name, "비스킷 병사")) {
					$this->plugin->msg ($player, "[ §c비스킷 병사 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "비스킷 병사") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "비스킷 병사", 120);
					$this->plugin->msg ($player, "[ §c비스킷 병사 §7] 스킬을 사용하셨습니다!");
					$this->plugin->getServer ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c비스킷비스킷 궁극기§7를 사용하셨습니다.");
					$nbt = Entity::createBaseNBT ($player->asVector3 (), null, 0, 0);
			$nbt->setTag (new CompoundTag ("Skin", [
				new StringTag ("Name", $player->getSkin ()->getSkinId ()),
				new ByteArrayTag ("Data", $player->getSkin ()->getSkinData ()),
			]));
					$entity = Entity::createEntity ("Bskit", $player->level, $nbt);
					$entity->setNameTag ("§c< {$player->getName ()}님§7의 비스킷 병사§c >");
					$entity->setHealth (70);
					$entity->setOwner ($player);
					$entity->setScale (3);
					$entity->spawnToAll ();
				}
			}
		}
	}
}