<?php
defined('THINK_PATH') OR exit();
class FootWidget extends Widget{
	public function render($data){
		return $this->renderFile ("index", $data);
	}
}
?>