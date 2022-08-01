<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\utils\Binary;

use pocketmine\nbt\NetworkLittleEndianNBTStream;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\types\BlockPosition;

class AddVolumeEntityPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_VOLUME_ENTITY_PACKET;

	/** @var int */
	private $entityNetId;
	/** @var CompoundTag */
	private $data;
	/** @var string */
	private $engineVersion;
	
	private string $jsonIdentifier;
	
	private string $instanceName;
	
	private BlockPosition $minBound;
	
	private BlockPosition $maxBound;

	private int $dimension;

	public static function create(int $entityNetId, CompoundTag $data, string $jsonIdentifier, string $instanceName, BlockPosition $minBound, BlockPosition $maxBound, int $dimension, string $engineVersion) : self{
		$result = new self;
		$result->entityNetId = $entityNetId;
		$result->data = $data;
		$result->jsonIdentifier = $jsonIdentifier;
		$result->instanceName = $instanceName;
		$result->minBound = $minBound;
		$result->maxBound = $maxBound;
		$result->dimension = $dimension;
		$result->engineVersion = $engineVersion;
		return $result;
	}

	public function getEntityNetId() : int{ return $this->entityNetId; }

	public function getData() : CompoundTag{ return $this->data; }
	
	public function getJsonIdentifier() : string{ return $this->jsonIdentifier; }
	
	public function getInstanceName() : string{ return $this->instanceName; }

	public function getEngineVersion() : string{ return $this->engineVersion; }
	
	public function getMinBound() : BlockPosition{ return $this->minBound; }

	public function getMaxBound() : BlockPosition{ return $this->maxBound; }

	public function getDimension() : int{ return $this->dimension; }

	protected function decodePayload() : void{
		$this->entityNetId = $this->getUnsignedVarInt();
		$this->data = $this->getNbtCompoundRoot();
		$this->jsonIdentifier = $this->getString();
		$this->instanceName = $this->getString();
		$this->minBound = $this->getBlockPosition();
		$this->maxBound = $this->getBlockPosition();
		$this->dimension = $this->getVarInt();
		$this->engineVersion = $this->getString();
	}

	protected function encodePayload() : void{
		$this->putUnsignedVarInt($this->entityNetId);
		($this->buffer .= (new NetworkLittleEndianNBTStream())->write($this->data));
		$this->putString($this->jsonIdentifier);
		$this->putString($this->instanceName);
		$this->putBlockPosition($this->minBound);
		$this->putBlockPosition($this->maxBound);
		$this->putVarInt($this->dimension);
		$this->putString($this->engineVersion);
	}

	public function handle(NetworkSession $handler) : bool{
		return $handler->handleAddVolumeEntity($this);
	}
}
