<?php

use yii\db\Migration;

/**
 * Class m180626_072854_create_auth_module
 */
class m180626_072854_create_auth_module extends Migration
{
    public function up()
    {
        $tableOption = null;
        if ($this->db->driverName === 'mysql') {
            $tableOption = "COMMENT = '权限：模块表' CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        }
        $this->createTable('{{%auth_module}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('自增ID'),
            'name' => $this->string(200)->notNull()->unique()->comment("模块,功能名称"),
            'route' => $this->string(200)->notNull()->defaultValue('')->comment('路由'),
            'pid' => $this->smallInteger(6)->notNull()->defaultValue(0)->comment("父ID"),
            'icon' => $this->string(50)->defaultValue("")->comment('图标'),
            'desc' => $this->string(200)->notNull()->defaultValue('')->comment("描述"),
            'response_type' => $this->smallInteger(3)->notNull()->defaultValue(2)->comment("响应数据类型,1: HTML 2: JSON"),
            'create_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment("修改时间"),
            'status' => $this->smallInteger(3)->notNull()->defaultValue(2)->comment("是否已添加角色,权限. 1:已添加; 2:未添加"),
        ], $tableOption);

        $this->createIndex('index_status', '{{%auth_module}}', 'status');
    }

    public function down()
    {
        $this->dropTable('{{%auth_module}}');
    }
}
