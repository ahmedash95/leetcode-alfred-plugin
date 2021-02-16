<?php

namespace App\Repositories;

use App\Entities\LeetCodeItem;

interface RepositoryInterface
{
	/**
	 * @return LeetCodeItem[]
	 */
	public function get(): array;

	/**
	 * @param string $query
	 * @return LeetCodeItem[]
	 */
	public function search(string $query): array;
}