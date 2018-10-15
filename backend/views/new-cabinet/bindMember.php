<!--    绑定会员模态框-->
<div class="modal fade" id="bindingUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="searchMemberModal" >搜索会员</h2>
                <form class="">
                    <div class="form-group searchMemberModalDiv">
<!--                        <input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" class="form-control searchMemberModalInput" ng-model="keywords" ng-keyup="enterSearch($event)" placeholder="请输入手机号和会员卡号进行搜索"/>-->
                        <input type="text" class="form-control searchMemberModalInput" ng-model="keywords" ng-keyup="enterSearch($event)" placeholder="请输入手机号和会员卡号进行搜索"/>
                        <button class="btn btn-success searchMemberModalBtn"  ng-click="searchMember()" ><span class="glyphicon glyphicon-search f20" ></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>