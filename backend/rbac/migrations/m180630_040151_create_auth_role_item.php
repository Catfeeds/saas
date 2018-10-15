<?php

use yii\db\Migration;

/**
 * Class m180630_040151_create_auth_role_item
 */
class m180630_040151_create_auth_role_item extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOption = null;
        if ($this->db->driverName === 'mysql') {
            $tableOption = "COMMENT = '权限：角色关联表' CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        }
        $this->createTable('{{%auth_role_item}}', [
            'auth_item' => $this->string(200)->notNull()->comment("低级角色"),
            'role_id' => $this->bigInteger()->notNull()->comment('高级角色ID'),
            'create_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment("修改时间"),
            'PRIMARY KEY ([[auth_item]], [[role_id]])',
        ], $tableOption);

    }

    public function down()
    {
        $this->dropTable('{{%auth_role_item}}');
    }
}
