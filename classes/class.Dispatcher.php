<?php

class Dispatcher {
    private $_to;
    private $_from;
    private $_subject;
    private $_template;

    public function __construct($to, $from, $subject, EmailTemplate $template) {

        if (function_exists('filter_var')) {
            if (filter_var($to, FILTER_VALIDATE_EMAIL) === false) {
                throw new Exception('Invalid recipient "'.$to.'".');
            }

            if (filter_var($from, FILTER_VALIDATE_EMAIL) === false) {
                throw new Exception('Invalid sender "'.$from.'".');
            }
        }

        if ($subject === null || strlen($subject) < 1) {
            throw new Exception('Missing subject.');
        }

        $this->_to = $to;
        $this->_from = $from;
        $this->_subject = $subject;
        $this->_template = $template;
    }

    public function send() {
        $headers = 'Content-Type: text/html; charset=utf-8'."\r\n" .
            'From: '.$this->_from."\r\n";

        mail($this->_to, $this->_subject, $this->_template->apply(), $headers);
    }
}