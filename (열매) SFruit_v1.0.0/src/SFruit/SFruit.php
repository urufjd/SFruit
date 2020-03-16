<?php


namespace SFruit;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use SFruit\listener\FruitListener;

use SFruit\tasks\CooldownTask;

use SFruit\entity\{FruitHuman, FruitMonster, OreHuman, Pomise, Bskit};
use SFruit\command\FruitCommand;
use SFruit\command\FruitLifeCommand;

use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\entity\Skin;

use pocketmine\Player;

use pocketmine\entity\Entity;

class SFruit extends PluginBase
{
	
	private static $instance = null;
	
	private $prefix = "§l§c(§f열매§c)§r§7 ";
	
	public $config, $db;
	
	
	public static function getInstance (): SFruit
	{
		return self::$instance;
	}
	
	public function onLoad (): void
	{
		if (self::$instance === null) {
			self::$instance = $this;
		}
		if (!file_exists ($this->getDataFolder ())) {
			@mkdir ($this->getDataFolder ());
		}
		$fruit = new FruitExplanation ();
		$this->config = new Config ($this->getDataFolder () . "config,yml", Config::YAML, [
			"fruits" => [],
			"player" => []
		]);
		$this->db = $this->config->getAll ();
		foreach ($fruit->getFruits () as $fname) {

     if (!isset ($this->db ["fruits"] [$fname]))
			$this->db ["fruits"] [$fname] = "false";
if ($this->db ["fruits"] [$fname] === 0) $this->db ["fruits"] [$fname] = "false";
		}
		\pocketmine\entity\Entity::registerEntity (FruitHuman::class, true);
		\pocketmine\entity\Entity::registerEntity (OreHuman::class, true);
		\pocketmine\entity\Entity::registerEntity (Pomise::class, true);
		\pocketmine\entity\Entity::registerEntity (Bskit::class, true);
   $this->bannedFruit ();
	}
	
	public function onEnable (): void
	{
		

		FruitListener::init ($this); //모든 이벤트를 inti안으로 넣음
		
		$this->getScheduler ()->scheduleRepeatingTask (new CooldownTask (), 25);
		$this->getServer ()->getCommandMap ()->register ("avas", new FruitCommand ($this));
  $this->getServer ()->getCommandMap ()->register ("avas", new FruitLifeCommand ($this));
	}
	
	public function onDisable (): void
	{
   //$this->bannedFruit ();
		if ($this->config instanceof Config) {
			$this->config->setAll ($this->db);
			$this->config->save ();
		}
  
	}

public function bannedFruit (): void
{
    $fruit = [];
    $banned = [];
    foreach ($this->getServer ()->getNameBans ()->getEntries () as $player) {
        $banned [strtolower ($player->getName ())] = true;
    }
    $explan = new FruitExplanation ();
    foreach ($explan->getFruits () as $fname) {
        if (($owner = $this->getOwnerFormat ($fname)) !== "복용자 없음") {
            if (isset ($banned [strtolower ($owner)])) {
                $this->db ["fruits"] [$fname] = "false";
                $this->db ["player"] [$owner] ["ability"] = "false";
                $fruit [] = $fname;
            }
        }
    }
if (count ($fruit) > 0) {
    $list = implode (", ", $fruit);
    \pocketmine\utils\Internet::postURL ("https://openapi.band.us/v2.2/band/post/create?access_token=ZQAAAWmw8BXAJdoBX-bFTx7BjiYSkqdtk0bix4exbLRBCndazHMYerG7TfN2iKAZLeq42ZMn9noZak8mXReyuwuR5Uxj_eUYYZNygorKaArpNYMp", [
			"band_key" => "AABykC2gaYOf8_GFk4miGBxg",
			"content" => "< 바이온라인 열매 사망 >\n\n{$list} 열매의 복용자가 밴이 되어 열매힘을 잃었습니다."
		]);
}
}

public function getOwner (string $fruit): string
{
    if ($this->db ["fruits"] [$fruit] !== "false") {
        foreach ($this->db ["player"] as $name => $bool) {
            if ($this->db ["player"] [$name] ["ability"] === $fruit) {
                return "§2{$name}§7 님";
            }
        }
    }
    return "복용자 없음";
}

public function getOwnerFormat (string $fruit): string
{
    if ($this->db ["fruits"] [$fruit] !== "false") {
        foreach ($this->db ["player"] as $name => $bool) {
            if ($this->db ["player"] [$name] ["ability"] === $fruit) {
                return $name;
            }
        }
    }
    return "복용자 없음";
}
	
	public function msg ($player, string $msg): void
	{
		$player->sendMessage ($this->prefix . $msg);
	}
	
	public function isHead (string $name)
	{
	   return CooldownTask::isCooldown ($nmae, "정신집중");
	}
	
	public function getNBT (Player $player, string $type)
	{
		$path = $this->getDataFolder() . "{$type}.png";
		$img = @imagecreatefrompng($path);
		$skinbytes = "";
        $s = (int)@getimagesize($path)[1];
        for($y = 0; $y < $s; $y++){
            for($x = 0; $x < 64; $x++){
                $colorat = @imagecolorat($img, $x, $y);
                $a = ((~((int)($colorat >> 24))) << 1) & 0xff;
                $r = ($colorat >> 16) & 0xff;
                $g = ($colorat >> 8) & 0xff;
                $b = $colorat & 0xff;
                $skinbytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($img);
        $skin = new Skin($player->getSkin()->getSkinId(), $skinbytes, "", "geometry.{$type}", file_get_contents($this->getDataFolder() . "{$type}.json"));
        $nbt = Entity::createBaseNBT ($player->asVector3 (), null, 0, 0);

        $nbt->setTag (new CompoundTag ("Skin", [
        	new StringTag ("Name", $skin->getSkinId ()),
        	new ByteArrayTag ("Data", $skin->getSkinData ()),
			new ByteArrayTag ("CapeData", $skin->getCapeData ()),
			new StringTag ("GeomertyName", $skin->getGeometryName ()),
			new ByteArrayTag ("GeometryData", $skin->getGeometryData())
		]));
		return $nbt;
	}
}