<?php

use yii\db\Migration;

/**
 * Class m180815_113126_add_cloud_company
 */
class m180815_113126_add_cloud_company extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('{{%company}}', 'type',"tinyint(1) unsigned DEFAULT '0' COMMENT '健身房类型(1-综合，2-瑜伽，3-舞蹈，4-私教工作室)'");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%company}}','type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180815_113126_add_cloud_company cannot be reverted.\n";

        return false;
    }
    */
}
