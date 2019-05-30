<?php
namespace backend\controllers;

use backend\services\interfaces\ReporterInterface;
use backend\services\ReporterService;
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
        /** @var ReporterService $reporter */
        $reporter = Yii::createObject(ReporterInterface::class);

        return $this->render('index', [
           'avgDeposit' => $reporter->getAvgAmountDepositByAgeGroups(),
           'revenueHistory' => $reporter->getRevenueReportHistory(),
        ]);
    }
}
