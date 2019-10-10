<?php

namespace BanClientID\SACv2;

use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

class banclient extends PluginBase implements Listener
{
    public $banclient = "§cAniti ToolBox";

    public function onEnable()
    {
        $this->getLogger()->alert("Enable Plugin! Do not stop anything!");
        $this->client = new Config($this->getDataFolder() . "ClientID.yml", Config::YAML, [
            "ClientID Banned" => 0,
            "ClientID Name Got Banned" => "Toolbox",
        ]);
        $this->client->save();
    }

    public function onLoad(): void
    {
        $this->getLogger()->info("
§e  ____               _____ _ _            _   _____ _____  
§a |  _ \             / ____| (_)          | | |_   _|  __ \ 
§d | |_) | __ _ _ __ | |    | |_  ___ _ __ | |_  | | | |  | |
§c |  _ < / _` | '_ \| |    | | |/ _ \ '_ \| __| | | | |  | |
§b | |_) | (_| | | | | |____| | |  __/ | | | |_ _| |_| |__| |
§6 |____/ \__,_|_| |_|\_____|_|_|\___|_| |_|\__|_____|_____/ 
                                                           
                       §aCode By BlackPMFury");
    }

    public function onDeceive(DataPacketReceiveEvent $ev)
    {
        $bc = $ev->getPacket();
        if ($bc instanceof LoginPacket) {
            if ($bc->clientId === 0) {
                $ev->setCancelled(true);
                $ev->getPlayer()->close($this->banclient);
            }
        }
    }

    public function onJoin(PlayerJoinEvent $ev)
    {
        $player = $ev->getPlayer();
        if ($player->isClosed()) {
            $this->getServer()->broadCastMessage("§aPlayer §c" . $player->getName() . "§a Got kicked by use ToolBox!");
        }
    }
}