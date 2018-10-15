<!--   预约会员 -->
<div class="modal fade in" id="searchMember" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header searchMemberHeader">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body searchMemberBody">
                <div class="row">
                    <div class="col-sm-12 text-center searchMemberBodyDiv1">搜索会员</div>
                    <div class="col-sm-8 col-sm-offset-2 scheduleCourseDetailDivButton">
                        <div class="input-group">
                            <input type="number"
                                   class="form-control lineHeight7 h34"
                                   ng-model="keywords" onmousewheel="return false;" placeholder="请输入手机号进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button"
                                            ng-click="reservationMemberSearch(keywords)"
                                            class="btn btn-success">搜索</button>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>