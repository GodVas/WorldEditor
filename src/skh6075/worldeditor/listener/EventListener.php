<?php

namespace skh6075\worldeditor\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;
use skh6075\worldeditor\editor\EditorFactory;
use skh6075\worldeditor\lang\PluginLang;
use skh6075\worldeditor\WorldEditor;

class EventListener implements Listener{

    /** @var WorldEditor */
    protected $plugin;


    public function __construct(WorldEditor $plugin) {
        $this->plugin = $plugin;
    }

    /** @priority HIGHEST */
    public function onInteract(PlayerInteractEvent $event): void{
        $player = $event->getPlayer();
        $block  = $event->getBlock();

        if ($event->getItem()->getId() === ItemIds::WOODEN_AXE) {
            if (!$player->hasPermission("worldeditor.permission")) {
                return;
            }
            if (EditorFactory::getInstance()->setQueue($player, $block->asPosition(), 1)) {
                $player->sendMessage(PluginLang::getInstance()->format("worldeditor.setpos.success", ["%pos%" => 1]));
            } else {
                $player->sendMessage(PluginLang::getInstance()->format("worldeditor.setpos.failed", ["%pos%" => 1]));
            }
            $event->setCancelled(true);
        }
    }

    /** @priority HIGHEST */
    public function onBlockBreak(BlockBreakEvent $event): void{
        $player = $event->getPlayer();
        $block  = $event->getBlock();

        if ($event->getItem()->getId() === ItemIds::WOODEN_AXE) {
            if (!$player->hasPermission("worldeditor.permission")) {
                return;
            }
            if (EditorFactory::getInstance()->setQueue($player, $block->asPosition(), 0)) {
                $player->sendMessage(PluginLang::getInstance()->format("worldeditor.setpos.success", ["%pos%" => 0]));
            } else {
                $player->sendMessage(PluginLang::getInstance()->format("worldeditor.setpos.failed", ["%pos%" => 0]));
            }
            $event->setCancelled(true);
        }
    }
}