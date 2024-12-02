<?php

use common\models\Setting;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_ext}}`.
 */
class m241202_081549_add_attempt_count_column_to_user_ext_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $setting = Setting::findOne(['parameter' => 'attempts_count'])->value;
        $this->addColumn('{{%user_ext}}', 'attempts',
            $this->integer()->defaultValue($setting)->comment('Счетчик попыток')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_ext}}', 'attempts');
    }
}
