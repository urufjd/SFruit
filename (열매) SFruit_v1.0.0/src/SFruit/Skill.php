<?php


namespace SFruit;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\Player;

use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\level\Explosion;

use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\Particle;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

use SFruit\tasks\CooldownTask;
use SFruit\tasks\HumanSpawnTask;


use pocketmine\entity\Entity;
use pocketmine\nbt\tag\CompoundTag;

use pocketmine\nbt\tag\StringTag;

use pocketmine\nbt\tag\ByteArrayTag;
use SJob\JobAPI;

class Skill
{
	
	public function eagleeagle1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new LavaParticle ($vec));
    $player->getLevel ()->addParticle (new FlameParticle ($vec));
				if ($player !== $players) {
					if ($players->distance ($vec) < 2) {
						$players->setOnFire (7);
						$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 3);
						$players->attack ($callEv);
					}
				}
			}
		}
	}
	
	public function eagleeagle2 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new HappyVillagerParticle ($vec));
				if ($player !== $players) {
					if ($players->distance ($vec) < 2) {
      $player->addEffect (new EffectInstance (Effect::getEffect (11), 20*3, 4));
						SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($players) extends \pocketmine\scheduler\Task{
							protected $player;
										
							public function __construct (Player $player)
							{
								$this->player = $player;
							}
							
							public function onRun (int $currentTick)
							{
								$pos = new Position ((int) $this->player->x, (int) $this->player->y, (int) $this->player->z, $this->player->level);
								$exp = new Explosion ($pos, 3);
								$exp->explodeB ();
								$this->player->setOnFire (6);
							}
						}, 50);
					}
				}
			}
		}
	}
	
	public function kowloonkowloon2 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<7; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 0, 216, 255));
				if ($player !== $players) {
					if ($players->distance ($vec) < 2) {
						$time = 4;
						
						CooldownTask::addCooldown ($players->getName (), "감전", $time);
						SFruit::getInstance ()->msg ($players, "당신은 §c쿠릉쿠릉 열매§7의 §c2억볼트 감전§7에 의해 §c감전 4초§7를 부여받았습니다!");
					}
				}
			}
		}
	}

