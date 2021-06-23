<?php

namespace ash;

use ash\Events\joinEvent;
use ash\Events\quitEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class main extends PluginBase implements Listener{

    /**@var $db Config*/
    public $db;

    private static $instance;

    public function onEnable()
    {
        $this->getLogger()->info("plugin activé");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new joinEvent(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new quitEvent(), $this);

        self::$instance = $this;

        @mkdir($this->getDataFolder());
        $this->db = new Config($this->getDataFolder() . "message.yml" . Config::YAML);

        if(!file_exists($this->getDataFolder() . "message.yml")){
            $this->getLogger()->info("Fichier message.yml créé");
            $this->saveDefaultConfig();

        }

        $db = main::message();
        $db->set("JoinMessage","§2[+] §f{player}");
        $db->set("NewPlayerJoinMessage","§2[+] §fBienvenue à {player} sur le serveur");
        $db->set("StaffJoinMessage","§2[+] §7[§3Staff§7] §f{player}");
        $db->set("QuitMessage","§4[-] §f{player}");
        $db->set("StaffQuitMessage","§4[-] §7[§3Staff§7] §f{player}");
        $db->save();

    }
    public function onDisable()
    {
        $this->getLogger()->info("plugin désactivé");
        $this->db->save();
    }

    public static function message()
    {
        return new Config(main::getInstance()->getDataFolder()."message.yml",Config::YAML);
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}