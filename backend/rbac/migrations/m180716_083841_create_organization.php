<?php

use yii\db\Migration;

/**
 * Class m180716_083841_create_organization
 * 公司组织迁移模版
 */
class m180716_083841_create_organization extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
//        $tableOption = null;
//        if($this->db->driverName === 'mysql'){
//            $tableOption = 'COMMENT "公司组织表" CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//        }
//
//        $this->createTable('{{%organization}}', [
//            'id' => $this->bigPrimaryKey()->unsigned()->comment('自增ID'),
//            'pid' => $this->bigInteger()->unsigned()->comment('父ID'),
//            'name' => $this->string(200)->notNull()->comment('名称'),
//            //...拓展其他字段
//            'create_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
//            'update_at' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment("修改时间"),
//        ], $tableOption);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
//        $this->dropTable('{{%organization}}');
    }
}
