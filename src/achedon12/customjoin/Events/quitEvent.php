<?php

namespace achedon12\customjoin\Events;

use achedon12\customjoin\main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;


class quitEvent implements Listener{


    public function onQuit(PlayerQuitEvent $event){

        $Player = $event->getPlayer();
        $player = $Player->getName();
        $event->setQuitMessage("");

        $db = main::message();

        if(!$Player->hasPermission("quit.staff")){
            $event->setQuitMessage(str_replace("{player}",$player,$db->get("QuitMessage")));
        }else{
            $event->setQuitMessage(str_replace("{player}",$player,$db->get("StaffQuitMessage")));
        }

    }
}