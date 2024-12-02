<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gift}}`.
 */
class m241202_074726_create_gift_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    final public function safeUp()
    {
        $this->createTable('{{%gift}}', [
            'id' => 'int NOT NULL AUTO_INCREMENT',
            'title' => $this->string()->notNull()->comment('Название'),
            'cashback' => $this->integer()->comment('Кол-во кэшбэка'),
            'chance' => $this->integer()->comment('Дата измененияШанс выпадения'),
            'PRIMARY KEY(id)'

        ]);
    }

    /**
     * {@inheritdoc}
     */
    final public function safeDown()
    {
        $this->dropTable('{{%gift}}');
    }
}
