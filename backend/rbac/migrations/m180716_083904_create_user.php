<?php

use yii\db\Migration;

/**
 * Class m180716_083904_create_user
 * 用户表模版
 */
class m180716_083904_create_user extends Migration
{
    /**
     * @describe itcloudsports
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-16
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
//        $tableOptions = null;
//        if ($this->db->driverName === 'mysql') {
//            $tableOptions = "COMMENT = '系统管理员表' CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
//        }
//
//        $this->createTable('{{%admin}}', [
//            'id'                   => $this->bigPrimaryKey()->unsigned()->comment('ID自增'),
//            'username'             => $this->string()->notNull()->unique()->comment('用户名'),
//            'auth_key'             => $this->string(32)->notNull()->defaultValue("")->comment('auth验证'),
//            'password_hash'        => $this->string()->notNull()->comment('密码Hash'),
//            'password_reset_token' => $this->string()->defaultValue(""),
//            'email'                => $this->string()->notNull()->defaultValue("")->comment('邮箱'),
//            'status'               => $this->smallInteger()->defaultValue(10)->comment('状态10审核20通过'),
//            'created_at'           => $this->integer()->comment('创建时间'),
//            'updated_at'           => $this->integer()->comment('更新时间'),
//        ], $tableOptions);
//
//        $password = '123456789';
//        $password = Yii::$app->security->generatePasswordHash($password);
//        $sql = <<<'SQL'
//        INSERT INTO {{%admin}} (id, username, auth_key, password_hash, password_reset_token, email, status, created_at, updated_at)
//        VALUES (1, "admin", "", :password, "", "", 20, unix_timestamp(now()), unix_timestamp(now()));
//SQL;
//        $this->execute($sql, [':password' => $password]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
//        $this->dropTable('{{%admin}}');
    }
}
