<?php

namespace achedon12\customjoin;

use achedon12\customjoin\Events\joinEvent;
use achedon12\customjoin\Events\quitEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class main extends PluginBase implements Listener{

    /**@var $db Config*/
    public $db;

    private static $instance;

    protected function onEnable():void{
        $this->getLogger()->info("plugin activé");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new joinEvent(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new quitEvent(), $this);

        self::$instance = $this;

        @mkdir($this->getDataFolder());
        $this->db = new Config($this->getDataFolder() . "message.yml" . Config::YAML);

        if(!file_exists($this->getDataFolder() . "message.yml")){
            $this->getLogger()->info("File message.yml create");
            $this->saveDefaultConfig();

        }



    }
    protected function onDisable():void{
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