public function part (Player $player)
{
    $pos = $player->add (0, 0.5);
    $player->level->addParticle (new DustParticle ($pos, 255, 255, 255));
 }
	
	public function bundlebundle1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<7; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 234, 234, 234));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 8);
					$players->attack ($callEv);
				}
			}
		}
	}
	
	public function bundlebundle2 (Player $player)
	{
		$dv = $player->getDirectionVector ()->multiply (10);
		$player->setMotion (new Vector3 ($dv->x, $dv->y, $dv->z));
		
		if (!$player->isCreative ()){
			$player->setAllowFlight (true);
			$player->setFlying (true);
		}
		
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
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
				SFruit::getInstance ()->msg ($this->player, "비행시간이 종료되었습니다.");
			}
		}, 25 * 7);
	}
	
	public function bundlebundle3 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<7; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 234, 234, 234));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$time = 7;
					if (CooldownTask::isCooldown ($players->getName (), "감전")) {
						$time += CooldownTask::getCooldown ($players->getName (), "감전");
					}
					CooldownTask::deleteCooldown ($players->getName (), "감전");
					CooldownTask::addCooldown ($players->getName (), "감전", $time);
					$players->addEffect (new EffectInstance (Effect::getEffect (20), 20*7, 2));
				}
			}
		}
	}
	
	public function gasgas1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<7; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 0, 221));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$time = 2;
					
					CooldownTask::addCooldown ($players->getName (), "기절", $time);
					$players->addEffect (new EffectInstance (Effect::getEffect (19), 20*5, 4));
				}
			}
		}
	}
	
	public function gasgas3 (Player $player)
	{
		foreach ($player->getLevel ()->getPlayers () as $players) {
			if ($player !== $players and $players->distance ($player) < 7) {
				$players->addEffect (new EffectInstance (Effect::getEffect (20), 20*3, 9));
			}
		}
	}
	
	public function lightpassive (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 228, 0));
				if ($player !== $players and $players->distance ($vec) < 2) {
      $player->addEffect (new EffectInstance (Effect::getEffect (11), 20*7, 9));
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 7);
					$players->attack ($callEv);
					$explosion = new Explosion ($players, 5);
					$explosion->explodeB ();
				}
				if (!$player->level->getBlock ($vec) instanceof \pocketmine\block\Air) {
				   $pos = new Position ($vec->x, $vec->y, $vec->z, $player->level);
					$explosion = new Explosion ($pos, 5);
					$explosion->explodeB ();
				}
			}
		}
	}
	
	public function lightlight1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 228, 0));
				if (!$player->level->getBlock ($vec) instanceof \pocketmine\block\Air) {
					$player->teleport ($vec->add (0, 0.5));
				}
			}
		}
	}
	
	public function lightlight2 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<5; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 228, 0));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$players->addEffect (new EffectInstance (Effect::getEffect (15), 20*10, 0));
				}
			}
		}
	}
	
	public function gun (int $distance, Player $player, Particle $particle, string $type = "없음")
	{
		SFruit::getInstance ()->getScheduler ()->scheduleRepeatingTask (new class ($distance, $player, $particle, $type) extends \pocketmine\scheduler\Task{
			protected $distance;
			protected $player;
			protected $particle;
   protected $type;
			
			public function __construct (int $distance, Player $player, Particle $particle, string $type) {
				$this->distance = $distance;
				$this->player = $player;
				$this->particle = $particle;
    $this->type = $type;
				$this->count = 0;
    $this->maxc = 0;
			}
			
			public function onRun (int $currentTick) {
				$this->count ++;
     if ($this->type === "빛빛") $this->maxc = 10;
     if ($this->type === "마그마그") $this->maxc = 4;
     if ($this->type === "실실") $this->maxc = 5;
				if ($this->count <= $this->maxc) {
					$player = $this->player;
     
               for ($i=1; $i<10; $i++) {
			         $x = - \sin ($player->yaw / 180 * M_PI);
			         $z = \cos ($player->yaw / 180 * M_PI);
			         $dir = $player->getDirectionVector ();
				   	foreach ($player->getLevel ()->getPlayers () as $players) {
                      $vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
            if ($this->type === "빛빛") {
				            $particle = new DustParticle ($vec, 255, 228, 0);
            } else if ($this->type === "마그마그") {
                $particle = new LavaParticle ($vec);
            } else if ($this->type === "실실") {
                $particle = new DustParticle ($vec, 255, 255, 255);
            }
						   $player->getLevel ()->addParticle ($particle);
              if ($this->type === "빛빛") {
                  //$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
                /*   $explosion = new Explosion ($players, 0.5);
					             $explosion->explodeB ();*/
                  if ($player !== $players) {
     $callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 7);
					            $players->attack ($callEv);
}
              } else if ($this->type === "마그마그") {
                if ($player !== $players) {
                  $callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 4);
					            $players->attack ($callEv);
					            $players->setOnFire (2);
                }
              } else if ($this->type === "실실") {
if ($player !== $players) {
                 $callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 6);
					            $players->attack ($callEv);
					            $players->setOnFire (4);
}
              }
				   	}
					}
				}
			}
		}, 19);
	}
	
	public function lightlight3 (Player $player)
	{
		for ($i=1; $i<10; $i++) {
			$x = - \sin ($player->yaw / 180 * M_PI);
			$z = \cos ($player->yaw / 180 * M_PI);
			$dir = $player->getDirectionVector ();
			foreach ($player->getLevel ()->getPlayers () as $players) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$particle = new DustParticle ($vec, 255, 228, 0);
				$this->gun ($i, $player, $particle, "빛빛");
				if ($player !== $players and $players->distance ($vec) < 2) {
					$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
			$explosion = new Explosion ($players, 3);
					$explosion->explodeB ();
				}
			}
		}
	}
	
	public function darkdark1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 25, 25, 25));
     $count = 0;
				if ($player !== $players and $players->distance ($vec) < 2) {
					$players->teleport ($player);
     $players->addEffect (new EffectInstance (Effect::getEffect (15), 20*5, 4));
     $count++;
						if($count >= 1){
							return true;
						}
				}
			}
		}
	}
	
	public function darkdark2 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 25, 25, 25));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 10);
					$players->attack ($callEv);
				}
			}
		}
	}
	
	public function darkdark3 (Player $player)
	{
		foreach ($player->level->getPlayers () as $players) {
			if ($player !== $players and $players->distance ($player) < 20) {
				CooldownTask::addCooldown ($players->getName (), "이동 불가", 4);
      $players->addEffect (new EffectInstance (Effect::getEffect (15), 20*7, 4));
			}
		}
	}
	
	public function magmag1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();

		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new LavaParticle ($vec));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 7);
					$players->attack ($callEv);
					$players->setOnFire (7);
				}
			}
		}
	}
	
	public function magmag2 (Player $player)
	{
	//	CooldownTask::addCooldown ($player->getName (), "이동 불가", 2.5);
      for ($i=1; $i<10; $i++) {
			$x = - \sin ($player->yaw / 180 * M_PI);
			$z = \cos ($player->yaw / 180 * M_PI);
			$dir = $player->getDirectionVector ();
			foreach ($player->getLevel ()->getPlayers () as $players) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$particle = new DustParticle ($vec, 255, 228, 0);
				$this->gun ($i, $player, $particle, "마그마그");
				/*if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 5);
					$players->attack ($callEv);
					$players->setOnFire (2);
				}*/
			}
		}
	}
	
	
	public function iceice2 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 212, 244, 250));
				if ($player !== $players and $players->distance ($vec) < 2) {
					CooldownTask::addCooldown ($players->getName (), "빙결", 3);
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 5);
					$players->attack ($callEv);
				}
			}
		}
	}
	
	public function iceice3 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 212, 244, 250));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 19);
					$players->attack ($callEv);
				}
			}
		}
	}
	
	public function iceice4 (Player $player)
	{
		foreach ($player->getLevel ()->getPlayers () as $players) {
			if ($player !== $players and $players->distance ($player) < 20) {
				CooldownTask::addCooldown ($players->getName (), "빙결", 5);
			}
		}
	}
	
	public function poisonpoison1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 0, 221));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$players->addEffect (new EffectInstance (Effect::getEffect (19), 20*10, 0));
				}
			}
		}
	}
	
	public function poisonpoison2 (Player $player)
	{
		foreach ($player->getLevel ()->getPlayers () as $players) {
			if ($player !== $players and $players->distance ($player) <= 7) {
				$players->addEffect (new EffectInstance (Effect::getEffect (19), 20*10, 0));
			}
		}
	}
	
	public function silsil1 (Player $player)
	{
  
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 255, 255));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 6);
					$players->attack ($callEv);
					$players->setOnFire (4);
				}
			}
		}
	}
	
	public function silsil2 (Player $player)
	{
		if (!$player->isCreative ()){
			$player->setAllowFlight (true);
			$player->setFlying (true);
		}
		
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
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
				SFruit::getInstance ()->msg ($this->player, "비행시간이 종료되었습니다.");
			}
		}, 25 * 4);
	}
	
	public function silsil3 (Player $player)
	{
		$task = new HumanSpawnTask ($player);
		$task->spawn ();
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask ($task, 1200);
	}
	
	public function silsilend (Player $player)
	{
		for ($i=1; $i<10; $i++) {
			$x = - \sin ($player->yaw / 180 * M_PI);
			$z = \cos ($player->yaw / 180 * M_PI);
			$dir = $player->getDirectionVector ();
			foreach ($player->getLevel ()->getPlayers () as $players) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$particle = new DustParticle ($vec, 255, 255, 255);
				$this->gun ($i, $player, $particle, "실실");
			}
		}
	}
	
	public function dongangdongang1 (Player $player)
	{
		if (!$player->isCreative ()){
			$player->setAllowFlight (true);
			$player->setFlying (true);
		}
		
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
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
				SFruit::getInstance ()->msg ($this->player, "비행시간이 종료되었습니다.");
			}
		}, 25 * 5);
	}
	
	public function shadowshadow2 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 25, 25, 25));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$players->addEffect (new EffectInstance (Effect::getEffect (15), 20*5, 0));
      $players->addEffect (new EffectInstance (Effect::getEffect (20), 20*5, 1));
				}
			}
		}
	}
	
	public function shadowshadow3 (Player $player)
	{
		$task = new HumanSpawnTask ($player);
		$task->spawn ();
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask ($task, 1200);
	}
	
	public function shadowshadowend (Player $player)
	{
		$player->setScale (3);
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
			protected $player;
			
			public function __construct (Player $player)
			{
				$this->player = $player;
			}
			
			public function onRun (int $currentTick)
			{
				$this->player->setScale (1);
			}
		}, 25 * 3);
	}
	
	public function slowslowend (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$particle = new DustParticle ($vec, 255, 228, 0);
				$player->getLevel ()->addParticle ($particle);
				if ($player !== $players and $players->distance ($vec) < 2) {
					$players->addEffect (new EffectInstance (Effect::getEffect (18), 20*30, 2));
					$players->addEffect (new EffectInstance (Effect::getEffect(2), 20*30, 2));
				}
			}
		}
	}
	
	public function dotomdotom1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new DustParticle ($vec, 255, 255, 255));
				if ($player !== $players and $players->distance ($vec) < 2) {
					$callEv = new EntityDamageByEntityEvent ($player, $players, EntityDamageEvent::CAUSE_MAGIC, 10);
					$players->attack ($callEv);
				}
			}
		}
	}
	public function getFrontalVector(Player $player): Vector3
    {
        $x = - \sin($player->yaw / 180 * M_PI);
        $y = - \sin($player->pitch / 180 * M_PI);
        $z = \cos($player->yaw / 180 * M_PI);
        $vector = new Vector3((float) $player->x + $x * 6, (float) $player->y + 2 * $y, (float) $player->z + 6 * $z);
        return $vector;
    }
	public function dotomdotom2 (Player $player)
	{
	//	$dv = $player->getDirectionVector ()->multiply (6);
		$fvector = $this->getFrontalVector ($player);
   $player->teleport ($fvector);
	}
	
	public function dotomdotomend (Player $player)
	{
		$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*5, 4));
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
			protected $player;
			
			public function __construct (Player $player)
			{
				$this->player = $player;
			}
			
			public function onRun (int $currentTick)
			{
				$explosion = new Explosion ($this->player, 3);
			$explosion->explodeB ();
			}
		}, 25 * 2);
	}
	
	public function bridbrid1 (Player $player)
	{
		if (!$player->isCreative ()){
			$player->setAllowFlight (true);
			$player->setFlying (true);
		}
		
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($player) extends \pocketmine\scheduler\Task{
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
				SFruit::getInstance ()->msg ($this->player, "비행시간이 종료되었습니다.");
			}
		}, 25 * 7);
	}
	
	public function doongsend (Player $player)
	{
		$radius = 3;
		for ($i=0; $i<50; $i++) {
			$s = $i * (2*M_PI/50);
			$x = $player->x + (cos ($s) * $radius);
			$z = $player->z + (sin ($s) * $radius);
			$pos = new Position ($x, $player->x + 2, $z, $player->level);
			$player->level->addParticle (new LavaParticle ($pos->asVector3 ()));
		}
		$pos = new Position ((int) $player->x, (int) $player->y + 55, (int) $player->z, $player->level);

		$nbt = Entity::createBaseNBT ($pos->asVector3 (), null, 0, 0);

		$nbt->setTag (new CompoundTag ("Skin", [

			new StringTag ("Name", $player->getSkin ()->getSkinId ()),

			new ByteArrayTag ("Data", $player->getSkin ()->getSkinData ()),

		]));
		$entity = Entity::createEntity ("OreHuman", $pos->level, $nbt);

		$entity->spawnToAll ();
		$player->addEffect (new EffectInstance (Effect::getEffect (11), 20*8, 5));
		SFruit::getInstance ()->getScheduler ()->scheduleDelayedTask (new class ($pos, $entity) extends \pocketmine\scheduler\Task{
			protected $pos;
			protected $entity;
			
			public function __construct (Position $pos, Entity $entity)
			{
				$this->pos = $pos;
				$this->entity = $entity;
			}
			
			public function onRun (int $currentTick)
			{
				$exp = new Explosion ($this->pos, 10);
				$exp->explodeB ();
			}
		}, 25 * 4);
	}
	
	public function soulsoul1 (Player $player)
	{
		$x = - \sin ($player->yaw / 180 * M_PI);
		$z = \cos ($player->yaw / 180 * M_PI);
		$dir = $player->getDirectionVector ();
		foreach ($player->getLevel ()->getPlayers () as $players) {
			for ($i=1; $i<10; $i++) {
				$vec = new Vector3 ($player->x + $i * $dir->x, $player->y + 2 + $i * $dir->y, $player->z + $i * $dir->z);
				$player->getLevel ()->addParticle (new LavaParticle ($vec));
				//$player->getLevel ()->addParticle (new FlameParticle ($vec));
				if ($player !== $players) {
					if ($players->distance ($vec) < 2) {
						$players->setOnFire (4);
					}
				}
			}
		}
	}
	
	public function soulsoul2 (Player $player, string $type = "폰") {
		if ($type == "루크") {
			$pos = new Position ((int) $player->x, (int) $player->y, (int) $player->z, $player->level);
			$nbt = Entity::createBaseNBT ($pos->asVector3 (), null, 0, 0);
			$nbt->setTag (new CompoundTag ("Skin", [
				new StringTag ("Name", $player->getSkin ()->getSkinId ()),
				new ByteArrayTag ("Data", $player->getSkin ()->getSkinData ()),
			]));
			$entity = Entity::createEntity ("Pomise", $pos->level, $nbt);
			$entity->setNameTag ("§c< {$player->getName ()}님§7의 루크 병사§c >");
			$entity->setHealth (25);
			$entity->owner = $player;
			$entity->spawnToAll ();
		} else if ($type === "폰") {
			$pos = new Position ((int) $player->x, (int) $player->y, (int) $player->z, $player->level);
			$nbt = Entity::createBaseNBT ($pos->asVector3 (), null, 0, 0);
			$nbt->setTag (new CompoundTag ("Skin", [
				new StringTag ("Name", $player->getSkin ()->getSkinId ()),
				new ByteArrayTag ("Data", $player->getSkin ()->getSkinData ()),
			]));
			$entity = Entity::createEntity ("Pomise", $pos->level, $nbt);
			$entity->setNameTag ("§c< {$player->getName ()}님§7의 폰 병사§c >");
			$entity->setHealth (50);
			$entity->owner = $player;
			$entity->spawnToAll ();
		}
	}
}