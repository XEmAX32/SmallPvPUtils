<?php

namespace SmallPvPUtils;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\entity\Entity;

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
    $event->setDrops(array());
  }


  // TNT Hoe
  public function onPlayerItemHeld(PlayerItemHeldEvent $event){
    $player = $event->getPlayer();
    if($player->getInventory()->getItemInHand() === Item::WOODEN_HOE){
      $player->sendPopup("SuperZappa Esplosiva");
    }
  }

  public function onPlayerInteract(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    $pos = $event->getTouchVector();
    if($player->getInventory()->getItemInHand() === Item::WOODEN_HOE){
      // boh
    }
  }

}
