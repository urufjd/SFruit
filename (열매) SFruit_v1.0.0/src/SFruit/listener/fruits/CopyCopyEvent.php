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
use pocketmine\network\mcpe\protocol\AddActorPacket;

use SFruit\Skill;

class CopyCopyEvent extends FruitListener
{
	
	protected $plugin = null;
	
	public $originSkin = [];
	
	public $copySkin = [];
	
	public $mode = [];
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 100;
	}
	
	public function handleSkill1 (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] === "복사복사") {
						if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
						if ($player->getLevel ()->getFolderName () === "world") {
							return;
						}
						$item = $player->getInventory ()->getItemInHand ();
						if ($item->getId () === 369) {
$name = $player->getName ();
							if (CooldownTask::isCooldown ($name, "복사")) {
								$this->plugin->msg ($player, "[ §c복사 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "복사") . "초§7 남았습니다.");
								return;
							} else {
								CooldownTask::addCooldown ($name, "복사", 30);
								$this->plugin->msg ($player, "[ §c복사 §7] 스킬을 사용하셨습니다!");
								$this->originSkin [$player->getName ()] = new Skin ($player->getSkin ()->getSkinId (), $player->getSkin ()->getSkinData ());
								$this->copySkin [$player->getName ()] = new Skin ($entity->getSkin ()->getSkinId (), $entity->getSkin ()->getSkinData ());
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "복사복사") {
				if (CooldownTask::isCooldown ($name, "변신")) {
					$this->plugin->msg ($player, "[ §c변신 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "변신") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "변신", 10);
					$this->plugin->msg ($player, "[ §c변신 §7] 스킬을 사용하셨습니다!");
					$origin = null;
					$copy = null;
					if (isset ($this->copySkin [$name])) {
						$copy = $this->copySkin [$name];
					}
					if (isset ($this->originSkin [$name])) {
						$origin = $this->originSkin [$name];
					}
					if ($copy instanceof Skin and $origin instanceof Skin) {
						if ($copy->getSkinId () !== base64_encode ($player->getSkin ()->getSkinId ())) {
							$player->sendSkin ($origin);
						} else {
							$player->sendSkin ($copy);
						}
						foreach ($this->plugin->getOnlinePlayers () as $players) {
							$player->sendSkin ([$players, $player]);
						}
					}
				}
			}
		}
	}
}