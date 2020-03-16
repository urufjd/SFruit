<?php

declare(strict_types=1);

namespace SFruit\particle;

use pocketmine\math\Vector3;
use pocketmine\level\particle\{
   GenericParticle,
   Particle
};

class TParticle extends GenericParticle{
	public function __construct(Vector3 $pos, int $r, int $g, int $b, int $a = 255){
		parent::__construct($pos, Particle::TYPE_DUST, (($a & 0xff) << 24) | (($r & 0xff) << 16) | (($g & 0xff) << 8) | ($b & 0xff));
	}
}
