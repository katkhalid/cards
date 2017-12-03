<?php

namespace AppBundle\Library;

use Symfony\Component\Config\Definition\Exception\Exception;

class Holder {

	const MAX_CARDS = 10;

	private $cards = [];

	private $ordredCategories = [];
	private $ordredValues = [];

	private $groupedCategories = [];
	private $groupedValues = [];

	public function __construct(Array $cards) {

		if(count($cards) != self::MAX_CARDS)
			throw new Exception('Validation failed: Accepts only 10 cards!');

		foreach($cards as $card)
		{
			$this->cards[] = new Card($card->category, $card->value);
		}
	}

	/**
	 * sort cards
	 */
	public function sortCards() {
		$groupedCategoriesRank = [];

		// Recuperer les categories et les valeurs des cartes
		foreach($this->cards as $card) {

			// Recuperer les categories des cartes, et les valeurs de chaque categorie
			$this->groupedCategories[$card->getCategory()][] = CardValue::getIntCardValue($card->getValue());

			// Recuperer les valeurs des cartes (Eliminer les valeurs dupliquées)
			$this->groupedValues[$card->getValue()] = CardValue::getIntCardValue($card->getValue());
		}


		// Trier les valeurs des cartes
		sort($this->groupedValues);

		// Inverser l'ordre des valeurs des cartes
		$this->ordredValues = CardValue::rebaseCardValues($this->groupedValues);

		// Trier chaque tableau de valeurs pour chaque categorie de carte
		foreach($this->groupedCategories as $categoryName => $categoryArrayValues) {
			rsort($this->groupedCategories[$categoryName]);
		}

		$newCategories = [];

		// Calcul des ranks de chaque categorie de carte
		foreach($this->groupedCategories as $categoryName1 => $categoryArrayValues1) {
			$ranks = [];
			foreach($this->groupedCategories as $categoryName2 => $categoryArrayValues2) {
				if($categoryName1 != $categoryName2) {
					$newCategories[ $categoryName1 ][ $categoryName2 ] = $this->getArrayRank( $categoryArrayValues1, $categoryArrayValues2 );
					$ranks[]                                           = $newCategories[ $categoryName1 ][ $categoryName2 ];
				}
			}
			$groupedCategoriesRank[$categoryName1] = max($ranks);
		}

		// Trier les categories des cartes par rank
		arsort($groupedCategoriesRank);
		$this->ordredCategories = array_keys($groupedCategoriesRank);
	}

	/**
	 * Calculer le Rank d'une carte
	 *
	 * @param $array1
	 * @param $array2
	 * @param int $index
	 * @param int $rank
	 *
	 * @return int
	 */
	public function getArrayRank($array1, $array2, $index = 0, $rank = 0) {

		if(!empty($array1[$index]) && !empty($array2[$index]) &&  $array1[$index] == $array2[$index]) {
			return $this->getArrayRank($array1, $array2, $index + 1, $rank + $array2[$index]);
		} else if(!empty($array1[$index]) && !empty($array2[$index]) &&  $array1[$index] > $array2[$index]){
			return $array1[$index] + $rank;
		}

		return $rank;
	}

	/**
	 * Recuper les cartes
	 * @return array
	 */
	public function getCards() {
		return $this->cards;
	}

	/**
	 * @param array $cards
	 */
	public function setCards( $cards ) {
		$this->cards = $cards;
	}

	/**
	 * @return array
	 */
	public function getOrdredCategories() {
		return $this->ordredCategories;
	}

	/**
	 * @param array $ordredCategories
	 */
	public function setOrdredCategories( $ordredCategories ) {
		$this->ordredCategories = $ordredCategories;
	}

	/**
	 * @return array
	 */
	public function getOrdredValues() {
		return $this->ordredValues;
	}

	/**
	 * @param array $ordredValues
	 */
	public function setOrdredValues( $ordredValues ) {
		$this->ordredValues = $ordredValues;
	}

}