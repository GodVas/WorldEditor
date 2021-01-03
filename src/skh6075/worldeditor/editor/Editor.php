<?php

namespace skh6075\worldeditor\editor;

use pocketmine\Player;

abstract class Editor{

    /** @var string */
    private $name;


    public function __construct(string $name) {
        $this->name = $name;
    }

    final public function getName(): string{
        return $this->name;
    }

    abstract public function onUseEditor(Player $player, array $blocks = []): void;
}