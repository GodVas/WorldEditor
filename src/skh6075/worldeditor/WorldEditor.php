<?php

namespace skh6075\worldeditor;

use pocketmine\plugin\PluginBase;
use skh6075\worldeditor\editor\EditorFactory;
use skh6075\worldeditor\editor\editors\FilledEditor;
use skh6075\worldeditor\lang\PluginLang;
use skh6075\worldeditor\listener\EventListener;

class WorldEditor extends PluginBase{

    /** @var ?WorldEditor */
    private static $instance = null;


    public static function getInstance(): ?WorldEditor{
        return self::$instance;
    }

    public function onLoad(): void{
        if (self::$instance === null) {
            self::$instance = $this;
        }
    }

    public function onEnable(): void{
        $this->saveResource("lang/kor.yml");
        $this->saveResource("lang/eng.yml");

        PluginLang::getInstance()
            ->setLang(($lang = $this->getServer()->getLanguage()->getLang()))
            ->setTranslates(yaml_parse(file_get_contents($this->getDataFolder() . "lang/" . $lang . ".yml")));

        EditorFactory::getInstance()->registerEditor(new FilledEditor());

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}