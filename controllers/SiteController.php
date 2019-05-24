<?php

class SiteController {
    public function actionIndex() {

        $userId = User::checkLogged();
        require_once(ROOT. '/views/site/index.php');
        
        return true;
    }
}