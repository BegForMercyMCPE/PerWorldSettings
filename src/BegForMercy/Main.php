<?php 

namespace BegForMercy;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
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
		$food = $this->getConfig()->get("disable-hunger");
          if(in_array($world, $food)){
		  $player = $event->getPlayer();
        $player->setFood(20);
		  $player->setFoodEnabled(0);        
	     } else {
	  	  $player = $event->getPlayer();
	  	  $player->setFoodEnabled(1);
	    }
	  }
	
	 	public function onBlockBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		 $w = $player->getLevel()->getName();
		 				 $break =	$this->getConfig()->get("disable-break");
						if(in_array($w, $break)){						
		if($player->hasPermission("break.bypass")){
			return true;
			} else($event->setCancelled());
   	}
	}
	
	public function onBlockPlace(BlockPlaceEvent $event1){
		$player = $event1->getPlayer();
		 $w1 = $player->getLevel()->getName();
		 				 $place =	$this->getConfig()->get("disable-place");
						if(in_array($w1, $place)){
		if($player->hasPermission("place.bypass")){
			return true;
			} else($event1->setCancelled());				
		}
	}
			public function onEntityDamage(EntityDamageEvent $event) {
        if ($event instanceof EntityDamageByEntityEvent) {
            $player = $event->getEntity(); 
            $player = $event->getDamager();  
        if($player instanceof Player){
	 $w = $player->getLevel()->getName();
		 				 $pvp =	$this->getConfig()->get("disable-pvp");
						if(in_array($w, $pvp)){
		if($player->hasPermission("pvp.bypass")){
			return true;
			} else($event->setCancelled());
                     }	        
                 }             
             }
        }
        public function onExplode(ExplosionPrimeEvent $event) {       
	       	$entity = $event->getEntity();
		         $w = $entity->getLevel()->getName();
		 			    	 $tnt =	$this->getConfig()->get("disable-tnt");
				    		if(in_array($w, $tnt)){						
               $event->setBlockBreaking(false);
                $event->setDamage(0);
		       	} 
       	}
	
	      public function onRegainHealth(EntityRegainHealthEvent $event){
         	$player = $event->getEntity();
	          if($player instanceof Player){
	          	$w = $player->getLevel()->getName();
	            	$regain = $this->getConfig()->get("disable-regen");
	         	if(in_array($w, $regain)){
		         	$event->setCancelled();
			}
		}
	}
    
	public function onDisable(){
		$this->getLogger()->info("Disbled");
	}
    

}
