<?php


namespace SFruit\listener;

use SFruit\SFruit;

use pocketmine\Server;

use pocketmine\event\Listener;

use SFruit\listener\fruits\EagleEagleEvent;
use SFruit\listener\fruits\KowloonKowloonEvent;
use SFruit\listener\fruits\BundleBundleEvent;
use SFruit\listener\fruits\GasGasEvent;
use SFruit\listener\fruits\LightLightEvent;
use SFruit\listener\fruits\DarkDarkEvent;
use SFruit\listener\fruits\MagMagEvent;
use SFruit\listener\fruits\IceIceEvent;

use SFruit\listener\fruits\PoisonPoisonEvent;
use SFruit\listener\fruits\SilSilEvent;
use SFruit\listener\fruits\DongangDongangEvent;
use SFruit\listener\fruits\ShadowShadowEvent;
use SFruit\listener\fruits\SlowSlowEvent;
use SFruit\listener\fruits\TParentTParentEvent;
use SFruit\listener\fruits\DoongSDoongSEvent;
use SFruit\listener\fruits\HdleHdleEvent;
use SFruit\listener\fruits\MoaMoaEvent;
use SFruit\listener\fruits\DoTomDoTomEvent;
use SFruit\listener\fruits\SoulSoulEvent;
use SFruit\listener\fruits\JRJREvent;

use SFruit\listener\fruits\MoonMoonEvent;
use SFruit\listener\fruits\BskitBskitEvent;
use SFruit\listener\fruits\CopyCopyEvent;

use SFruit\listener\fruits\BridBridEvent;
use SFruit\listener\fruits\HumanHumanEvent;
use SFruit\listener\fruits\EleEleEvent;

abstract class FruitListener implements Listener
{
	
	/** @var null|SFruit */
	private static $plugin = null;
	
	/** @var array */
	public static $events = [];
	
	
	public static function init (SFruit $plugin): void
	{
		self::$plugin = $plugin;
		
		/* 자연계 */
		self::$events [MainEvent::getEventId ()] = new MainEvent ();
		self::$events [EagleEagleEvent::getEventId ()] = new EagleEagleEvent (); //이글이글
		self::$events [KowloonKowloonEvent::getEventId ()] = new KowloonKowloonEvent (); //쿠릉쿠릉
		self::$events [BundleBundleEvent::getEventId ()] = new BundleBundleEvent (); //뭉개뭉개
		self::$events [GasGasEvent::getEventId ()] = new GasGasEvent (); //가스가스
		self::$events [LightLightEvent::getEventId ()] = new LightLightEvent (); //빛빛
		self::$events [DarkDarkEvent::getEventId ()] = new DarkDarkEvent (); //어둠어둠
		self::$events [MagMagEvent::getEventId ()] = new MagMagEvent (); //마그마그
		self::$events [IceIceEvent::getEventId ()] = new IceIceEvent (); //얼음얼음
		
		/* 초인계 */
		self::$events [PoisonPoisonEvent::getEventId ()] = new PoisonPoisonEvent (); //독독
		self::$events [SilSilEvent::getEventId ()] = new SilSilEvent (); //실실
		self::$events [DongangDongangEvent::getEventId ()] = new DongangDongangEvent (); //동강동강
		self::$events [ShadowShadowEvent::getEventId ()] = new ShadowShadowEvent (); //그림그그림자
		self::$events [SlowSlowEvent::getEventId ()] = new SlowSlowEvent (); //느릿느릿
		self::$events [TParentTParentEvent::getEventId ()] = new TParentTParentEvent (); //투명투명
		self::$events [DoongSDoongSEvent::getEventId ()] = new DoongSDoongSEvent (); //둥실둥실
		self::$events [HdleHdleEvent::getEventId ()] = new HdleHdleEvent (); //흔들흔들
		self::$events [MoaMoaEvent::getEventId ()] = new MoaMoaEvent (); //모아모아
		self::$events [DoTomDoTomEvent::getEventId ()] = new DoTomDoTomEvent (); //도톰도톰
		self::$events [SoulSoulEvent::getEventId  ()] = new SoulSoulEvent (); //소울소울
		self::$events [JRJREvent::getEventId ()] = new JRJREvent (); //중력중력
 self::$events [MoonMoonEvent::getEventId ()] = new MoonMoonEvent (); //문문
  self::$events [CopyCopyEvent::getEventId ()] = new CopyCopyEvent (); //복사복사
   self::$events [BskitBskitEvent::getEventId ()] = new BskitBskitEvent (); //비스킷비스킷

		
		/* 동물계 */
		self::$events [BridBridEvent::getEventId ()] = new BridBridEvent (); //새새
		self::$events [HumanHumanEvent::getEventId ()] = new HumanHumanEvent (); //사람사람
		
		
		foreach (self::$events as $key => $class) {
			if ($class instanceof Listener) {
				$plugin->getServer ()->getPluginManager ()->registerEvents ($class, $plugin);
				$class->register ();
			}
		}
	}

	abstract public static function getEventId (): int;
	
	public static function getPlugin (): SFruit
	{
		return self::$plugin;
	}
}