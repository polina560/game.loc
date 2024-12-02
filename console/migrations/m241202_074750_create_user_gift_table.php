<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_gift}}`.
 */
class m241202_074750_create_user_gift_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    final public function safeUp()
    {
        $this->createTable('{{%user_gift}}', [
            'id' => $this->primaryKey(),
            'id_gift' => $this->integer()->notNull()->comment('ID подарка'),
            'id_user' => $this->integer()->notNull()->comment('ID пользователя'),
        ]);

        $this->addForeignKey('FK_gift', '{{%user_gift}}', 'id_gift', '{{%gift}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_user', '{{%user_gift}}', 'id_user', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    final public function safeDown()
    {
        $this->dropTable('{{%user_gift}}');
    }
}
