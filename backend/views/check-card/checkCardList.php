<?php if(!empty($data)){ ;?>
    <?php foreach($data as $key=>$value){ ?>

        <div class="ibox">
            <div class="ibox-title">
                <h5>团课预约</h5>
            </div>
            <div class="ibox-content pd0">
                <table class="table table-striped table-bordered table-hover dataTables-example dataTable" style="overflow-y: scroll;max-height: 220px;: 300px">
                    <thead>
                    <tr>
                        <th>课程</th>
                        <th>时间</th>
                        <th>场地</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?=$value['id']?></td>
                        <td>
                            <?=date('Y-m-d',$value['start'])?>-<?=date('Y-m-d',$value['end'])?>
                        </td>

                        <td><?=$value['classroom']['name']?></td>

                        <?php if($value['is_print_receipt'] == 2){
                            echo "<td>未打印</td>";
                        }?>
                        <?php if($value['is_print_receipt'] == 1){
                            echo "<td>已打印</td>";

                        }?>
                        <?php if($value['is_print_receipt'] != 1 && $value['is_print_receipt'] != 2){
                            echo "<td>未打印</td>";

                        }?>

                        <td class="checkPrint">
                            <button ng-disabled="(item.start | checkPrint:printSetting:1)" class="btn btn-default  btn-sm" ng-click="aboutPrints(item)">打印</button>
                            <button data-id="<?=$value['id']?>")">取消预约</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?= $this->render('@app/views/common/nodata.php', ['name' => 'aboutNoOneData', 'text' => '无预约记录', 'href' => true]); ?>
            </div>
        </div>
    <?php } ?>

<?php } ?>