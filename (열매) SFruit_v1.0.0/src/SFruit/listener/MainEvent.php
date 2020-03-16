<?php


namespace SFruit\listener;

use pocketmine\event\player\{PlayerJoinEvent, PlayerDeathEvent};
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use SFruit\SFruit;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use SFruit\tasks\CooldownTask;
use pocketmine\event\player\PlayerInteractEvent;
use SFruit\FruitExplanation;
use pocketmine\Player;
use onebone\economyapi\EconomyAPI;
use GTraining\listener\AbilityEvent;
use SFruit\event\FruitDeathEvent;
use SFruit\event\FruitAttackEvent;
use pocketmine\entity\{ Effect, EffectInstance };


class MainEvent extends FruitListener
{
	
	protected $plugin = null;
	
	public $price = [
	   "신급" => 3200000,
	   "최상급" => 2400000,
	   "상급" => 1600000,
	   "중급" => 1000000,
	   "하급" => 400000
	];
	
	public $grade = [
	   "소울소울" => "신급",
	   "그림자그림자" => "신급",
	   "새새" => "최상급",
	   "실실" => "최상급",
	   "어둠어둠" => "최상급",
	   "빛빛" => "최상급",
	   "마그마그" => "최상급",
	   "얼음얼음" => "최상급",
	   "둥실둥실" => "최상급",
	   "흔들흔들" => "최상급",
	   "중력중력" => "최상급",
	   "쿠릉쿠릉" => "최상급",
    "소울소울" => "최상급",
    "코끼리코끼리" => "최상급",
	   "독독" => "상급",
		"비스킷비스킷" => "신급",
		"문문" => "최상급",
		"복사복사" => "하급",
	   "모아모아" => "상급",
	   "도톰도톰" => "상급",
	   "이글이글" => "상급",
	   "뭉개뭉개" => "상급",
	   "사람사람" => "상급",
	   "가스가스" => "상급",
	   "동강동강" => "중급",
	   "투명투명" => "중급",
	   "느릿느릿" => "하급"
	];
	
	public function register (): void
	{
		$this->plugin = $this->getPlugin ();
	}
	
	public static function getEventId (): int
	{
		return 0;
	}
	public function handleHit (EntityDamageEvent $event): void
	{
		$entity = $event->getEntity ();
		if ($event instanceof EntityDamageByEntityEvent) {
			if (($player = $event->getDamager ()) instanceof Player) {
				$power = $event->getBaseDamage ();
				$item = $player->getInventory ()->getItemInHand ();
				$sword = "";
				if (!is_null ($item->getNamedTagEntry ("sword"))) {
					$sword = $item->getNamedTagEntry ("sword")->getValue ();
				}
				$upgrade = 0;
				if (!is_null ($item->getNamedTagEntry ("upgrade"))) {
					$upgrade = $item->getNamedTagEntry ("upgrade")->getValue ();
				}
				$upgrade = is_numeric ($upgrade) ? (int) $upgrade : 0;
				$arr = [
					"흑도 요루" => 10,
					"초대 귀철" => 10,
					"모라쿠모기리" => 10,
					"화도일문자" => 7,
					"2대 귀철" => 7,
					"흑도 슈스이" => 7,
					"엔마" => 7,
					"아메노하바키리" => 7,
					"코가라시" => 7,
					"콘피라" => 7,
					"듀랜달" => 7,
					"프헤첼" => 7,
					"시라우오" => 7,
					"유바시리" => 5,
					"카슈" => 5,
					"야마오로시" => 5,
					"3대 귀철" => 3,
					"시구레" => 3,
					"낡은 해적검" => 1,
					"키코쿠" => 1,
					"버려진 해적검" => 1,
					"소울 솔리드" => 1
				];
				if (isset ($arr [$sword])) {
					$power += $arr [$sword];
				}
				$power += $upgrade * 0.2;
				$event->setBaseDamage ($power);
			}
		}
	}
	public function handleJoin (PlayerJoinEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		
		if (!isset ($this->plugin->db ["player"] [$name])) {
			$this->plugin->db ["player"] [$name] = [
				"ability" => "false"
			];
			$this->plugin->msg ($player, "당신의 열매 데이터를 생성했습니다.");
		} else {
     if ($this->plugin->db ["player"] [$name] ["ability"] === "false") {
         AbilityEvent::$attack [$name] = true;
      }
   }
		
	}
	
	public function getAllDebuffs (string $name): array
	{
		$arr = [];
		foreach ([
			"정신집중",
			"감전",
			"이동 불가",
			"빙결",
			"기절"
		] as $debuffs) {
			if (CooldownTask::isCooldown ($name, $debuffs)) {
				$arr [$debuffs] = CooldownTask::getCooldown ($name, $debuffs);
			}
		}
		return $arr;
	}
	
