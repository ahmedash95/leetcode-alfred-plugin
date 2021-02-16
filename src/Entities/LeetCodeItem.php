<?php

namespace App\Entities;

class LeetCodeItem
{
	/**
	 * @var String
	 */
	private $name;

	/**
	 * @var String
	 */
	private $slug;

	/**
	 * @var String
	 */
	private $type;

	/**
	 * @return String
	 */
	public function getName(): String
	{
		return $this->name;
	}

	/**
	 * @param String $name
	 */
	public function setName(String $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return String
	 */
	public function getSlug(): String
	{
		return $this->slug;
	}

	/**
	 * @param String $slug
	 */
	public function setSlug(String $slug): void
	{
		$this->slug = $slug;
	}

	/**
	 * @return String
	 */
	public function getType(): String
	{
		return $this->type;
	}

	/**
	 * @param String $type
	 */
	public function setType(String $type): void
	{
		$this->type = $type;
	}

}