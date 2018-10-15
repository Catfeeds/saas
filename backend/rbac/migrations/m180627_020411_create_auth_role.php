<?php

use yii\db\Migration;

/**
 * Class m180627_020411_create_auth_role
 */
class m180627_020411_create_auth_role extends Migration
{
    public function up()
    {
        $tableOption = null;
        if ($this->db->driverName === 'mysql') {
            $tableOption = "COMMENT = '权限：高级角色表' CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        }
        $this->createTable('{{%auth_role}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('自增ID'),
            'name' => $this->string(200)->notNull()->comment("高级角色"),
            'company_id' => $this->integer()->notNull()->comment('公司ID'),
            'create_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment("修改时间"),
            'derive_id' => $this->bigInteger()->notNull()->defaultValue(0)->comment("派生高级角色ID"),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(2)->comment('是否分配权限; 1(已分配) 2(未分配)'),
        ], $tableOption);

        $this->addColumn('{{%auth_role}}', 'venue_id', 'JSON comment "可访问的场馆ID"');
        $this->createIndex('index_company_id', '{{%auth_role}}', 'company_id');
    }

    public function down()
    {
        $this->dropTable('{{%auth_role}}');
    }
}
