<div class="row" style="margin-bottom:-20px;">
    <label class="strongRed">*</label>
    <dl class="m-select" id="AreaSelector">
        <dt>--请选择课程--</dt>
        <dd class="region" style="height: 210px; display: none; z-index:99999;">
            <input type="hidden" id="courseId" value="">
            <ul class="tab">
                <li class="on off">请选择</li>
            </ul>
            <div class="tab-con clearfix">
            </div>
        </dd>
    </dl>
</div>
<script type="text/javascript">
    $(function () {
        var $dt       = '#AreaSelector';
        var $dd       = $($dt).find('dt');
        var $courseId = $('#courseId');
        var $da       = 'div.tab-con a';
        var $ul       = $('ul.tab li:last');
        var url       = '/class/get-course-by-pid?pid=0&type=2';
        $(document).off('click',$dt).on('click',$dt,function () {
            if($ul.data('pid')){
                $ul.addClass('on');
            }
            http(url);
            $('.region').css('display','block');
            return false;
        });

        var http = function (url,$pid = '') {
             $.getJSON(url,function (data) {
                if(data.length > 0){
                    var html = '';
                    for(var i = 0 ;i<data.length;i++){
                        html += '<a title="'+data[i].name+'" href="javascript:;" data-id="'+data[i].id+'">'+data[i].name+'</a>';
                    }
                    $('div.tab-con').html(html);
                }else{
                    var text = '瑜伽|基础瑜伽|高温瑜珈';
                    $ul.remove();
                    $dd.html(text);
                    $coPid  = $pid;
                    $('.region').css('display','none');
                    $courseId.val($pid);
                }
                 return false;
             });
        };
        $(document).off('click',$da).on('click',$da,function () {
            var $pid = $(this).data('id');
            var $pName = $(this).attr('title');
            var liHtml = '<li class="" data-pid="'+$pid+'">'+$pName+'</li>';
            $ul.before(liHtml);
            var url  = '/class/get-course-by-pid?pid='+$pid+'&type=2';
            http(url,$pid);
            return false;
        });
        $(document).off('click','ui.tab li').on('click','ui.tab li',function () {
             if(!$(this).hasClass('off')){
                 var $pid = $(this).data('pid');
                 var url  = '/class/get-course-by-pid?pid='+$pid+'&type=2';
                 http(url);
             }
            return false;
        });
    })
</script>