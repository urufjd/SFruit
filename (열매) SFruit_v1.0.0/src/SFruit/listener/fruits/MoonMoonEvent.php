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

class MoonMoonEvent extends FruitListener
{
	
	protected $plugin = null;
	
	public $position = [];
	

	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}

	public static function getEventId (): int
	{
		return 101;
	}
	
	public function handleSkill1 (PlayerInteractEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		$block = $event->getBlock ();
		$item = $event->getItem ();
		if ($item->getId () === 369) {
			if ($player->getLevel ()->getFolderName () === "world") {
				return;
			}
			if ($player->getLevel ()->getFolderName () === "island") {
				return;
			}
			if ($this->plugin->db ["player"] [$name] ["ability"] === "문문") {
				if (CooldownTask::isCooldown ($name, "마킹")) {
					$this->plugin->msg ($player, "[ §c마킹 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "마킹") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "마킹", 30);
					$this->plugin->msg ($player, "[ §c마킹 §7] 스킬을 사용하셨습니다!");
					$this->position [$player->getName ()] = new Position (floatval ($block->x), floatval ($block->y), floatval ($block->z), $block->level);
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
			if ($this->plugin->db ["player"] [$name] ["ability"] === "문문") {
				if (CooldownTask::isCooldown ($name, "에어도어")) {
					$this->plugin->msg ($player, "[ §c에어도어 §7] 스킬을 사용하실려면 §c" . CooldownTask::getCooldown ($name, "에어도어") . "초§7 남았습니다.");
					return;
				} else {
					CooldownTask::addCooldown ($name, "에어도어", 10);
					$this->plugin->msg ($player, "[ §c에어도어 §7] 스킬을 사용하셨습니다!");
					if (isset ($this->position [$player->getName ()])) {
						$pos = $this->position [$player->getName ()];
						if ($pos instanceof Position) {
							$player->teleport ($pos);
						}
					}
				}
			}
		}
	}
}