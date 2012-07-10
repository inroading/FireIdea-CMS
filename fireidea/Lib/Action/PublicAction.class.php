<?php
class PublicAction extends Action{
    public function index(){
    }
    
    public function verify(){    
        import("ORG.Util.Image");    
        Image::buildImageVerify();    
    }
}
?>
