<?php

namespace AppBundle\Library;

class CardValue {

	const ACE = 1;
	const TWO = 2;
	const THREE = 3;
	const FOUR = 4;
	const FIVE = 5;
	const SIX = 6;
	const SEVEN = 7;
	const EIGHT = 8;
	const NINE = 9;
	const TEN = 10;
	const JACK = 11;
	const QUEEN = 12;
	const KING = 13;

	public static $cardValues = [
		'ACE' => self::ACE,
		'TWO' => self::TWO,
		'THREE' => self::THREE,
		'FOUR' => self::FOUR,
		'FIVE' => self::FIVE,
		'SIX' => self::SIX,
		'SEVEN' => self::SEVEN,
		'EIGHT' => self::EIGHT,
		'NINE' => self::NINE,
		'TEN' => self::TEN,
		'JACK' => self::JACK,
		'QUEEN' => self::QUEEN,
		'KING' => self::KING,
	];

	/**
	 * @param string $value
	 *
	 * @return integer
	 */
	public static function getIntCardValue($value) {
		return self::$cardValues[$value];
	}

	/**
	 * @param integer $value
	 *
	 * @return array
	 */
	public static function getStringCardValue($value) {
		return array_flip(self::$cardValues)[$value];
	}

	/**
	 * Inverser l'ordre des valeurs des cartes
	 *
	 * @param $inputArray
	 *
	 * @return array
	 */
	public static function rebaseCardValues($inputArray)
	{
		$cardValues = array_flip(self::$cardValues);

		$rebasedArray = [];

		foreach($inputArray as $value) {
			$rebasedArray[] = $cardValues[$value];
		}

		return $rebasedArray;
	}
}