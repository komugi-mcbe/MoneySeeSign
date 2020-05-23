<?php

namespace xtakumatutix\noplace;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

Class noplaceCommand extends Command 
{
    private $Main;

    public function __construct(Main $Main)
    {
        $this->Main = $Main;
        parent::__construct("noplace", "置けないブロックを追加します", "/noplace");
        $this->setPermission("noplace.command.noplace");
        $this->setDescription("置けないブロックを追加します");
        $this->setUsage("/noplace <id:damage>");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if($sender->isOP()){
            $id = $this->Main->id;
            if(isset($args[0])){
                switch ($args[0]){
                    case "set":
                    if(isset($args[1])){
                        if(!$id->exists($args[1])){
                            $sender->sendMessage("ID:".$args[1]."を置けないブロックとして登録しました");
                            $id->set($args[1]);
                            $id->save();
                        }else{
                            $sender->sendMessage("そのブロックIDは先に登録されています");
                        }
                    }else{
                        $sender->sendMessage("IDを入力してください");
                        return true;
                    }
                    break;

                    case "remove":
                    if(isset($args[1])){
                        if($id->exists($args[1])){
                            $sender->sendMessage("ID:".$args[1]."を置けるようにしました");
                            $id->remove($args[1]);
                            $id->save();
                        }else{
                            $sender->sendMessage("そのブロックIDは登録されていません");
                        }
                    }else{
                        $sender->sendMessage("IDを入力してください");
                        return true;
                    }
                    break;
                }
            }else{
                $sender->sendMessage("使い方\n/npolace set <id:damage> 置けないブロックを登録する\n/noplace remove <id:damage> 置けなくしたブロックを置けるようにする");
            }
        }else{
            $sender->sendMessage("OPのみ使えます");
        }
        return true;
    }
}