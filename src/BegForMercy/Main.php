<?php 

namespace BegForMercy;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {


	public function onEnable(){

		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getLogger()->info("Enabled");

		@mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder(). "config.yml", Config::YAML);
        
	}

	public function onMove(PlayerMoveEvent $event){

		$world = $event->getPlayer()->getLevel()->getName();

		$worlds = $this->getConfig()->get("disable-hunger");

          if(in_array($world, $worlds)){
		  
		  $player = $ev->getPlayer();
        $player->setFood(20);
		  $player->setFoodEnabled(0);
          
	     } else {
	  	  $player = $ev->getPlayer();
	  	  $player->setFoodEnabled(1);
	    }
	  }
	
	 	public function onBlockBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		if($player->hasPermission("break.bypass")){
			return true;
			} elseif($player->getLevel()->getName() == $world){
				 	$this->getConfig()->get(in_array("disable-break", $world));
				$event->setCancelled();
	}
	}
	
	public function onBlockPlace(BlockPlaceEvent $event){
		$player = $event->getPlayer();
		if($player->hasPermission("place.bypass")){
			return true;
			} elseif($player->getLevel()->getName() == $world){
				 	$this->getConfig()->get(in_array("disable-place", $world));
				$event->setCancelled();
	}
	}
	
	public function onDisable(){
		$this->getLogger()->info("Disbled");
	}
    

}

