<?php

use yii\db\Migration;

/**
 * Class m180630_035144_create_auth_role_child
 */
class m180630_035144_create_auth_role_child extends Migration
{
    public function up()
    {
        $tableOption = null;
        if ($this->db->driverName === 'mysql') {
            $tableOption = "COMMENT = '权限：用户高级角色关联表' CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        }
        $this->createTable('{{%auth_role_child}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('自增ID'),
            'user_id' => $this->bigInteger()->unique()->comment("用户ID"),
            'role_id' => $this->bigInteger()->notNull()->comment('高级角色ID'),
            'create_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment("修改时间"),
        ], $tableOption);

        $this->createIndex('index_role_id', '{{%auth_role_child}}', 'role_id');
    }

    public function down()
    {
        $this->dropTable('{{%auth_role_child}}');
    }
}
