<!-- 添加赠品表单框 -->
    <div class="row removeDiv">
        <div class="col-sm-4 clearfix">
            <span class="fl mT5">&nbsp;商品名称&emsp;&emsp;</span>
            <select ng-if="donationStatus == true" class="form-control cp fl" style="padding: 4px 12px;" >
                <option value="">请选择商品</option>
                <option
                    value="{{venue.id}}"
                    ng-repeat="venue in optionDonation">{{venue.goods_name}}</option>
            </select>
            <select ng-if="donationStatus == false" class="form-control cp fl" style="padding: 4px 12px;" >
                <option value="">请选择商品</option>
                <option value="" disabled style="color:red;">{{optionDonation}}</option>
            </select>
        </div>
        <div class="col-sm-4 clearfix">
            <span class="fl mT5">&nbsp;商品数量&emsp;&emsp;</span>
            <input type="text" inputnum min="0" name="giftNum" placeholder="0" class="form-control cp fl">
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'donationHtml')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>
        </div>
    </div>
