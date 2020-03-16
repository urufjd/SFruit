<?php

namespace SFruit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use name\uimanager\UIManager;
use name\uimanager\SimpleForm;
use name\uimanager\element\Button;

use SFruit\SFruit;
use SFruit\FruitExplanation;

class FruitCommand extends Command
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
    "코끼리코끼리" => "최상급",
    "소울소울" => "신급",
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
	
	public function __construct (SFruit $plugin)
	{
		$this->plugin = $plugin;
		parent::__construct ("열매", "열매 명령어 입니다. || 아바스");
	}
	
	public function execute (CommandSender $player, string $label, array $args): bool
	{
   if (\SJob\JobAPI::getMainJob ($player->getName ()) === "시민"){
     $player->addTitle ("시민은 열매 선택이\n불가능 합니다.");
     return true;
   }
		$handle = new SimpleForm ("바이온라인 열매", "열매를 구매해보세요");
		
		$explanation = new FruitExplanation ();
		
		foreach ($explanation->getFruits () as $fruit) {
  $grade = $this->grade [$fruit];
  $price = $this->price [$grade];
   $owner = $this->plugin->getOwner ($fruit);
			$handle->addButton (new Button ("- {$fruit} 열매 구매\n가격 : {$price}베리 | {$owner}"));
		}
		
		UIManager::getInstance ()->sendUI ($player, $handle, 101011);
		return true;
	}
}