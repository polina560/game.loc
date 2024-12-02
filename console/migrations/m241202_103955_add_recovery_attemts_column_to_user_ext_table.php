<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_ext}}`.
 */
class m241202_103955_add_recovery_attemts_column_to_user_ext_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_ext}}', 'recovery_attempts',
            $this->integer()->defaultValue(time())->comment('Время восстановления попыток')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_ext}}', 'recovery_attempts');
    }
}
