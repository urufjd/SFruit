<?php


namespace SFruit\listener\fruits;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\item\ItemIds;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;

use SFruit\Skill;

class ShadowShadowEvent extends FruitListener
{
	
	protected $plugin = null;
	
	protected $shadow = [];
	
	protected $sec = [];
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 12;
	}
	
	public function handleJoin (PlayerJoinEvent $event)
	{
		$player = $event->getPlayer ();
		
		if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "그림자그림자") {
			if (!isset ($this->shadow [$name])) {
				$this->shadow [$name] = 0;
				$this->plugin->msg ($player, "재부팅이 되서 당신은 그림자는 0개 입니다.");
			}
		}
	}
	
public function handleQuit (\pocketmine\event\player\PlayerQuitEvent $event)
{
$player = $event->getPlayer ();
$name = $player->getName ();
if (isset ($this->shadow [$name])) {
$this->plugin->db ["player"] [$name] ["count"] = $this->shadow [$name];
}
}

public function handleJoin2 (\pocketmine\event\player\PlayerJoinEvent $event)
{
$player = $event->getPlayer ();
$name = $player->getName ();
if (isset ($this->plugin->db ["player"] [$name] ["count"])) {
$this->shadow [$name] = $this->plugin->db ["player"] [$name] ["count"];
}
}
	public function handlePassive (EntityDamageEvent $event)
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $entity->getName ())] ["ability"] === "그림자그림자") {
						$per = 0;
						if (!isset ($this->shadow [$name])) $this->shadow [$name] = 0;
						if ($this->shadow [$name] >= 80) {
							$per = 20;
						} else if ($this->shadow [$name] >= 150) {
							$per = 40;
						} else if ($this->shadow [$name] >= 200) {
							$per = 60;
						} else if ($this->shadow [$name] >= 250) {
							$per = 80;
						}
						$damage = $event->getBaseDamage () % 2;
						$damage = $damage * 1.2;
						$event->setBaseDamage ($damage);
					}
				}
			}
		}
	}
	
	public function handleSkill1 (EntityDamageEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					if ($this->plugin->db ["player"] [($name = $player->getName ())] ["ability"] === "그림자그림자") {
						$item = $player->getInventory ()->getItemInHand ();
						if ($item->getId () === 359) {
							if ($player->getLevel ()->getFolderName () === "world") {
								return;
							}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}
       if (CooldownTask::isCooldown ($name, $entity->getName ())) {
          $this->plugin->msg ($player, "해당 대상은 3분뒤에 다시 사용이 가능합니다.");
          return;
       }
							if (CooldownTask::isCooldown ($name, "그림자 자르기")) {
								$this->plugin->msg ($player, "[ §c그림자 자르기 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "그림자 자르기") . "초§7 남았습니다.");
								return;
							} else {
								CooldownTask::addCooldown ($name, "그림자 자르기", 20);
								CooldownTask::addCooldown ($entity->getName (), "이동 불가", 2);
        CooldownTask::addCooldown ($name, $entity->getName (), (60 * 3));
								$this->plugin->msg ($player, "[ §c그림자 자르기 §7] 스킬을 사용하셨습니다!");
								if (isset ($this->shadow [$name]))
									$this->shadow [$name] += 5;
								else
									$this->shadow [$name] = 0;
								if (!isset ($this->sec [$name] [$entity->getName ()])) {
									$this->sec [$name] [$entity->getName ()] = time ();
								}
							}
						}
					}
				}
			}
		}
	}
	
	public function onDeath (EntityDeathEvent $event): void
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if (($cause = $entity->getLastDamageCause ()) instanceof EntityDamageByEntityEvent) {
				if (($player = $cause->getDamager ()) instanceof Player) {
					if (isset ($this->sec [$player->getName ()] [$entity->getName ()])) {
						$nowTime = time ();
						$record = (int) ($nowTime - $this->sec [$player->getName ()] [$entity->getName ()]);
						$name = $player->getName ();
						if ($record <= 5) {
							$this->plugin->msg ($player, "§a" . $entity->getName () . "님§7을 5초안에 죽여서 그림자 5개를 더 획득했습니다.");
							if (isset ($this->shadow [$name]))
								$this->shadow [$name] += 5;
							else
								$this->shadow [$name] = 0;
						}
						unset ($this->sec [$player->getName ()] [$entity->getName ()]);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "그림자그림자") {
				if (CooldownTask::isCooldown ($name, "브릭배트")) {
					$this->plugin->msg ($player, "[ §c브릭배트 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "브릭배트") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "브릭배트", 8);
					$this->plugin->msg ($player, "[ §c브릭배트 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->shadowshadow2 ($player);
				}
			}
		}
	}
	
	public function handleSkill3 (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$item = $event->getItem ();
		if ($item->getId () === 378) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
if ($player->getLevel ()->getFolderName () === "island") {
return;
}

			if ($this->plugin->db ["player"] [$name] ["ability"] === "그림자그림자") {
				if (CooldownTask::isCooldown ($name, "계약")) {
					$this->plugin->msg ($player, "[ §c계약 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "계약") . "초§7 남았습니다.");
					return;
				} else {
				   if (!isset ($this->shadow [$name])) $this->shadow [$name] = 0;
					if ($this->shadow [$name] < 20) {
						$this->plugin->msg ($player, "그림자가 부족합니다.");
					} else {
						CooldownTask::addCooldown ($name, "계약", 15);
						$this->plugin->msg ($player, "[ §c계약 §7] 스킬을 사용하셨습니다!");
						$this->shadow [$name] -= 20;
						$skill = new Skill ();
						$skill->shadowshadow3 ($player);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "그림자그림자") {
				if (CooldownTask::isCooldown ($name, "쉐도우 아스가르드")) {
					$this->plugin->msg ($player, "[ §c쉐도우 아스가르드 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "쉐도우 아스가르드") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "쉐도우 아스가르드", 200);
					$this->plugin->msg ($player, "[ §c쉐도우 아스가르드 §7] 스킬을 사용하셨습니다!");
					$skill = new Skill ();
					$skill->shadowshadowend ($player);
     \pocketmine\Server::getInstance ()->broadcastMessage ("§c{$player->getName ()}님§7께서 §c그림자그림자 궁극기§7를 사용하셨습니다.");
				}
			}
		}
	}
}