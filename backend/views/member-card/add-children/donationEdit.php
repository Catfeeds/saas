<!--/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/10/31
 * Time: 15:37
 *content:赠品修改
 */-->
<div class="col-sm-12 pdLR0 donationBox removeDiv">
    <div class="col-sm-5  heightCenter mT20">
        <span class="width100 text-right " style="margin-right: 10px;">赠品名称</span>
        <select  class="form-control cp w200 selectPd selectGive123"  ng-change="selectDonation(donationKey<?=$num;?>)" ng-model="donationKey<?=$num;?>" >
            <option value="" >请选择赠品</option>
            <option value="{{donation.id}}"
                    ng-repeat="donation in optionDonation"
                    ng-disabled="donation.id | attrVenue:giveShopArray"
            >{{donation.goods_name}}</option>
        </select>
    </div>
    <div class="col-sm-5  heightCenter mT20">
        <span class="width100 text-right" style="margin-right: 10px;">商品数量</span>
        <div class=" cp h32 inputUnlimited  " >
            <input   type="number" inputnum min="0" name='times' placeholder="0" class=" form-control w200 pT0">
            <div class="checkbox i-checks checkbox-inline t4" >
                <label>
                    <input type="checkbox" value=""> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="col-sm-2  heightCenter mT20">
        <button   type="button" class="btn btn-sm btn-default  removeHtml"  ng-click="removeGIveClick()" data-remove="removeDiv">删除</button>
    </div>
</div>
