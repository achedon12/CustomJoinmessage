<?php

namespace ash\Events;

use ash\main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

class joinEvent implements Listener{


    public function onJoin(PlayerJoinEvent $event){

        $Player = $event->getPlayer();
        $player = $Player->getName();


        $db = main::message();

        if(!$Player->hasPlayedBefore()){
            $event->setJoinMessage(str_replace("{player}",$player,$db->get("NewPlayerJoinMessage")));
        }else{
            if(!$Player->hasPermission("join.staff")){
                $event->setJoinMessage(str_replace("{player}",$player,$db->get("JoinMessage")));
            }else{
                $event->setJoinMessage(str_replace("{player}",$player,$db->get("StaffJoinMessage")));
            }
        }

    }
}