	public function handleMovement (PlayerMoveEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		
		$arr = $this->getAllDebuffs ($name);
		
		$buffs = [];
		foreach ($arr as $bname => $time) {
			$buffs [] = "§c{$bname}§f (§c{$time}초 남음..§f)";
		}
		
		if (count ($buffs) > 0) {
			$text = implode (", ", $buffs);
			
			$player->sendTip ("§l§c<<§f 현재 당신은 디버프를 받은 상태입니다. §c>>" . "\n" . "§r§f디버프 목록 - §c" . $text);
   $event->setCancelled (true);
		}
	}
	
	public function handleAttack (EntityDamageByEntityEvent $event): void
	{
		if (($player = $event->getDamager ()) instanceof Player) {
			$name = $player->getName ();
			$arr = $this->getAllDebuffs ($name);
			
			$buffs = [];
			foreach ($arr as $bname => $time) {
				$buffs [] = "§c{$bname}§f (§c{$time}초 남음..§f)";
			}
			
			if (count ($buffs) > 0) {
				$text = implode (", ", $buffs);
				
				$player->sendTip ("§l§c<<§f 현재 당신은 디버프를 받은 상태입니다. §c>>" . "\n" . "§r§f디버프 목록 - §c" . $text);
    $event->setCancelled (true);
			}
		}
	}
	public function handleCommand(PlayerCommandPreprocessEvent $event){
        $p = $event->getPlayer();
        $name = $p->getName ();
        if(CooldownTask::isCooldown ($name, "정신집중")) {
            if($p->isOP()) return true;
            if(stripos($event->getMessage(),"/")===0){
                $p->sendMessage("현재 정신집중 상태 입니다.");
                $event->setCancelled(true);
            }
        }
	}
	public function handleReceive (DataPacketReceiveEvent $event): void
	{
		if (($packet = $event->getPacket ()) instanceof ModalFormResponsePacket) {
			$player = $event->getPlayer ();
			$res = json_decode ($packet->formData);
			if ($packet->formId === 101011) {
				if (is_null ($res)) return;
				
				$arr = [];
				$index = 0;
				$explanation = new FruitExplanation ();
				foreach ($explanation->getFruits () as $fruit) {
					$arr [$index ++] = $fruit;
				}
				if (isset ($arr [$res])) {
				   if ($this->plugin->db ["player"] [$player->getName ()] ["ability"] !== "false") {
        $this->plugin->msg ($player, "당신은 이미 다른 열매를 드셨습니다.");
        return;
     }
					if ($this->plugin->db ["fruits"] [$arr [$res]] !== "false") {
						$this->plugin->msg ($player, "이미 해당 열매는 주인이 있습니다.");
						return;
					} else {
						$grade = $this->grade [$arr [$res]];
						$price = $this->price [$grade];
						if (EconomyAPI::getInstance ()->myMoney ($player) > $price){
							EconomyAPI::getInstance ()->reduceMoney ($player, $price);
							$this->plugin->msg ($player, "해당 열매를 구매하셨습니다.");
       $this->plugin->getServer ()->broadcastMessage ("§a{$arr [$res]}§7 열매를 §a{$player->getName ()}§7님께서 복용했습니다.");
\pocketmine\utils\Internet::postURL ("https://openapi.band.us/v2.2/band/post/create?access_token=ZQAAAWmw8BXAJdoBX-bFTx7BjiYSkqdtk0bix4exbLRBCndazHMYerG7TfN2iKAZLeq42ZMn9noZak8mXReyuwuR5Uxj_eUYYZNygorKaArpNYMp", [
			"band_key" => "AABykC2gaYOf8_GFk4miGBxg",
			"content" => "< 바이온라인 열매 섭취 >\n\n{$player->getName ()} 님께서 {$arr [$res]} 열매를 섭취하셨습니다."
		]);
							$this->plugin->db ["fruits"] [$arr [$res]] = 3;
							$this->plugin->db ["player"] [$player->getName ()] ["ability"] = $arr [$res];
						} else {
							$this->plugin->msg ($player, "돈이 부족합니다.");
						}
					}
				}
			}
		}
	}
  public function handleDeath (PlayerDeathEvent $event)
  {
    $player = $event->getPlayer ();

    if (($ability = $this->plugin->db ["player"] [($name = $player->getName ())] ["ability"]) !== "false") {
        $callEv = new FruitDeathEvent ($player, $ability);
        $callEv->call ();
    }
  }

