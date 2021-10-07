<?php


namespace NZS\ND;

use pocketmine\event\Listener;
use pocketmine\{Server, Player};
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\block\BlockBreakEvent;
use NZS\ND\Main;

class EventListener implements Listener
{
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        //$this->player = $player;
    }

    public function getPlugin()
    {
        return $this->plugin;
    }

    /**private function getPlayer(){
        return $this->player;
    }*/

    public function onJoin(PlayerJoinEvent $ev){
        $player = $ev->getPlayer();
        $name = $player->getName();
        //$svName = $this->getServer()->getMotd();
        if(!$this->getPlugin()->listOp->exists($name)) {
            $rank = $this->getPlugin()->pp->getUserDataMgr()->getGroup($player)->getName();
            //foreach($this->getServer()->getOnlinePlayers() as $p){
            if ($player->isOp()) {
                $this->getPlugin()->getServer()->getLogger()->info("§bSaved data username: " . $name . " With rank " . $rank . " !");
                $this->getPlugin()->listOp->set($name, $rank);
                $this->getPlugin()->listOp->save();
            } else {
                $this->getPlugin()->getServer()->getLogger()->info("§bSaved data Guest: " . $name . " With rank " . $rank . " !");
            }

            if ($rank == "Police") {
                $this->getPlugin()->getServer()->getLogger()->info("§bSaved data username: " . $name . " => Police, At Plugin_Data\NDSystem\ListStaff!");
                $this->getPlugin()->pol->set($name, ["Cai Ngục" => true]);
                $this->getPlugin()->pol->save();
            }
        }

        if($player->hasPlayedBefore() == true){
            $player->sendMessage($this->getPlugin()->nd . "§l§a Chào mừng bạn đến với §6".$this->getPlugin()->getServer()->getMotd()."§a! Hãy tiếp tục chơi vui vẻ nếu bạn muốn nhé !");
        }else{
            $this->getPlugin()->getServer()->broadcastMessage($svName . ": §l§aNgười chơi §e".$name."§a Lần đầu vào Server Bắt đầu cày cuốc đi nào!");
            $this->EconomyAPI->addMoney($player, + 60000);
            $this->getPlugin()->onInventory($player);
            $this->getPlugin()->welcome($player);
            return true;
        }

        if(!$this->getPlugin()->money->exists($player->getName())){
            $this->getPlugin()->money->set($player->getName(), 0);
            $this->getPlugin()->money->save();
        }
    }

    public function onBreak(BlockBreakEvent $ev){
        $player = $ev->getPlayer();
        $block = $ev->getBlock();

        // Wood
        $oak = Item::get(17,0,0);
        $spruce = Item::get(17,1,0);
        $birch = Item::get(17,2,0);
        $jungle = Item::get(17,3,0);
        // End

        if($block->getId() == 2)
        {
            $bx = $block->getX();
            $by = $block->getY();
            $bz = $block->getZ();

            $block->getLevel()->dropItem(new Vector3($bx,$by,$bz), Item::get(2,0,0));
            //$block->getLevel()->setBlock(new Vector3($bx,$by,$bz), Block::get(0));
            $player->getInventory()->addItem(Item::get(3,0,2));
            return true;
        }
        // Oak Wood
        if($block->getId() == 17)
        {
            $bx = $block->getX();
            $by = $block->getY();
            $bz = $block->getZ();
            //$block->getLevel()->dropItem(new Vector3($bx,$by,$bz), Item::get(2,0,0));
            $drops = array();
            $drops[] = Item::get(5,0,4);
            $ev->setDrops($drops);

            $cost = rand(10, 30);
            $this->getPlugin()->EconomyAPI->addMoney($player->getName(), $cost);
            if($this->getPlugin()->money->exists($player->getName())){
                $this->getPlugin()->money->set($player->getName(), $this->money->get($player->getName()) + $cost);
                $this->getPlugin()->money->save();
            }
        }

        // Block money
        $item = Item::get(Item::DIAMOND_PICKAXE, 0, 1);
        if($player->getInventory()->getItemInHand()->getId() == 278)
        {
            if($block->getId() == 1){
                //if($ev->isCancelled()){}
                $cost = rand(10, 50);
                $this->getPlugin()->EconomyAPI->addMoney($player->getName(), $cost);
                if($this->getPlugin()->money->exists($player->getName())){
                    $this->getPlugin()->money->set($player->getName(), $this->getPlugin()->money->get($player->getName()) + $cost);
                    $this->getPlugin()->money->save();
                }
            }
        }
    }
}