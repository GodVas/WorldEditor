<?php

namespace skh6075\worldeditor\lang;

final class PluginLang{

    /** @var ?PluginLang */
    private static $instance = null;
    /** @var string */
    private $lang;
    /** @var array */
    private $translates = [];


    public static function getInstance(): ?PluginLang{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
    }

    public function setLang(string $lang): PluginLang{
        $this->lang = $lang;
        return $this;
    }

    public function setTranslates(array $translates = []): PluginLang{
        $this->translates = $translates;
        return $this;
    }

    public function format(string $key, array $replaces = [], bool $usePrefix = true): string{
        $string = $usePrefix ? $this->translates["prefix"] : '';
        $string .= $this->translates[$key] ?? '';

        foreach ($replaces as $old => $new) {
            $string = str_replace($old, $new, $string);
        }
        return $string;
    }
}