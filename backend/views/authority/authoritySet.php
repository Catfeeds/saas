<?php
use backend\assets\AuthCtrlAsset;
AuthCtrlAsset::register($this);
$this->title = '权限设置';
?>
<main class="main animated fadeIn">
    <div class="container">
        <div class="row ">
            <div class="col-md-12  col-sm-12">
                <h4 class="f28">权限管理</h4>
            </div>
            <div class="col-md-12  col-sm-12">
                <h6 class="col-md-12  col-sm-12 f16" style="margin-top: 10px;margin-bottom: 10px">选择角色</h6>
                <div class="form-group">
                    <div class="col-sm-3">
                        <select id="selecRole" class="form-control m-b" name="account" >
                            <option>请选择角色</option>
                            <option>总监</option>
                            <option>经理</option>
                            <option>教练</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row fadeIn" >
            <h5 class="col-md-12  col-sm-12 f20" style="margin-bottom: 10px">权限设置</h5>
            <div class="col-md-12  col-sm-12 f16">
                <div  class="col-md-6 col-sm-6">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">组织架构管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="organizationCheckBox1" value="option1">
                                <label for="organizationCheckBox1">可修改</label>
                            </div>
                            <div class="checkbox i-checks checkbox-success checkbox-inline">
                                <input type="checkbox" id="organizationCheckBox2" value="option1">
                                <label for="organizationCheckBox2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="organizationCheckBox3" value="option1">
                                <label for="organizationCheckBox3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">会员管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="memberCheckBox1" value="option1">
                                <label for="memberCheckBox1">可修改</label>
                            </div>
                            <div class="checkbox i-checks checkbox-success checkbox-inline">
                                <input type="checkbox" id="memberCheckBox2" value="option1" >
                                <label for="memberCheckBox2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="memberCheckBox3" value="option1">
                                <label for="memberCheckBox3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">套餐管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="packageCheckBox1" value="option1">
                                <label for="packageCheckBox1">可修改</label>
                            </div>
                            <div class="checkbox i-checks  checkbox-inline">
                                <input type="checkbox" id="packageCheckBox2" value="option1" >
                                <label for="packageCheckBox2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="packageCheckBox3" value="option1">
                                <label for="packageCheckBox3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">员工管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="userCheckBox1" value="option1">
                                <label for="userCheckBox1">可修改</label>
                            </div>
                            <div class="checkbox  i-checks checkbox-inline">
                                <input type="checkbox" id="userCheckBox2" value="option1" >
                                <label for="userCheckBox2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="userCheckBox3" value="option1">
                                <label for="userCheckBox3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">会员卡管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="memberCardCheck1" value="option1">
                                <label for="memberCardCheck1">可修改</label>
                            </div>
                            <div class="checkbox  i-checks checkbox-inline">
                                <input type="checkbox" id="memberCardCheck2" value="option1" >
                                <label for="memberCardCheck2">可删除</label>
                            </div>
                            <div class="checkbox  i-checks checkbox-inline">
                                <input type="checkbox" id="memberCardCheck3" value="option1">
                                <label for="memberCardCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">评价管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="evaluateCheck1" value="option1">
                                <label for="evaluateCheck1">可修改</label>
                            </div>
                            <div class="checkbox  i-checks checkbox-inline">
                                <input type="checkbox" id="evaluateCheck2" value="option1" >
                                <label for="evaluateCheck2">可删除</label>
                            </div>
                            <div class="checkbox  i-checks checkbox-inline">
                                <input type="checkbox" id="evaluateCheck3" value="option1">
                                <label for="evaluateCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">课种管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="classCheck1" value="option1">
                                <label for="classCheck1">可修改</label>
                            </div>
                            <div class="checkbox i-checks  checkbox-inline">
                                <input type="checkbox" id="classCheck2" value="option1" >
                                <label for="classCheck2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="classCheck3" value="option1">
                                <label for="classCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">衣柜管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="chestCheck1" value="option1">
                                <label for="chestCheck1">可修改</label>
                            </div>
                            <div class="checkbox i-checks  checkbox-inline">
                                <input type="checkbox" id="chestCheck2" value="option1" >
                                <label for="chestCheck2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="chestCheck3" value="option1">
                                <label for="chestCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">约课管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="aboutCheck1" value="option1">
                                <label for="aboutCheck1">可修改</label>
                            </div>
                            <div class="checkbox i-checks  checkbox-inline">
                                <input type="checkbox" id="aboutCheck2" value="option1">
                                <label for="aboutCheck2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="aboutCheck3" value="option1">
                                <label for="aboutCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">团课课程管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="leagueCheck1" value="option1">
                                <label for="leagueCheck1">可修改</label>
                            </div>
                            <div class="checkbox i-checks  checkbox-inline">
                                <input type="checkbox" id="leagueCheck2" value="option1" >
                                <label for="leagueCheck2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="leagueCheck3" value="option1">
                                <label for="leagueCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div  class="col-md-6 col-sm-6 mT30">
                    <div class="col-md-12  col-sm-12">
                        <div class="col-md-1 col-sm-1">
                            <div>
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-11">私教课程管理</div>
                        <div class="col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 mT10">
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="privateCheck1" value="option1">
                                <label for="privateCheck1">可修改</label>
                            </div>
                            <div class="checkbox i-checks  checkbox-inline">
                                <input type="checkbox" id="privateCheck2" value="option1" >
                                <label for="privateCheck2">可删除</label>
                            </div>
                            <div class="checkbox i-checks checkbox-inline">
                                <input type="checkbox" id="privateCheck3" value="option1">
                                <label for="privateCheck3">可添加</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix" >
            <a href="/authority/index?&c=40" style="width: 100px;margin: 50px;"  type="button" class="btn btn-primary fl">返回</a>
            <a href="/authority/index?&c=40" style="width: 100px;margin: 50px;"  type="button" class="btn btn-success fr">保存</a>
        </div>
    </div>
</main>
