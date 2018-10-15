<div id="venue-detail" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">场馆详情</h4>
            </div>
            <div class="modal-body MTPT0">
                <span class="col-md-11 col-lg-11">
                    <button type="button" class="btn btn-info btn-sm pull-right" ng-click="get_venue(venue_role_id)" data-toggle="modal" data-target="#check-venue">新增场馆</button>
                </span>
                <table class="table">
                    <tr>
                        <th style="line-height: 2px; padding: 10px;"><span class="glyphicon glyphicon-home"
                                                                           aria-hidden="true"></span><b>&nbsp;场馆</b>
                        </th>
                        <th style="text-align: left; line-height: 2px; padding: 10px;"><span
                                    class="glyphicon glyphicon-wrench"
                                    aria-hidden="true"></span><b>&nbsp;操作</b>
                        </th>
                    </tr>
                    <tr class="CP-parent" ng-repeat="item in venue_details">
                        <td style="line-height: 2px; padding: 10px;">{{item.name}}</td>
                        <td style="text-align: left; line-height: 2px; padding: 10px;">
                               <span class="label label-danger PT in-border"
                                     ng-click="del_venue(venue_role_id, item.id)">
                                   删除
                               </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>