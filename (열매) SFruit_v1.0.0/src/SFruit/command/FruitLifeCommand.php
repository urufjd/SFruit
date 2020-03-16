<?php

namespace SFruit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use name\uimanager\UIManager;
use name\uimanager\SimpleForm;
use name\uimanager\element\Button;

use SFruit\SFruit;
use SFruit\FruitExplanation;

class FruitLifeCommand extends Command
{
	
	protected $plugin = null;
	
	public function __construct (SFruit $plugin)
	{
		$this->plugin = $plugin;
		parent::__construct ("라이프", "라이프 명령어 입니다. || 아바스");
	}
	
	public function execute (CommandSender $player, string $label, array $args): bool
	{
		if (!$player->isOp ()) {
			$this->plugin->msg ($player, "당신은 이 명령어를 사용할 권한이 없습니다.");
			return true;
		}
		if (!isset ($args [0]) or !isset ($args [1]) or !is_numeric ($args [1])) {
			$this->plugin->msg ($player, "/라이프 (열매 이름) (라이프)");
			return true;
		}
		if (!isset ($this->plugin->db ["fruits"] [$args [0]])) {
			$this->plugin->msg ($player, "해당 열매는 존재하지 않습니다.");
			return true;
		}
		$this->plugin->db ["fruits"] [$args [0]] = $args [1];
		$this->plugin->msg ($player, "§a{$args [0]}§7 열매의 라이프를 §a{$args [1]}§7로 설정했습니다.");
		return true;
	}
}