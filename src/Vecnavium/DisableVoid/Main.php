<?php

/**
 * Copyright (c) 2021 Vecnavium
 * DisableVoid is licensed under the GNU Lesser General Public License v3.0
 * GitHub: https://github.com/Vecnavium\DisableVoid
 */

declare(strict_types=1);

namespace Vecnavium\DisableVoid;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
	
	public $config;

    public function onEnable(): void
    {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	    $this->saveResource("config.yml");
		$this->config = $this->getConfig();
	}

	public function onDamage(EntityDamageEvent $event) : void{
		$entity = $event->getEntity();
		if(!$entity instanceof Player){
			return;
		}
		foreach ($this->config->getNested("disabled-worlds") as $world){
			if ($entity->getWorld()->getName() === $world) return;
		}
		if($event->getCause() === EntityDamageEvent::CAUSE_VOID){
			$entity->teleport($entity->getWorld()->getSafeSpawn());
		}
	}
}
