<?php
namespace backend\controllers;

use backend\services\Reporter;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Displays reports.
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionIndex(): string
    {
        /** @var Reporter $reporter */
        $reporter = Yii::createObject(Reporter::class);

        return $this->render('index', [
           'avgDeposit' => $reporter->getAvgAmountDepositByAgeGroups(),
           'revenueHistory' => $reporter->getRevenueReportHistory(),
        ]);
    }
}
