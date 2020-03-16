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

class BridBridEvent extends FruitListener
{
	
	protected $plugin = null;
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}
	
	public static function getEventId (): int
	{
		return 20;
	}
	
	public function handlePassive	(EntityDamageEvent $event)
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "새새") {
						$entity->addEffect (new EffectInstance (Effect::getEffect(10), 20*10, 1));
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "새새") {
				if (CooldownTask::isCooldown ($name, "비행")) {
					$this->plugin->msg ($player, "[ §c비행 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "비행") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "비행", 20);
					$this->plugin->msg ($player, "[ §c비행 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->bridbrid1 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "새새") {
				if (CooldownTask::isCooldown ($name, "푸른불꽃의 재생")) {
					$this->plugin->msg ($player, "[ §c푸른불꽃의 재생 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "푸른불꽃의 재생") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "푸른불꽃의 재생", 20);
					$this->plugin->msg ($player, "[ §c푸른불꽃의 재생 §7] 스킬을 사용하셨습니다!");
					if (CooldownTask::isCooldown ($name, "불사조 모드")) {
						$player->addEffect (new EffectInstance (Effect::getEffect(10), 20*10, 9));
					} else {
						$player->addEffect (new EffectInstance (Effect::getEffect(10), 20*10, 4));
					}
				}
			}
		}
	}
	
	public function handleSkill3 (EntityDamageEvent $event)
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "새새") {
						$item = $player->getInventory ()->getItemInHand ();
						if ($item->getId () === 378) {
							if ($player->getLevel ()->getFolderName () === "world") {
								return;
							}
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
							if (CooldownTask::isCooldown ($name, "푸른 불꽃")) {
								$this->plugin->msg ($player, "[ §c푸른 불꽃 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "푸른 불꽃") . "초§7 남았습니다.");
								return;
							} else {
								CooldownTask::addCooldown ($name, "푸른 불꽃", 30);
								$this->plugin->msg ($player, "[ §c푸른 불꽃 §7] 스킬을 사용하셨습니다!");
								$entity->addEffect (new EffectInstance (Effect::getEffect(10), 20*10, 1));
							}
						}
						return;
					}
					if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "새새") {
						if (CooldownTask::isCooldown ($name, "불사조 모드")) {
							$entity->addEffect (new EffectInstance (Effect::getEffect(10), 20*2, 4));
						}
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
if ($player->getLevel ()->getFolderName () === "island") {
							return;
						}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "새새") {
				if (CooldownTask::isCooldown ($name, "불사조")) {
					$this->plugin->msg ($player, "[ §c불사조 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "불사조") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "불사조", 100);
					$this->plugin->msg ($player, "[ §c불사조 §7] 스킬을 사용하셨습니다!");
					CooldownTask::addCooldown ($name, "불사조 모드", 9999);
				}
			}
		}
	}
	
	public function handleMove (\pocketmine\event\player\PlayerMoveEvent $event)
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		
		if ($this->plugin->db ["player"] [$name] ["ability"] === "새새") {
			if ($player->level->getFolderName () === "island") {
				if (CooldownTask::isCooldown ($name, "불사조 모드")) {
					if (!$player->isCreative ()){
						$player->setAllowFlight (true);
						$player->setFlying (true);
					}
				}
			}
		}
	}
}