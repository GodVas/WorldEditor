<?php

namespace skh6075\worldeditor\editor;

use pocketmine\level\Position;
use pocketmine\Player;

final class EditorFactory{

    /** @var ?EditorFactory */
    private static $instance = null;
    /** @var Editor[] */
    private static $editors = [];
    /** @var Position[] */
    private static $queue = [];


    public static function getInstance(): ?EditorFactory{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
    }

    public function registerEditor(Editor $editor): void{
        self::$editors[$editor->getName()] = $editor;
    }

    public function getEditor(string $name): ?Editor{
        return self::$editors[$name] ?? null;
    }

    public function getQueue(Player $player, int $queue): ?Position{
        return isset(self::$queue[$player->getLowerCaseName()][$queue]) ? self::$queue[$player->getLowerCaseName()][$queue] : null;
    }

    public function setQueue(Player $player, Position $position, int $queue): bool{
        self::$queue[$player->getLowerCaseName()][$queue] = $position;

        if (($queue1 = $this->getQueue($player, 0)) instanceof Position and ($queue2 = $this->getQueue($player, 1)) instanceof Position) {
            return $queue1->getLevel()->getFolderName() === $queue2->getLevel()->getFolderName();
        }
        return true;
    }

    public function canUseEditor(Player $player): bool{
        if (($queue1 = $this->getQueue($player, 0)) instanceof Position and ($queue2 = $this->getQueue($player, 1)) instanceof Position) {
            return $queue1->getLevel()->getFolderName() === $queue2->getLevel()->getFolderName();
        }
        return false;
    }

    public function getQueuePosition(Player $player, &$pos1, &$pos2): void{
        $pos1 = $this->getQueue($player, 0);
        $pos2 = $this->getQueue($player, 1);
    }
}