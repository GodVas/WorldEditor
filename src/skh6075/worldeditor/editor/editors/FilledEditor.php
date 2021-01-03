<?php

namespace skh6075\worldeditor\editor\editors;

use pocketmine\block\BlockFactory;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use skh6075\worldeditor\editor\Editor;
use skh6075\worldeditor\editor\EditorFactory;
use skh6075\worldeditor\lang\PluginLang;
use skh6075\worldeditor\WorldEditor;

class FilledEditor extends Editor{


    public function __construct() {
        parent::__construct("fill");
    }

    public function onUseEditor(Player $player, array $blocks = []): void{
        if (EditorFactory::getInstance()->canUseEditor($player)) {
            /** @var Position $pos1 */
            /** @var Position $pos2 */
            EditorFactory::getInstance()->getQueuePosition($player, $pos1, $pos2);

            [$minX, $minY, $minZ, $maxX, $maxY, $maxZ] = [min($pos1->x, $pos2->z), min($pos1->y, $pos2->y), min($pos1->z, $pos2->z), max($pos1->x, $pos2->x), max($pos1->y, $pos2->y), max($pos1->z, $pos2->z)];

            $time = microtime(true);
            $changedCount = 0;
            for ($x = $minX; $x <= $maxX; $x ++) {
                for ($z = $minZ; $z <= $maxZ; $z ++) {
                    for ($y = $minY; $y <= $maxY; $y ++) {
                        $changedCount ++;
                        $block = $blocks[mt_rand(0, count($blocks) - 1)];
                        $player->getLevel()->setBlock(new Vector3($x, $y, $z), BlockFactory::get($block[0], $block[1]));
                    }
                }
            }
            $record = microtime(true) - $time;
            $player->sendMessage(PluginLang::getInstance()->format("fill.editor.success", ["%changedcount%" => $changedCount, "%record%" => round($record, 2)]));
        }
    }
}