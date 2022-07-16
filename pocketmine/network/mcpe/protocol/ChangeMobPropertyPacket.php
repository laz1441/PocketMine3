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

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\utils\Binary;

class ChangeMobPropertyPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::CHANGE_MOB_PROPERTY_PACKET;

	private $actorUniqueId;
	private $propertyName;
	private $boolValue;
	private $stringValue;
	private $intValue;
	private $floatValue;

	/**
	 * @generate-create-func
	 */
	private static function create(int $actorUniqueId, string $propertyName, bool $boolValue, string $stringValue, int $intValue, float $floatValue) : self{
		$result = new self;
		$result->actorUniqueId = $actorUniqueId;
		$result->propertyName = $propertyName;
		$result->boolValue = $boolValue;
		$result->stringValue = $stringValue;
		$result->intValue = $intValue;
		$result->floatValue = $floatValue;
		return $result;
	}

	public static function boolValue(int $actorUniqueId, string $propertyName, bool $value) : self{
		return self::create($actorUniqueId, $propertyName, $value, "", 0, 0);
	}

	public static function stringValue(int $actorUniqueId, string $propertyName, string $value) : self{
		return self::create($actorUniqueId, $propertyName, false, $value, 0, 0);
	}

	public static function intValue(int $actorUniqueId, string $propertyName, int $value) : self{
		return self::create($actorUniqueId, $propertyName, false, "", $value, 0);
	}

	public static function floatValue(int $actorUniqueId, string $propertyName, float $value) : self{
		return self::create($actorUniqueId, $propertyName, false, "", 0, $value);
	}

	public function getActorUniqueId() : int{ return $this->actorUniqueId; }

	public function getPropertyName() : string{ return $this->propertyName; }

	public function isBoolValue() : bool{ return $this->boolValue; }

	public function getStringValue() : string{ return $this->stringValue; }

	public function getIntValue() : int{ return $this->intValue; }

	public function getFloatValue() : float{ return $this->floatValue; }

	protected function decodePayload() : void{
		$this->actorUniqueId = $this->getActorUniqueId();
		$this->propertyName = $this->getString();
		$this->boolValue = $this->getBool();
		$this->stringValue = $this->getString();
		$this->intValue = $this->getVarInt();
		$this->floatValue = $this->getLFloat();
	}

	protected function encodePayload() : void{
		$this->putActorUniqueId($this->actorUniqueId);
		$this->putString($this->propertyName);
		$this->putBool($this->boolValue);
		$this->putString($this->stringValue);
		$this->putVarInt($this->intValue);
		$this->putLFloat($this->floatValue);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSimpleEvent($this);
	}
}
