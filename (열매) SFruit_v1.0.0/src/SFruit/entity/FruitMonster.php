<?php

namespace SFruit\entity;

use pocketmine\level\Position;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\entity\Human;

use SJob\JobAPI;

abstract class FruitMonster extends Human
{
	
	public $target = null;
	public $sec = 0;
	public $target_find_radius = 6;
	
	protected $speed_factor = null;
	
	protected $follow_range_sq = 1.2;
	
	protected $jumpTicks = 0;
	
	protected $attack_queue = 0;
	
	
	public function getPlayersInRadius (Position $pos, int $radius)
	{
		$res = [];
		
		foreach ($pos->level->getPlayers () as $player) {
			if ($pos->distance ($player) <= $radius and JobAPI::getSubJob ($player->getName ()) !== $this->getJob ()) {
				$res [] = $player;
			}
		}
		return $res;
	}
	
	public function initEntity (): void
	{
		parent::initEntity ();
	}
	
    final public function onUpdate(int $currentTick): bool
    {
        $this->sec ++;
        if ($this->sec >= 600) $this->kill ();
        if ($this->attack_queue > 0)
            $this->attack_queue --;

        if ($this->target == null) {
            $players = $this->getPlayersInRadius($this, $this->target_find_radius);
            $distance = 100;
            foreach ($players as $player) {
                if ($distance > $this->distance($player)) {
                    $distance = $this->distance($player);
                    $this->target = $player;
                }
            }
        }

        if ($this->target !== null and ! $this->closed and $this->target instanceof Player) {
            if ($this->level instanceof Level and $this->target->level instanceof Level) {
                if ($this->level->getFolderName() == $this->target->level->getFolderName()) {
                    if ($this->target instanceof Vector3 and $this instanceof Vector3) {
                        if ($this->target->distance($this) > 32) {
                            $this->target = null;
                        }
                    } else {
                        $this->target = null;
                    }
                    if ($this->target instanceof Vector3 and $this instanceof Vector3) {
                        if ($this->target !== null) {
                            if ($this->target->distance($this) > 6) {
                                $this->jump();
                            }
                        }
                    } else {
                        $this->target = null;
                    }
                    if ($this->isUnderwater()) {
                        if ($this->target !== null)
                            $this->followBySwim($this->target);
                        else
                            $this->followBySwim($this->owner);
                    } else {
                        if ($this->isCollidedHorizontally && $this->jumpTicks === 0) {
                            $this->jump();
                        }
                        if ($this->target !== null)
                            $this->followByWalking($this->target);
                        else $this->followByWalking ($this->owner);
                    }
                    if ($this->attack_queue == 0) {
                        if ($this->target instanceof Vector3 and $this instanceof Vector3) {
                            if ($this->distance($this->target) < 1.2) {
                                $this->attack_queue = 15;
                                if ($this->target !== null)
                                    $this->attackTarget($this->target, $this, EntityDamageByEntityEvent::CAUSE_ENTITY_ATTACK, 5);
                            }
                        } else {
                            $this->target = null;
                        }
                    }

                    parent::onUpdate($currentTick);
                    return true;
                } else {
                    $this->target = null;
                }
            } else {

                $this->target = null;
            }
        }
        return false;
    }

    public function attackTarget(Player $target, Entity $damager, int $cause, int $damage): void
    {
        $target->attack(new EntityDamageByEntityEvent($damager, $target, $cause, $damage));
    }

    public function jump(): void
    {
        parent::jump();
    }
public function followBySwim(Entity $target, float $xOffset = 0.0, float $yOffset = 0.0, float $zOffset = 0.0): void
    {
        if ($target !== null) {
            $x = $target->x + $xOffset - $this->x;
            $y = $target->y + $yOffset - $this->y;
            $z = $target->z + $zOffset - $this->z;
            $xz_sq = $x * $x + $z * $z;
            $xz_modulus = sqrt($xz_sq);
            if ($xz_sq < $this->follow_range_sq) {
                $this->motion->x = 0;
                $this->motion->z = 0;
            } else {
                $speed_factor = $this->speed_factor;
                $this->motion->x = $speed_factor * ($x / $xz_modulus);
                $this->motion->z = $speed_factor * ($z / $xz_modulus);
            }

            if ($y !== 0.0) {
                $this->motion->y = 0.1 * $y;
            }

            $this->yaw = rad2deg(atan2(- $x, $z));
            $this->pitch = rad2deg(- atan2($y, $xz_modulus));

            $this->move($this->motion->x, $this->motion->y, $this->motion->z);
        }
    }
    public function followByWalking(Entity $target, float $xOffset = 0.0, float $yOffset = 0.0, float $zOffset = 0.0): void
    {
        if ($target !== null) {
            $x = $target->x + $xOffset - $this->x;
            $y = $target->y + $yOffset - $this->y;
            $z = $target->z + $zOffset - $this->z;
            $xz_sq = $x * $x + $z * $z;
            $xz_modulus = sqrt($xz_sq);
            if ($xz_sq < $this->follow_range_sq) {
                $this->motion->x = 0;
                $this->motion->z = 0;
            } else {

                $speed_factor = $this->speed_factor;
                $this->motion->x = $speed_factor * ($x / $xz_modulus);
                $this->motion->z = $speed_factor * ($z / $xz_modulus);
            }
            $this->yaw = rad2deg(atan2(- $x, $z));
            $this->pitch = rad2deg(- atan2($y, $xz_modulus));
            $this->move($this->motion->x, $this->motion->y, $this->motion->z);
        }
    }
}