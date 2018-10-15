
<!--
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/11/30
 * Time: 17:39
  *content:新增课程和修改课种
 -->
<!--新增页面-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorGreen" id="myModalLabel" >
                    添加课种
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group titleNameGrey" >
                    <span class="colorRed">*</span>课种名称
                </div>
                <div class="form-group text-center mL120" >
                    <input type="text" ng-model="course.name" value="" class="form-control actions" id=""
                           placeholder="请输入课种名称">
                </div>
                <div class="form-group titleNameGrey">
                    <span class="colorRed">*</span>课程类型
                </div>
                <div class="form-group text-center mL120" >
                    <select class="form-control actions colorGrey"  ng-model="course.class_type"  ng-change="theSearchType(course.class_type)"  >
                        <option value="" >请选择课程类型</option>
                        <option value="1" >私教课种</option>
                        <option value="2" >团教课种</option>
                    </select>
                </div>
                <div class="form-group titleNameGrey" >
                    <span class="colorRed">*</span>上级分类
                </div>
                <div class="form-group text-center mL120" >
                    <select class="form-control actions colorGrey"  ng-model="course.pid"  name="select">
                        <option value="choose">请选择上级分类</option>
                        <option value="" ng-selected="type"  >顶级分类</option>
                        <option ng-repeat="item in Myitems" value="{{item.id}}">{{item.name}}</option>
                    </select>
                </div>
                <div class="form-group titleNameGrey" >课种介绍</div>
                <div class="form-group mL120" >
                <textarea placeholder="请输入课种介绍" style="resize: none;" class="form-control actions colorGrey mL0"
                          ng-model="course.desrc">
                </textarea>
                </div>
                <div class="form-group mL120" >
                    <img ng-if="course.pic == null || course.pic == ''" ng-src="/plugins/class/img/22.png" class="wh100">
                    <img ng-if="course.pic != null && course.pic != ''" ng-src="{{course.pic}}" class="wh100">
                </div>
                <div class="input-file ladda-button btn ng-empty uploader" id="imgBorder" style="margin-left: 317px;margin-top: -154px"
                     ngf-drop=""
                     ladda="uploading"
                     ngf-select="uploadCover($file)"
                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                    <p  class="text-center addCss">+</p>
                </div>
            </div>
            <div class="modal-footer">
                <button style="width: 100px;" type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button style="width: 100px;" type="button" class="btn btn-success "
                        ng-click="addCourse()">完成
                </button>
            </div>
        </div>
    </div>
</div>

<!--修改页面-->
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorGreen" id="myModalLabel" >
                    修改课种信息
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>课种名称</div>
                <div class="form-group text-center mL120" >
                    <input type="text" class="form-control actions" id="" ng-model=datas.name placeholder="请输入课种名称">
                    <input ng-model="datas._csrf" id="_csrf" type="hidden"
                           name="<?= \Yii::$app->request->csrfParam; ?>"
                           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    <input type="hidden" ng-model=datas.id>
                </div>
                <div class="form-group colorGrey mL120" ><span class="colorRed">*</span>课程类型</div>
                <select class="form-control actions colorGrey mL120"  ng-model=datas.class_type ng-change="searchType(datas.class_type)">
                    <option value=""  >请选择课程类型</option>
                    <option value="1" >私教课种</option>
                    <option value="2" >团教课种</option>
                </select>
                <div class="form-group colorGrey mL120 mT12" ><span class="colorRed">*</span>上级分类</div>
                <div class="form-group text-center mL120 mT12" >
                    <select class="form-control actions colorGrey" ng-model="datas.pid" >
                        <option value="choose">请选择分类</option>
                        <option value="0">顶级分类</option>
                        <option ng-repeat="item in Myitems"
                                value="{{item.id}}"
                                ng-disabled="item | attrOption:datas"
                        >
                            {{item.name}}
                        </option>
                    </select>
                </div>
                <div class="form-group colorGrey mL120" >课种介绍</div>
                <div class="form-group mL120" >
                <textarea style="resize: none;" placeholder="请输入课种介绍" class="form-control actions colorGrey mL0"
                          ng-model=datas.course_desrc>这款瑜伽恨适合养生。
                </textarea>
                </div>
                <div class="form-group">
                    <img class="mL120 wh100" ng-if="datas.pic != '' && datas.pic != null" ng-src="{{datas.pic}}"  >
                    <img class="mL120 wh100" ng-if="datas.pic == '' || datas.pic == null" ng-src="/plugins/class/img/22.png"  >
                </div>
                <div class="input-file ladda-button btn ng-empty uploader" id="imgFlagClass"
                     ngf-drop="uploadCover($file,'update')"
                     ladda="uploading"
                     ngf-select="uploadCover($file,'update')"
                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                    <p  class="text-center addCss">+</p>
                </div>
            </div>
            <div class="modal-footer">
                    <button style="width: 100px;" type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button style="width: 100px;" type="button" class="btn btn-success"  ng-click="update()">完成</button>
            </div>
        </div>
    </div>
</div>
