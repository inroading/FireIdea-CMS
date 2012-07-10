<?php
class BaseAction extends Action {
    public $config="";
    function _initialize() {
        //import("@.API.ConfigUtil");
        //$this->config=ConfigUtil::get_config_all();
        //$this->assign("config",$this->config);
    }
}
?>