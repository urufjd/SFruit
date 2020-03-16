<?php


namespace SFruit\tasks;

use pocketmine\scheduler\Task;

class CooldownTask extends Task{
	
	public static $cooldown = [];
	
	
	public static function isCooldown (string $name, string $cooldown): bool
	{
		return isset (self::$cooldown [$name] [$cooldown]);
	}
	
	public static function getCooldown (string $name, string $cooldown): int
	{
		return (int) self::$cooldown [$name] [$cooldown];
	}
	
	public static function addCooldown (string $name, string $cooldown, int $time)
	{
		self::$cooldown [$name] [$cooldown] = $time;
	}
	
	public static function deleteCooldown (string $name, string $cooldown)
	{
		unset (self::$cooldown [$name] [$cooldown]);
	}
	
	public function onRun (int $currentTick)
	{
		foreach (self::$cooldown as $name => $val) {
			foreach (self::$cooldown [$name] as $skill => $time) {
				self::$cooldown [$name] [$skill] --;
				if (self::$cooldown [$name] [$skill] <= 0) {
					self::deleteCooldown ($name, $skill);
				}
			}
		}
	}
}