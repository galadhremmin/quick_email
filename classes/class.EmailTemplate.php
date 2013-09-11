<?php

class EmailTemplate {
    private $_template;
    private $_values;

    public function __construct($templatePath) {
        if (!file_exists($templatePath) || !is_file($templatePath)) {
            throw new Exception('Expecting a template file at the specified path "' . $templatePath . '".');
        }

        $this->_template = $templatePath;
        $this->_values = array();
    }

    public function add($key, $value) {
        if (function_exists('get_magic_quotes_gpc')) {
            if (get_magic_quotes_gpc()) {
                $value = stripslashes($value);
                $key   = stripslashes($key);
            }
        }

        $this->_values[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    public function apply() {
        $contents = file_get_contents($this->_template);

        foreach ($this->_values as $key => $value) {
            $contents = str_replace('$'.$key, $value, $contents);
        }

        return $contents;
    }
}