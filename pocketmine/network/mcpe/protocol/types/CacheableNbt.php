<?php

/*
 * This file is part of BedrockProtocol.
 * Copyright (C) 2014-2022 PocketMine Team <https://github.com/pmmp/BedrockProtocol>
 *
 * BedrockProtocol is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\nbt\tag\Tag;
use pocketmine\nbt\TreeRoot;
use pocketmine\nbt\NetworkLittleEndianNBTStream;

/**
 * @phpstan-template TTagType of Tag
 */
final class CacheableNbt{

	/** @phpstan-var TTagType */
	private Tag $root;
	private ?string $encodedNbt;

	/**
	 * @phpstan-param TTagType $nbtRoot
	 */
	public function __construct(Tag $nbtRoot){
		$this->root = $nbtRoot;
	}

	/**
	 * @phpstan-return TTagType
	 */
	public function getRoot() : Tag{
		return $this->root;
	}

	public function getEncodedNbt() : string{
		return $this->root;
	}
}
