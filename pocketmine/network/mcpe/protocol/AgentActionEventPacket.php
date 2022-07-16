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

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\AgentActionType;
use pocketmine\network\mcpe\NetworkSession;

/**
 * Used by code builder, exact purpose unclear
 */
class AgentActionEventPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::AGENT_ACTION_EVENT_PACKET;

	private string $requestId;
	/** @see AgentActionType */
	private int $action;
	private string $responseJson;

	/**
	 * @generate-create-func
	 */
	public static function create(string $requestId, int $action, string $responseJson) : self{
		$result = new self;
		$result->requestId = $requestId;
		$result->action = $action;
		$result->responseJson = $responseJson;
		return $result;
	}

	public function getRequestId() : string{ return $this->requestId; }

	/** @see AgentActionType */
	public function getAction() : int{ return $this->action; }

	public function getResponseJson() : string{ return $this->responseJson; }

	protected function decodePayload() : void{
		$this->requestId = $this->getString();
		$this->action = $this->getLInt();
		$this->responseJson = $this->getString();
	}

	protected function encodePayload() : void{
		$this->putString($this->requestId);
		$this->putLInt($this->action);
		$this->putString($this->responseJson);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleSimpleEvent($this);
	}
}
