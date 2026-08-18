<?php

class Advance_Security_Key_List
{

    private $key_email_varification = "jasfhdkjfhakjfhdjkh983274982";
    private $key_cook = "(&*(&78942sjlkfjakljflkajKLJLKJLKJ";
    private $two_step_varification = "jshjhsbdbsdbdwhjbdjdi289302";
    private $key_of_appid = "(&*(&3826878942sjlkfjakljflk386873638ajKLJLKJLKJ";

    public function get_key_email_varification()
    {
        return $this->key_email_varification;
    }
    public function get_key_cook()
    {
        return $this->key_cook;
    }
    public function get_two_step_varification()
    {
        return $this->two_step_varification;
    }
    public function get_app_id_key()
    {
        return $this->key_of_appid;
    }
}
