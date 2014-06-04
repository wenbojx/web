<?php
class TestCommand extends CConsoleCommand {
        public $defaultAction = 'index';

        public function actionIndex() {
            echo 11;
        }
}