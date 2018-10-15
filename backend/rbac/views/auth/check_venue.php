<div id="check-venue" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">选择场馆</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="stadium_label" class="col-md-2 col-lg-2 control-label"><b style="color: red;">*</b>选择场馆:</label>
                        <div class="col-md-10 col-lg-10">
                            <select class="form-control" multiple id="stadium_label">
                                <option value="{{venue.id}}" ng-repeat="venue in get_venue_data">{{venue.name}}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="add_venue(venue_role_id)">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>