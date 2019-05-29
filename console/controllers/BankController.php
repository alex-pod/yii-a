<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/30/19
 */
declare(strict_types = 1);


namespace console\controllers;

use backend\services\CronService;
use yii\base\InvalidConfigException;

/**
 * Class BankController
 *
 * @package console\controllers
 */
class BankController
{
    public function actionIndex(): void
    {
        try {
            $cronService = new CronService();
            $cronService->run();
        } catch (InvalidConfigException $e) {
            echo $e->getMessage();
        }
    }
}