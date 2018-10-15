<div class="row" style="margin-left: 0;margin-right: 0; display: flex;align-items: center;" ng-if="pages != ''&& pages != undefined " >
    <section  style=" font-size: 14px;padding-left: 20px;padding-right: 0;" class="col-sm-2">
        第<input style="width: 50px;padding: 4px 4px;height: 24px;border-radius: 3px;border:solid 1px #E5E5E5;" type="number" min="1" id="PageHomeNumFlag" class="" inputnum placeholder="几" ng-model="pageNum">页
        <button class="btn btn-primary btn-sm" ng-click="skipPage(pageNum)">跳转</button>
    </section>
    <div class="col-sm-10" style="padding-left: 0;padding-right: 0;">
        <?= $this->render('@app/views/common/pagination.php'); ?>
    </div>
</div>