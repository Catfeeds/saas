RBAC服务说明
===============
一. 【项目基础配置】
---------------
+ *backend/config/main.php文件配置, 引入rbac服务到项目中*
>```
>1.1  RBAC服务和项目接口配置文件 *config.php*
>
>1.2 'authManager' =>[
>'class' => 'yii\rbac\DbManager', //配置yii2底层rbac服务
>], 
>
>1.3 'as permission' => 'backend\\rbac\\PermissionBehaviors', //配置access control 路由访问权限控制
>
>1.4 'rbac' => [
>     'class' => 'backend\\rbac\\Module', //注册RBAC服务
>     ], 
>```     
二. 【项目数据迁移配置】
---------------
+ *backend/console/config/main.php文件components配置*
>```
>2.1 'authManager' => [
> 'class' => 'yii\rbac\DbManager', //模块迁移配置
> ], 
>
>2.2 yii migrate --migrationPath=@backend/rbac/migrations; //模块迁移命令
>```
三. 【接入项目】
---------------
>```
>3.1 \backend\rbac\Config::isShow(控件路由) //页面元素是否有权限显示
>
>     例如 :
>          <?php if(\backend\rbac\Config::isShow('check-card/check-card-number')): ?>
>          
>          <div class="btn-group">
>          <button class="btn btn-sm btn-default">新增会员</button>
>          </div>
>          
>          <?php endif; ?>
>          
>3.2 backend/rbac/PermissionBehaviors.php //access control 路由访问权限控制文件
>
>     说明 :
>         /**
>          * @desc <未添加基础角色的菜单或按钮> 不受访问控制 即: <公共路由和辅助路由>不添加权限限制!!
>          *       <拥有此菜单或按钮权限的用户> 不受访问控制
>          * @method accessControl
>          * @return \redirect 302 | JSON(string)
>          */
>          
>3.3 路由: /rbac/auth/top   //获取项目用户可访问的菜单接口
>
>     说明 :   
>     //@method GET      
>
>3.4 其他
>
>     /**
>      * //用户表模版
>      * m180716_083904_create_user
>      * //公司组织表模版
>      * m180716_083841_create_organization 
>      */  
>
>3.5 属性配置详见Config.php文件`
>```
四. 【rbac服务底层架构介绍】
---------------
+ 查看[开发者配置](http://qasaas.xingfufit.cn/rbac/main)
+ 查看[用户配置](http://qasaas.xingfufit.cn/rbac/auth/index)
>```
>4.1 底层yii2底层rbac介绍(角色,权限,规则):
>
>      a. 模块是yii2 rbac底层权限的模版和映射.    
>      b. 开发者配置, 添加基础权限, 使系统模块和页面元素受yii2底层rbac控制.
>      c. 开发者配置, 添加基础权限, 建立底层rbac权限\用户\角色关系; 模块名和功能名是yii2 rbac角色名, 模块路由和功能路由是yii2 rbac权限.
>      d. 路由控制详见 backend/rbac/PermissionBehaviors.php文件
>      e. 页面元素控制详见 backend/rbac/cores/PublicAbstraction.php文件
>     
>4.2 rbac项目扩展
>
>     原因:
>      yii2 rbac是基础rbac权限控制, 操作过于复杂,不适配现有项目.
>      
>      方案:
>      1. 添加中间层.
>     描述: 对yii2 rbac基础角色扩展, 使用项目组织角色作为rbac高级角色.
>      
>      2. 建立新的权限\用户\角色关系
>      描述: 以yii2 底层rbac角色作为项目高级角色的权限, 项目添加角色绑定用户的同时, 操作底层rbac,建立yii2 底层rbac权限\用户\角色关系.
>      
>      3. 数据表介绍.
>      描述:
>        a: 高级角色表 auth_role
>        b: 模块表 auth_module
>        c: 高级角色和底层rbac角色关系表 auth_role_item
>        d: 高级角色和系统用户关系表 auth_role_child
>        
>      4. 依赖注入机制 (依赖倒置,控制反转)
>      描述:
>        a. 静态文件分离, rbac服务提供自带的前端插件, 实现项目和rbac服务静态化分离; 同时也提供自定义配置的接口.
>        b. cores文件下, ItemInterface.php文件提供项目必须接入的接口, PublicAbstaction.php文件提供rbac服务模块共用接口, Config.php提供rbac服务配置以及接入项目配置等.
>        
>      5. 优缺点
>      描述:
>        a. 开发者配置和用户配置分离, 系统用户分配权限,操作流程简单易用.
>        b. rbac服务提供路由和页面元素的双向控制.
>        c. 角色权限分配契合派生原则, 以公司职位流程作为权限分配流程模版, 由高到低, 权限也是由高到低, 另外, 服务还提供新增和删除权限的功能来适配特殊情况和权限.     
>```
        

          
            