	public function onAttack (EntityDamageEvent $event)
	{
		if (($entity = $event->getEntity ()) instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				if (($player = $event->getDamager ()) instanceof Player) {
					$pname = $player->getName ();
					$ename = $entity->getName ();
					$myFruit = $this->plugin->db ["player"] [$pname] ["ability"];
					$targetFruit = $this->plugin->db ["player"] [$ename] ["ability"];
					$natureFruit = [ "이글이글", "쿠릉쿠릉", "뭉개뭉개", "가스가스",

			"빛빛", "마그마그", "얼음얼음"
		];
		
		if (!in_array ($myFruit, $natureFruit)) {
			if ($targetFruit === "false" or in_array ($targetFruit, $natureFruit)) {
				if (!isset (AbilityEvent::$attack [$player->getName ()])) {
					$event->setCancelled ();
				}
			}
		}
					
				}
			}
		}
	}
	
	public function onFruitAttack (FruitAttackEvent $event)
	{
		$player = $event->getPlayer ();
		$myFruit = $event->getMyFruit ();
		$targetFruit = $event->getTargetFruit ();
		
		$natureFruit = [ "이글이글", "쿠릉쿠릉", "뭉개뭉개", "가스가스",

			"빛빛", "마그마그", "얼음얼음"
		];
		if ($myFruit === "false" and $targetFruit === "false") return;
		if (!in_array ($myFruit, $natureFruit)) {
			if ($targetFruit === "false" or in_array ($targetFruit, $natureFruit)) {
				if (!isset (AbilityEvent::$attack [$player->getName ()])) {
					$event->setCancelled ();
				}
			}
		}
	}

    public function onFruitDeath (FruitDeathEvent $event)
    {
        $player = $event->getPlayer ();
        $fruit = $event->getFruit ();
        $name = $player->getName ();
        if ($event->isCancelled ()) return;
        if ($this->plugin->db ["player"] [$name] !== "false") {
            $this->plugin->db ["fruits"] [$fruit] --;
            if ($this->plugin->db ["fruits"] [$fruit] <= 0) {
                $this->plugin->db ["player"] [$name] ["ability"] = "false";
                $this->plugin->getServer ()->broadcastMessage ("§a >> {$fruit}§7 열매 복용자 §a{$name}§7 님께서 힘을 잃었습니다.");
                $this->plugin->getServer ()->broadcastMessage ("§a>> {$fruit}§7 열매는 §a60초 후§7 부활됩니다.");
               \pocketmine\utils\Internet::postURL ("https://openapi.band.us/v2.2/band/post/create?access_token=ZQAAAWmw8BXAJdoBX-bFTx7BjiYSkqdtk0bix4exbLRBCndazHMYerG7TfN2iKAZLeq42ZMn9noZak8mXReyuwuR5Uxj_eUYYZNygorKaArpNYMp", [
			"band_key" => "AABykC2gaYOf8_GFk4miGBxg",
			"content" => "< 바이온라인 열매 복용자 사망 >\n\n{$name} 님께서 {$fruit} 열매의 힘을 잃었습니다."
		]);
                $this->plugin->getScheduler ()->scheduleDelayedTask (new class ($this->plugin, $fruit) extends \pocketmine\scheduler\Task{
                    protected $plugin;
                    protected $ability;

                    public function __construct (SFruit $plugin, string $ability) {
                        $this->plugin = $plugin;
                        $this->ability = $ability;
                    }

                    public function onRun (int $currentTick)
                    {
                        $this->plugin->db ["fruits"] [$this->ability] = "false";
                        $this->plugin->getServer ()->broadcastMessage ("§e>>§a {$this->ability}§7 열매가 §a부활§7 했습니다.");
                    }
                }, 25 * 60);
            } else {
                $this->plugin->getServer ()->broadcastMessage ("§a >> {$fruit}§7 열매 복용자 §a{$name}§7 님께서 사망하셨습니다. 남은 라이프 : §a" . $this->plugin->db ["fruits"] [$fruit] . "§7 남았습니다.");
            }
        }
    }
    public function onInTouch (PlayerInteractEvent $event)
    {
        $player = $event->getPlayer ();
        $name = $player->getName ();
        $item = $event->getItem ();
        if ($this->plugin->db ["player"] [$name] ["ability"] !== "false") {
            if ($player->level->getFolderName () === "world" or $player->level->getFolderName () === "island") {
                $arr = [ 369, 377, 378, 437 ];
                if (in_array ($item->getId (), $arr)) $player->sendPopup ("§c<§f 여기서는 스킬 못쓴다. §c>");
            } else {
if ($this->plugin->db ["player"] [$name] ["ability"] === "빛빛" and $item->getId () === 378) {
              $player->addEffect (new EffectInstance (Effect::getEffect (11), 20*2, 4));
}
}
        }
    }
}