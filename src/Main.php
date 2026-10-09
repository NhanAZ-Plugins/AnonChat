<?php

declare(strict_types=1);

namespace NhanAZ\AnonChat;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener {

	private const DEFAULT_FORMAT = "&f[&9Anonymous&f] <msg>";

	private const DEFAULT_SHOW_NAME_TO_CONSOLE = true;

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
	}

	public function onChat(PlayerChatEvent $event): void {
		$playerName = $event->getPlayer()->getName();
		$msg = $event->getMessage();
		if (str_starts_with($msg, "[*]")) {
			$event->cancel();
			$msg = substr($msg, 3);
			if (str_starts_with($msg, " ")) {
				$msg = substr($msg, 1);
			}
			if ($msg === "") {
				return;
			}
			$configuredFormat = $this->getConfig()->get("format", self::DEFAULT_FORMAT);
			$format = is_string($configuredFormat) ? $configuredFormat : self::DEFAULT_FORMAT;
			$configuredShowName = $this->getConfig()->get("showMsgToCsl", self::DEFAULT_SHOW_NAME_TO_CONSOLE);
			$showMsgToCsl = is_bool($configuredShowName) ? $configuredShowName : self::DEFAULT_SHOW_NAME_TO_CONSOLE;
			$message = str_replace("<msg>", $msg, TextFormat::colorize($format));
			$anonName = ($showMsgToCsl ? "[{$playerName}] " : "");
			$this->getServer()->broadcastMessage($message);
			$this->getLogger()->info($anonName . $msg);
		}
	}
}
