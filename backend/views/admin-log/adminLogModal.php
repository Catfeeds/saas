<!--
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/5/8
 * Time: 17:12
 */
-->
<div class="modal fade" tabindex="-1" role="dialog" id="adminLogModal">
    <div class="modal-dialog  modal-lg" role="document" style="width: 80%;height:80%">
        <div class="modal-content">
            <div class="modal-header clearFix">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="text-center panel-heading">日志详情</h2>
            </div>
            <div class="modal-body">
                <div class="row" style="overflow-x: auto">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" style="width: 100%">
                            <tr>
                                <th width="100px">ID</th>
                                <td>{{logInfo.id | noData:''}}</td>
                            </tr>
                            <tr>
                                <th>路由</th>
                                <td>{{logInfo.route | noData:''}}</td>
                            </tr>
                            <tr>
                                <th>详情</th>
                                <td>{{logInfo.description | noData:''}}</td>
                            </tr>
                            <tr>
                                <th>操作时间	</th>
                                <td>{{logInfo.created_at | noData:''}}</td>
                            </tr>
                            <tr>
                                <th>操作人</th>
                                <td>{{logInfo.username | noData:''}}</td>
                            </tr>
                            <tr>
                                <th>操作人ip	</th>
                                <td>{{logInfo.ip | noData:''}}</td>
                            </tr>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'adminLogModalPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'adminLogModalNoData','text'=>'暂无数据','href'=>true]);?>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px">关闭</button>
            </div>
        </div>
    </div>
</div