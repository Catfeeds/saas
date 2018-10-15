<?php if(isset($attr) && \common\models\Func::autoGeneration()): ?>
<div class="form-group" title="需要数据迁移后在生成">
    <button  style="right: -939px;margin-top: -223px;position: relative" class="btn btn-info btn-sm ladda-button" ladda="loadMember" ng-click="setMember()">批量生成会员</button>
</div>
<?php endif; ?>