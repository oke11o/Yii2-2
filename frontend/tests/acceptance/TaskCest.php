<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class TaskCest
{
    public function checkTask(AcceptanceTester $I)
    {
        $I->amOnPage('/task');
        $I->see('Tasks Tracker');

        $I->see('Выберите период, за который хотите просмотреть задачи:');
        $I->see('Начало периода');
        $I->seeElement('#dateform-datebegin');
        $I->see('Конец периода');
        $I->seeElement('#dateform-dateend');
        $I->wait(2);

        $I->fillField('#dateform-datebegin', '2019-02-01 00:00:00');
        $I->click('#dateform-datebegin');
        $I->wait(2);
        $I->fillField('#dateform-dateend', '2019-02-05 00:00:00');
        $I->click('#dateform-dateend');
        $I->wait(2);
        $I->click('Показать задачи');
        $I->wait(1);
        $I->seeNumberOfElements(['class' => 'tasks-item'], 3);
        $I->wait(3);

        $I->click('Создать новую задачу');
        $I->see('Введите данные для создания новой задачи:');
        $I->wait(3);
    }
}
