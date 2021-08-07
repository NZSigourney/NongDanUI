<?php

namespace NZS\ND;

use pocketmine\plugin\pluginBase;
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\{Player, Server};
//Event
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
//confjg
use pocketmine\utils\Config;
// other plugin
use jojoe7777\FormAPI;

class Main extends PluginBase implements Listener{
	
	public $nd = "§l§e<§c•§e> §aNông dân §l§e<§c•§e>";
	
	public function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Nông Dân System V1 by NZS (Tobi)");
	}
	
	public function onLoad(){
		$this->getServer()->getLogger()->info("§l§f<§e+§f>§a NDSystem §f<§e+§f>\n VERSION 1-0BETA\n CODE BY TOBI/NZS");
	}
	
	public function onJoin(PlayerJoinEvent $ev){
		$player = $ev->getPlayer();
		$name = $player->getName();
		$svName = $this->getServer()->getMotd();
		if($player->hasPlayedBefore() == true){
			$player->sendMessage($this->nd . "§l§a Chào mừng bạn đến với §6".$svName."§a! Hãy tiếp tục chơi vui vẻ nếu bạn muốn nhé !");
			$this->welcome($player);
		}else{
			$this->getServer()->broadcastMessage($svName . ": §l§aNgười chơi §e".$name."§a Lần đầu vào Server Bắt đầu cày cuốc đi nào!");
			$this->welcome($player);
			return true;
		}
	}
	
	public function onCommand(CommandSender $player, Command $cmd, string $label, array $args): bool{
		switch($cmd->getName()){
			case "farmer":
			if(!($player instanceof Player)){
				$this->getLogger()->warning("Use in game!");
				return true;
			}
			if(!(isset($args[0]))){
				$player->sendMessage($this->nd . /**"§6 List Command:\n §c+ §a/farmer help\n§c+§a /farmer open"*/ "§cĐiền vào ô trống!");;
				//return true;
			}else{
				if(!($args[0] == "open" or "Open")){
					$this->welcome($player);
				}else{
					$player->sendMessage($this->nd . "§l§c Không có lệnh này!");
				    //return false;
				}
				if(!($args[0] == "help" or "Help")){
				    $player->sendMessage($this->nd . "§l§5List command: Trang 1/1\n§c+§a open\n§c+§a Help");
				}else{
				    $player->sendMessage($this->nd . "§l§c Không có lệnh này!");
				    //return false;
				}
			}
			return false;
		}
		return true;
	}
	
	public function welcome($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createSimpleForm(Function (Player $player, $d){
			$r = $d;
			if($r == null){
			}
			switch($r){
				case 0:
				$this->update($player);
				break;
				case 1:
				$this->tutorial($player);
				break;
				case 2:
				$this->listStaff($player);
				break;
				case 3:
				$player->sendMessage("§c");
				break;
			}
		});
		$f->setTitle($this->nd);
		$f->setContent("§l§eThông tin Mới từ Máy chủ!");
		$f->addButton("§l§e • §cCó gì mới? §e•", 0, "https://cdn2.iconfinder.com/data/icons/picons-basic-2/57/basic2-081_new_badge-128.png");
		$f->addButton("§l§e • §aCách chơi §e•", 1, "https://cdn4.iconfinder.com/data/icons/education-2-56/128/B-86-128.png");
		$f->addButton("§l§e • §aSTAFF §e•", 2, "https://cdn4.iconfinder.com/data/icons/hr-recruitment-management/400/SET-08-128.png");
		$f->addButton("§l§e •§c EXIT §e•", 3, "https://cdn1.iconfinder.com/data/icons/materia-arrows-symbols-vol-8/24/018_317_door_exit_logout-256.png");
		$f->sendToPlayer($player);
	}
	
	public function update($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createCustomForm(Function (Player $p, $d){
			/**$r = $d;
			if($r == null)
			{
				//return $this->welcome($player);
			}
			switch($r){
				case 0:
				$this->welcome($player);
				break;
			}*/
			if($d == 0){
				return $this->welcome($player);
			}
		});
		$f->setTitle($this->nd);
		$f->addLabel("§l§c• §aChange Gameplay + Big Update 2.0");
		$f->addLabel("§l§f[§c+§f] §aCó gì mới ở bản cập nhập này?:\nSau những ngày vắng bóng khiến cho Prison bị đình truệ,\nBan Quản trị ngay lập tức nhận ra vấn đề này.\nNhanh chóng giao cho NZS (Tobi Kun) Thiết kế lại lối chơi cũng như thay đổi hoàn toàn mới cơ cấu chơi!");
		$f->addLabel("§a§lNội dung:\n§l§f[§c+§f]§a Chúng ta nhập vai vào Người nông dân dưới sự Cai trị của Phe trục trong WW2\n(Đức Quốc Xã),\nNhiều hệ thống nhà tù đã mọc lên như nấm. Buộc người dân phải làm việc cho Phe trục để đổi lại Cái quyền lợi cơ bản thời chiến!\nNhiều Quân Kháng chiến Đã bị dập Tắt trong\n vô vọng và phải bị tù đày!");
		$f->addLabel("§l§cHệ Thống nhà tù:\n §l§f[§c+§f]§a Đây là hệ thống trong tù có 1 không 2 tại §6".$this->getServer()->getMotd()."§a Bạn sẽ lao động cực khổ khi đã vào đây và là nơi ác mộng của bạn bất đầu\nNhững tên cai ngục sẽ khiến bạn khốn khổ tột cùng,\n Nếu không muốn vào đây, hãy chăm chỉ và đừng chống lại Phe Nazis!");
		$f->sendToPlayer($player);
	}
	
	/**public function update($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createModalForm(Function (Player $data, $d){
			$r = $d;
			if($r == null){
				return true;
			}
			switch($r){
				case 1:
				$player->sendMessage($this->nd . " §l§aBạn vừa đọc xong update, Còn gì thắc mắc hãy liên hệ cho BQT nhé!");
				break;
				case 2:
				return $this->welcome($player);
				break;
			}
		});
		$f->setTitle($this->nd);
		$f->setContent("§l§f[§c+§f] §aCó gì mới ở bản cập nhập này?:\nSau những ngày vắng bóng khiến cho Prison bị đình truệ,\nBan Quản trị ngay lập tức nhận ra vấn đề này.\nNhanh chóng giao cho NZS (Tobi Kun) Thiết kế lại lối chơi và thay đổi hoàn toàn!\n§a§lNội dung:\n§l§f[§c+§f]§a Chúng ta nhập vai vào Người nông dân dưới sự Cai trị của Phe trục trong WW2 (Đức Quốc Xã),\nNhiều hệ thống nhà tù đã mọc lên như năm. Buộc người dân phải làm việc cho Phe trục để đổi lại Cái quyền lợi cơ bản thời chiến!\nNhiều Quân Kháng chiến Đã bị dập Tắt trong vô vọng và phải bị tù đày\n§l§cHệ Thống nhà tù:\n §l§f[§c+§f]§a Đây là hệ thống trong tù có 1 không 2 tại §6".$this->getServer()->getMotd()."§a Bạn sẽ lao động cực khổ khi đã vào đây và là nơi ác mộng của bạn bất đầu\nNhững tên cai ngục sẽ khiến bạn khốn khổ tột cùng, Nếu không muốn vào đây, hãy chăm chỉ và đừng chống lại Phe Nazis!");
		$f->setButton1("Đã Hiểu", "https://cdn4.iconfinder.com/data/icons/religion-science/30/buddha-128.png");
		$f->setButton2("Quay Lại");
		$f->sendToPlayer($player);
	}*/
	
	public function tutorial($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createSimpleForm(Function (Player $player, $d){
			$r = $d;
			if($r == null){
				return $this->welcome($player);
			}
			switch($r){
				case 0:
				$this->nongdan($player);
				break;
				case 1:
				$this->Phanbon($player);
				break;
				case 2:
				$this->weather($player);
				break;
				case 3:
				$this->prison($player);
				break;
				case 4:
				return $this->welcome($player);
				break;
			}
		});
		$f->setTitle($this->nd);
		$f->setContent("§l§aTutorial Guide");
		$f->addButton("§l§f[§c•§f] §aGameplay Nông dân", 0, "https://cdn0.iconfinder.com/data/icons/profession-avatar-glyph/512/farmer_agriculture_harvest_farm_nature_organic_wheat_crop_avatar-128.png");
		$f->addButton("§l§f[§c•§f] §aHướng dẫn phân bón", 1, "https://cdn0.iconfinder.com/data/icons/farming-69/4000/water_can_farmlife_farmhouse_farmersmarket_farming_farmtotable-128.png");
		$f->addButton("§l§f[§c•§f] §aThương lái theo mùa", 2, "https://cdn0.iconfinder.com/data/icons/business-finance-vol-2-56/512/trade_commerce_buy_sell-128.png");
		$f->addButton("§l§f[§c•§f] §aHệ thống ngục tù (§cNightmare)", 3, "https://cdn0.iconfinder.com/data/icons/kameleon-free-pack-rounded/110/Prisoner-128.png");
		$f->addButton("§l§e •§c BACK §e•", 3, "https://cdn1.iconfinder.com/data/icons/materia-arrows-symbols-vol-8/24/018_317_door_exit_logout-256.png");
		$f->sendToPlayer($player);
	}
	
	public function nongdan($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createCustomForm(Function (Player $player, $d){
		});
		$f->setTitle($this->nd);
		$f->addLabel("§l¶c• §aNew §cGame§aPlay Prison RPG 2.0");
		$f->addLabel("§l§f[§c•§f]§a Đây là mô phỏng RPG nông dân, Bạn sẽ vào một người nông dân cày bừa để kiếm cơm qua ngày\nDưới sự cai trị của Chính Quyền Đức Quốc Xã, bạn sẽ tìm mọi cách để sống sót và trốn khỏi nhà tù nếu bị bắt");
		$f->addLabel("§l§f[§c•§f]§a Hãy tạo nên một trận chiến riêng bạn! Bạn có thể thành lập 1 phe phái riêng để chống phá lẫn nhau\nCứ tới 1 thời điểm nhất định §cHệ thống Tù nhân§a Sẽ xảy ra xung đột và để lọt những tên tù nhân ra bên ngoài\nDo đó bạn cần phải tạo ra 1 pháo đài phong thủ riêng bạn!");
		$f->addLabel("§l§f[§c•§f]§c Lời khuyên: §aHãy tạo nên 1 liên minh Mạnh nếu bạn không muốn bị ăn hiếp!");
		$f->sendToPlayer($player);
	}
	
	public function phanbon($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createCustomForm(Function (Player $player, $d){
		});
		$f->setTitle($this->nd);
		$f->addLabel("§l§c•§a Không có gì đâu, đơn giản chỉ là... à mà thôi dang update mà hihi");
		$f->sendToPlayer($player);
	}
	
	public function weather($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createCustomForm(Function (Player $player, $d){
		});
		$f->setTitle($this->nd);
		$f->addLabel("§l§c•§a Không có gì đâu, đơn giản chỉ là... à mà thôi dang update mà hihi");
		$f->sendToPlayer($player);
	}
	
	public function prison($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createCustomForm(Function (Player $player, $d){
		});
		$f->setTitle($this->nd);
		$f->addLabel("§l§c•§a Hệ thống Ngục tù:");
		$f->addLabel("§l§f[§c•§f]§a Ngục tù tâm tối tồn tại những nhân cách tàn ác, Bạn buộc phải học cách sống sót\ntrong môi trường khắc nghiệt như thế\nĐể có thể trở thành người mạnh nhất\ntrong ngục");
		$f->addLabel("§l§f[§c•§f]§a Mọi người sẽ phải lao động khổ sai để có thể ra tù sớm hơn dự tính thông qua §c(bail)\n§aHoặc có thể vượt ngục bằng cách hạ gục cai ngục thông qua NPC được giấu kín đâu đó ở trong tù!");
		$f->addLabel("§aGood Luck!");
		$f->sendToPlayer($player);
	}
	
	public function listStaff($player){
		$a = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $a->createCustomForm(Function (Player $player, $d){
		});
		$f->setTitle($this->nd);
		$f->addLabel("§l¶f[§c•§f]§c Owner: §aDbgamingvn2\n§l¶f[§c•§f]§6 DEV: §aTobi (NZSigourney), LetTIHL\n§l¶f[§c•§f]§eb Police: \n§l¶f[§c•§f]§p Helper:");
		$f->sendToPlayer($player);
	}
}