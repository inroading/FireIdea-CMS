<?php
class IndexAction extends ManageAction
{
	function _initialize() {
		parent::_initialize();
    }
	
    public function index()
    {
        $this->display();
    }
}
?>