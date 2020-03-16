<?php


namespace SFruit;


class FruitExplanation
{
	
	private $fruitList = [
		"이글이글",
		"쿠릉쿠릉",
		"뭉개뭉개",
		"가스가스",
		"빛빛",
		"어둠어둠",
		"마그마그",
		"얼음얼음", //0~7 (자연계)
		"독독",
		"실실",
		"동강동강",
		"그림자그림자",
		"느릿느릿",
		"투명투명",
		"둥실둥실",
		"흔들흔들",
		"모아모아",
		"도톰도톰",
		"비스킷비스킷",
		"문문",
		"복사복사",
		"소울소울",
		"중력중력", //8~19 (초인계)
		"새새",
		"사람사람",
		//"코끼리코끼리" //20~22 (동물계)
	];
	
	public function isFruit (string $name): bool
	{
		return isset ($this->fruitList [$name]);
	}
	
	public function getTypeString (int $key): string
	{
		if ($key >= 0 and $key <= 7) {
			return "자연계";
		} else if ($key >= 8 and $key <= 19) {
			return "초인계";
		} else if ($key >= 20 and $key <= 22) {
			return "동물계";
		}
		return "Unkown";
	}
	
	public function getFruitType (string $name): string
	{
		foreach ($this->fruitList as $key => $fruit) {
			if ($fruit === $name) {
				return $this->getTypeString ($key);
			}
		}
	}
	
	public function getFruits (): array
	{
		return (array) $this->fruitList;
	}
}