<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */
declare(strict_types = 1);

namespace console\controllers;

use backend\models\Customer;
use backend\models\DepositAccount;
use backend\models\Transaction;
use Faker\Factory;
use Faker\Generator;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;
use backend\services\interfaces\ChargeServiceInterface;

/**
 * Class SeedController
 *
 * @package console\controllers
 */
class SeedController extends Controller
{
    /** @var Generator */
    private $faker;

    /**
     * SeedController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param array  $config
     */
    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->faker = Factory::create();
    }

    /**
     * Generate customers.
     *
     * @param int $amount
     *
     * @throws \Exception
     */
    public function actionCustomers(int $amount = 100): void
    {
        $this->stdout("Start generating a customers\n", Console::BOLD);

        for ($i = 0; $i < $amount; $i++) {
            $gender = $this->faker->randomElement(['male', 'female']);
            $customer = new Customer();
            $customer->id_number = (string)$this->faker->numerify('##########');
            $customer->first_name = $this->faker->firstName($gender);
            $customer->last_name = $this->faker->lastName;
            $customer->gender = substr($gender, 0, 1);
            $customer->date_of_birth = $this->faker->date();
            $customer->save();
        }

        $this->stdout("Customers have been generated\n", Console::BOLD);
    }

    /**
     * Generate deposit accounts.
     *
     * @param int $amount
     *
     * @throws \Exception
     */
    public function actionDepositAccounts(int $amount = 1000): void
    {
        $this->stdout("Start generating a deposit accounts\n", Console::BOLD);

        $customerIds = Customer::getAllIds();
        for ($i = 0; $i < $amount; $i++) {
            $depositAccount = new DepositAccount();
            $depositAccount->avail_balance = random_int(1, 10000);
            $depositAccount->interest_rate = random_int(1, 100);
            $depositAccount->open_date = $this->faker->date();
            $depositAccount->open_day = explode('-', $depositAccount->open_date)[2] ?? '';
            $depositAccount->status = random_int(DepositAccount::STATUS_CLOSED, DepositAccount::STATUS_OPENED);
            $depositAccount->customer_id = array_rand($customerIds, 1);
            $depositAccount->save();
        }

        $this->stdout("Deposit accounts have been generated\n", Console::BOLD);
    }

    /**
     * Generate transactions.
     *
     * @param int $amount
     *
     * @throws \Exception
     */
    public function actionTransactions(int $amount = 1000): void
    {
        $this->stdout("Start generating a transactions\n", Console::BOLD);

        $depositAccountIds = DepositAccount::getAllIds();
        for ($i = 0; $i < $amount; $i++) {
            $depositAccount = new Transaction();
            $depositAccount->amount = random_int(
                ChargeServiceInterface::MAINTENANCE_FEE_FIXED_MIN,
                ChargeServiceInterface::MAINTENANCE_FEE_FIXED_MAX
            );
            $depositAccount->type = array_rand(Transaction::TYPES, 1);
            $depositAccount->deposit_account_id = array_rand($depositAccountIds, 1);
            $depositAccount->created_at = $depositAccount->updated_at = \random_int(1451606400, time());
            $depositAccount->save();
        }

        $this->stdout("Transactions have been generated\n", Console::BOLD);
    }

    /**
     * Generates all needed data.
     *
     * @throws \Exception
     */
    public function actionEverything(): void
    {
        $this->actionCustomers();
        $this->actionDepositAccounts();
        $this->actionTransactions();
    }
}