<?php

namespace xtakumatutix\mss;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\tile\Tile;
use pocketmine\tile\Sign;
use onebone\economyapi\EconomyAPI;

class EventListener implements Listener 
{
    private $Main;

    public function __construct(Main $Main)
    {
        $this->Main = $Main;
    }

    public function onTap(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $levelname = $level->getName();
        $block = $event->getBlock();
        $tile = $level->getTile($block);
        if ($tile instanceof Sign) {
            if ($levelname == 'lobby') {
                if ($tile->getLine(0) == '- MoneySee -') {
                    $name = $player->getName();
                    $money = EconomyAPI::getInstance()->myMoney($name);
                    $tile->setLine(1, "§b".$name."§eさん");
                    $tile->setLine(2, "§e所持金");
                    $tile->setLine(3, "§f".$money."§6K§eG");
                    $tile->saveNBT();
                    $player->sendMessage(' §a>> §f看板を書き換えたよ！アピールしよう！');
                }
            }
        }
    }
}