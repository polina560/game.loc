<?php

use yii\db\Migration;

/**
 * Class m241202_080947_insert_attempt_count_to_settings_table
 */
class m241202_080947_insert_attempt_count_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', [
            'parameter' => 'attempts_count',
            'value' => 10,
            'description' => 'Кол-во попыток у пользователей',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->batchInsert('{{%setting}}', ['parameter', 'value', 'description'], [
            ['attempts_count', 10, 'Кол-во попыток у пользователей'],

        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241202_080947_insert_attempt_count_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
