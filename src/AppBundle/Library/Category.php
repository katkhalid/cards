<?php

namespace AppBundle\Library;

class Category {
	const DIAMOND = 1;
	const HEART = 2;
	const SPADE = 3;
	const CLUB = 4;

	private $categories = [];

	public function __construct() {
		$this->categories[] = self::DIAMOND;
		$this->categories[] = self::HEART;
		$this->categories[] = self::SPADE;
		$this->categories[] = self::CLUB;
	}

	/**
	 * @return array
	 */
	public function getCategories() {
		return $this->categories;
	}
}