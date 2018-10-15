<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/5 0005
 * Time: 16:12
 */
 -->
<!--广告详情模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="advertisingDetailModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="overflow-y: scroll;height: 300px;">
                    <table class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                           <th>场馆</th>
                           <th>曝光量</th>
                           <th>点击量</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="w in advertisingDetailList">
                            <td>{{w.name | noData:''}}</td>
                            <td>{{w.show_num | noData:''}}</td>
                            <td>{{w.click_num | noData:''}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'advertisingDetailNoData','text'=>'暂无数据','href'=>true]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
