<?php

class Email {

    public $to = array();
    public $msg;
    public $subject;
    public $from;
    public $reply_to;

    public function __construct($attr) {
        $this->to = $attr['to'];             //array name, email
        $this->msg = $attr['msg'];
        $this->subject = $attr['subject'];
        $this->from = $attr['from'];     //array name, email
        $this->reply_to = $attr['reply_to'];
    }

    public function send() {
        foreach($this->to as $t)  {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "To: ".$t['name']." <".$t['email'].">\r\n";
            $headers .= "From: ".$this->from['name']." <".$this->from['email'].">\r\n";
            mail($this->to, $this->subject, $this->msg, $headers);
        }
    }

}
