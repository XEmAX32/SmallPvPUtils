<?php

namespace SmallPvPUtils;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener

{

  public function onEnable(){
    $this->getLogger()->info(TextFormat::GREEN."Enabled!");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }

  public function onDisable(){
    $this->getLogger()->info(TextFormat::RED."Disabled!");
  }

  public function onPlayerJoin(PlayerJoinEvent $event){
    $p = $event->getPlayer();
    if($p instanceof Player){
      $p->getInventory()->clearAll();
    }
  }

  public function onPlayerDeath(PlayerDeathEvent $event){
    $p = $event->getEntity();
    $p->setDrops(null);
  }

  public function onPlayerQuit(PlayerQuitEvent $event){
    $p = $event->getPlayer();
    if($p instanceof Player){
      $p->getInventory()->clearAll();
    }
  }

}
