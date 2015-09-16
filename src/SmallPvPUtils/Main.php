<?php

namespace SmallPvPUtils;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use aliuly\killrate\api\KillRateScoreEvent;
use aliuly\killrate\api\KillRateResetEvent;

class Main extends PluginBase implements Listener

{
public $kr;
public $pp;

  public function onEnable(){
    $this->kr = $this->getServer()->getPluginManager()->getPlugin("KillRate");
    if(!$this->kr || intval($this->kr->getDescription()->getVersion()) != 2) {
      $this->getLogger()->error(TextFormat::RED."Unable to find KillRate");
      throw new \RuntimeException("Missing Dependancy");
      return;
    }
    $this->pp = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
    if(!$this->pp) {
      $this->getLogger()->error(TextFormat::RED."Unable to find PurePerms");
      throw new \RuntimeException("Missing Dependancy");
      return;
    }
    $this->getLogger()->info(TextFormat::GREEN."Enabled!");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->scores = new Config($this->getDataFolder()."scores.properties", Config::PROPERTIES);
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
    $cause = $event->getEntity()->getLastDamageCause();
    $victim = $event->getEntity()->getName();
    $killer = $cause->getDamager()->getName();
    $name = $e->getPlayer()->getName();
    //PointsPerKill = $this->getConfig()->get("PointsPerKill");
    $scores->set($name + //qui metti il numero di punti che vuoi oppure $PointsPerKill);
    //nella speranza che esista un setDeathMessage perche non ricordo se si xD però credo esista senno sostituisci $victim con $ps e $ps sarebbe foreach($this->getServer()->getOnlinePlayers() as $ps)
    $victim->setDeathMessage(TextFormat::RED . $victim." was killer by "$killer TextFormat::RED . "for ".$cause TextFormat::RED . $killer." +  ".$PointsPerKill);
    $event->setDrops(array());
  }


  // TNT Hoe
  public function onPlayerItemHeld(PlayerItemHeldEvent $event){
    $player = $event->getPlayer();
    if($player->getInventory()->getItemInHand()->getId() === Item::WOODEN_AXE){
      $player->sendPopup("SuperAscia Esplosiva");
    }
  }

  public function onPlayerInteract(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    if($player->getInventory()->getItemInHand()->getId() === Item::WOODEN_AXE){
      $exp = new Explosion($event->getBlock(), 2);
      $exp->explodeB();
    }
  }
  
  // KillRate Based PurePerms Rank Section
  public function onKillRateReset(KillRateResetEvent $event){
    $event->getPlayer()->sendMessage("I punteggi sono stati resettati, pertanto hai perso il tuo rank.");
    $this->pp->getUser($event->getPlayer())->setGroup($this->pp->getDefaultGroup(), null);
  }
  
  public function onKillRateScore(KillRateScoreEvent $event){
    $name = $e->getPlayer()->getName();
    $score = $scores->get($name);
    if($score === "2000"){
      $this->pp->getUser($event->getPlayer())->setGroup($this->pp->getGroup("Pro"), null);
      $event->getPlayer()->sendMessage("Sei salito di rank; adesso sei Pro!");
    }
    elseif($score === "5000"){
      $this->pp->getUser($event->getPlayer())->setGroup($this->pp->getGroup("Dio"), null);
      $event->getPlayer()->sendMessage("Sei salito di rank; adesso sei Dio!");
    }
    elseif($score === "0"){
      $this->pp->getUser($event->getPlayer())->setGroup($this->pp->getDefaultGroup(), null);
    }
  }

}
