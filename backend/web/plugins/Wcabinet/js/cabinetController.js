var app = angular.module('App').controller('cabinetCtrl', function($scope, $http, $timeout) {
	$timeout(function () {
		$('.group-ul').height($(window).height()-145 + 'px');
		$('.detialS').height($(window).height()-173 + 'px');
		$('.pp').height($(window).height()-173 + 'px');
		$('.vv').height($(window).height()-173 + 'px');
		$('.nn').height($(window).height()-207 + 'px');
		$('.nn').css('overflow-y', 'auto');
	},500)
	$scope.init1 = function () {
		$scope.num = 0; //柜子
		$scope.addCabinetMonthHtml = '';
		$scope.btnAddMuchMonth();
	};
	$scope.cabinetDetailOpen = true;
	/**
	 *将时间戳转为日期
	 * @create 2017/5/29
	 */
	$scope.getMyDate = function(str) {
		str = parseInt(str);
		if(str != "" || str != null) {
			var oDate = new Date(str);
			var oYear = oDate.getFullYear();
			var oMonth = oDate.getMonth() + 1;
			oMonth = oMonth >= 10 ? oMonth : '0' + oMonth;
			var oDay = oDate.getDate();
			oDay = oDay >= 10 ? oDay : '0' + oDay;
			var theDate = oYear + "-" + oMonth + "-" + oDay;
		} else {
			theDate = "";
		}
		return theDate
	};
    $scope.backPre = function () {
        location.href ="/new-cabinet/index?c=88class='templetA'";
    }
    //计算买柜子自然月的公共方法
    //dtstr:选择或当前日期，n表示几个月后
    $scope.countRentMonth = function (timeString, monthNum) {
        var timeSplit = timeString.split("-");
        var yy = parseInt(timeSplit[0]);
        var mm = parseInt(timeSplit[1]) - 1;
        var dd = parseInt(timeSplit[2]);
        var dt = new Date(yy, mm, dd);
        dt.setMonth(dt.getMonth() + monthNum);
        if ((dt.getFullYear() * 12 + dt.getMonth()) > (yy * 12 + mm + monthNum)) {
            dt = new Date(dt.getFullYear(), dt.getMonth(), 0);
        }
        var year = dt.getFullYear();
        var month = dt.getMonth() + 1;
        month = month <= 9 ? '0' + month : month;
        var days = dt.getDate();
        days = days <= 9 ? '0' + days : days;
        return year + "-" + month + "-" + days;
    };
    //时间戳转化为字符串
    $scope.fmtDate = function (obj) {
        var date =  new Date(obj);
        var y = 1900+date.getYear();
        var m = "0"+(date.getMonth()+1);
        var d = "0"+date.getDate();
        return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
    };
    $scope.getEndDate = function (start, add, give, type) {
        if(!add) {
            add = 0;
            $scope.cabinetEnd = start;
        }
        if(!give) {
            give = 0;
            $scope.cabinetreletEndDate = start;
        }
        if (type === 'd') {
            var month1 = parseInt(add);
            var timeString1 = $scope.getMyDate(start);
            var day = parseInt(give)*24*3600*1000;
            var countTime = $scope.countRentMonth(timeString1,month1);
            var date = Date.parse(new Date(countTime)) + parseInt(day);
            $scope.cabinetreletEndDate = $scope.fmtDate(date);
            $scope.cabinetEnd = $scope.fmtDate(date);
        }else if(type === 'm') {
            var month2 = parseInt(add) + parseInt(give);
            var timeString2 = $scope.getMyDate(start);
            $scope.cabinetreletEndDate = $scope.countRentMonth(timeString2,month2);
            $scope.cabinetEnd = $scope.countRentMonth(timeString2,month2);
        }else {
            var month3 = parseInt(add) + parseInt(give);
            var timeString3 = $scope.getMyDate(start);
            $scope.cabinetreletEndDate = $scope.countRentMonth(timeString3,month3);
            $scope.cabinetEnd = $scope.countRentMonth(timeString3,month3);
        }
    };

    //新增2018/1/6
	$scope.init3 =function () {
		$scope.num = 0;
		$scope.modifyPluginsHtml = '';
		$scope.addPlugins();
	}
	$scope.addPlugins = function() {
		$scope.htmlAttr = 'modifyPlugins';
		$scope.num  = $scope.num + 1;
		$http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
			$scope.modifyPluginsHtml = result.data.html;
		});
	}
    //更衣柜列表数据
    $scope.getWardrobeDate = function(){
        $http.get('/cabinet/filter-data').then(function(result){
        })
    }
    $scope.getWardrobeDate();
	$scope.backPre = function() {
		location.href = "/new-cabinet/index?c=88class='templetA'";
	}

	//更衣柜列表数据
	$scope.getWardrobeDate = function() {
		$http.get('/cabinet/filter-data').then(function(result) {})
	}
	$scope.getWardrobeDate();

	//点击添加区域按钮
	$scope.addArea = function() {
		$('#addArea').modal('show');
		$scope.areaName = '';
		$scope.addAreaButtonFlag = false;
	}
	//获取大上海所有的场馆
	$scope.allVenueLists = function() {
		$http.get('/cabinet/venue-cabinet').then(function(result) {
			$scope.venues = result.data;
			$scope.venueList = '';
			$scope.allCabinetTypeData();
		});

	};
	$scope.allVenueLists();
	//获取所有的柜子
	$scope.allCabinetTypeData = function() {
		$.loading.show();
		$http.get('/cabinet/get-cabinet-list?venueId=' + $scope.venueList).then(function(result) {
			$scope.allCabinet = result.data;
			$.loading.hide();
		})
	}

	//根据不同的场馆返回场馆的柜子
	$scope.selectVenue = function() {
		if($scope.venueList != '') {
			$scope.allCabinetTypeData();
		}
	}
	//获取所有的场馆
	$scope.getAllVenue = function () {
		$http.get('/site/public-venues?type=venue').then(function (response) {
			$scope.venueLists = response.data.data;
			if(!response.data.data) {
			    Message.error('系统开了会小差,请刷新重试。。。')
            }
        })
    };
    $scope.getAllVenue();
    //选择场馆
    $scope.venueSelectChange = function (venueId) {
        $scope.venueList = venueId;
        $scope.allCabinetTypeData();
    };
	//删除柜子
	$scope.CabinetDelete = function(id) {
		$http.get('/cabinet/cabinet-delete?id=' + id).then(function(result) {
			if(result.data.status == 'success') {
				$scope.replacementPages('/cabinet/home-data?typeId=' + $scope.cabinetypeId + '&cabinetNum=&cabinetModel=&cabinetType=&customerName=&cabinetEndRent=&sortType=&sortName=&page=' + $scope.cabinetDetailPage + '&per-page=8');
				Message.success('删除柜子成功！')
			} else {
				Message.warning('删除失败，请重试！')
			}
			$('#noBoundCabinet').modal('hide');
		})
	};
	//删除区域
	$scope.deleteContentBoxButton = function(id, num, event) {
		var evt = event ? event : window.event;
		evt.stopPropagation();
		if(num == 0) {
			$http.get('/cabinet/cabinet-type-delete?id=' + id).then(function(result) {
				if(result.data.status == 'success') {
					Message.success('删除成功！')
					$scope.allCabinetTypeData();
				} else {
					Message.warning(result.data.data);
				}
			})
		} else {
			Message.warning('存在已租出去的柜子，无法删除区域！')
		}
	};
	//选择场馆
	$scope.venueChange = function (venueId) {
		$scope.venueId = venueId;
		$scope.initPaths();
		$scope.getCabinetSearchData();
	};
	/**点击到期时间模态框获取到期会员数据**/
	$scope.getMemberCabinetData = function() {
		$scope.pageInitUrls = '/cabinet/member-come-due';
		$scope.getCabinetSearchData();
		$scope.cabinetTypeDatas();
	};
	$scope.getCabinetSearchData = function() {
		$.loading.show();
		$http.get($scope.pageInitUrls).then(function(response) {
			if(response.data.data != "" && response.data.data != undefined && response.data.data.length != undefined) {
				$scope.datas = response.data.data;
				$scope.cabinet = response.data.cabinetPages;
				$scope.hua = response.data.huang;
				$scope.cabinetNoDataShow = false;
			} else {
				$scope.datas = response.data.data;
				$scope.cabinet = response.data.cabinetPages;
				$scope.cabinetNoDataShow = true;
			}
			$.loading.hide();
		});
	}
	$scope.initPaths = function() {
		$scope.searchParam = $scope.searchCabinetData();
		$scope.pageInitUrls = '/cabinet/member-come-due?' + $.param($scope.searchParam);
	};
	$scope.replaceCabinetPages = function(urlPages) {
		$scope.pageInitUrls = urlPages;
		$scope.getCabinetSearchData();
	};
	/**获取选中的柜子id**/
	$scope.getCabinet = function(val) {
		$scope.cabinetTypeId = val;
		$scope.initPaths();
		$scope.getCabinetSearchData();
	}
	/**获取选中的时间**/
	$scope.getDay = function() {
		$scope.day = $scope.cabinetDay;
		$scope.initPaths();
		$scope.getCabinetSearchData();
	}
	/**处理搜索数据***/
	$scope.searchCabinetData = function() {
		return {
			cg: $scope.venueId ? $scope.venueId : null, //场馆id
			cabinetTypeId: $scope.cabinetTypeId ? $scope.cabinetTypeId : null, //区域id
			day: $scope.day ? $scope.day : null //当天当日当月
		}
	};

	/**跳转页***/
	$scope.skipPage = function(value) {
		if(value != undefined) {
			$scope.searchParam = $scope.searchCabinetData();
			$scope.pageInitUrls = '/cabinet/member-come-due?' + $.param($scope.searchParam) + '&page=' + value;
			$scope.getCabinetSearchData();
		}
	};

	/**搜索方法***/
	$scope.searchCabinetS = function() {
		$scope.initPaths();
		$scope.getCabinetSearchData();
	};
	/**获取区域下拉框***/
	$scope.cabinetTypeDatas = function() {
		$http({
			method: "get",
			url: "/cabinet/area-select"
		}).then(function(result) {
			$scope.cabinetType = result.data.cabinet;
		}, function(error) {
			Message.error("请联系工作人员");
		});
	}
	$scope.getMemberCabinetData();
	/**点击批量发送会员短信**/
	$scope.sendCabinet = function() {
		$scope.sendCabinetData = function() {
			return {
				cabinetTypeId: $scope.cabinetTypeId != undefined ? $scope.cabinetTypeId : null, //区域id
				day: $scope.day != undefined ? $scope.day : null //当天当日当月
			}
		};
		swal({
			title: "确定发送吗？",
			text: "该功能会批量给会员发送短信，请谨慎操作！",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "确定",
			cancelButtonText: "取消",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				swal.close();
				$scope.sendBtnStatus = true;
				$.loading.show();
				$http({
					url: '/cabinet/send-cabinet-data',
					method: 'POST',
					data: $.param($scope.sendCabinetData()),
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					}
				}).then(function(res) {
					if(res.data.status == 'success') {
						Message.success('发送成功');
						$scope.getCabinetSearchData();
					} else {
						Message.warning(res.data.data);
					}
					$scope.sendBtnStatus = false;
					$.loading.hide();
				})


			} else {
				$scope.sendBtnStatus = false;
				swal.close();
			}
		});


	}
	$scope.addAreaBtn = function () {
		window.location.href = '/wcabinet/add-area?v=' + $scope.venueList;
	}

	/****分页***/
	$scope.replacementPages = function(urlPages) {
		$scope.pageInitUrl = urlPages;
		$scope.getDate($scope.statusList);
	};
	// 柜子种类列表进入柜子详细列表的点击事件
	$scope.cabinetBox = function(typeId, typeName) {
		window.location.href = '/wcabinet/cabinet-data?i=' + typeId + '&n='+ typeName;
	}

	$scope.initPath = function() {
		$scope.searchParams = $scope.search();
		$scope.pageInitUrl = '/cabinet/home-data?' + $.param($scope.searchParams);
	};

	/**点击区域，出现柜子列表***/
	$scope.searchClass = function(status) {
		if(status == undefined){
			status = 8;
		}
		$scope.initPath();
		if($scope.nowPages) {
            $scope.pageInitUrl = '/cabinet/home-data?' + $.param($scope.searchParams) + '&page=' + $scope.nowPages + '&per-page=8';
        }
		$scope.getDate(status);
	};
	/**搜索方法（搜索栏）***/
	$scope.searchCabinet = function() {
		$scope.initPath();
		$scope.getDate();
	};
	/******Enter键搜索*******/
	$scope.enterSearchs = function(e) {
		var keyCode = window.event ? e.keyCode : e.which;
		if(keyCode == 13) {
			$scope.searchCabinet();
		}
	};
	//  分页数据信息
	$scope.getDate = function(status) {
		$.loading.show();
		$http.get($scope.pageInitUrl+'&pageSize='+status).then(function(result) {
			$scope.cabinetDetailPage = result.data.now.toString();
			if(result.data.data.length != 0) {
				$scope.allCabinetLists = result.data.data;
				$scope.pages = result.data.pages;
				$scope.nowPages = result.data.now;
				$scope.dataInfo = false;
				$scope.searchData = false;
			} else {
				$scope.allCabinetLists = result.data.data;
				$scope.pages = result.data.pages;
				if($scope.searchParams != null) {
					$scope.searchData = true;
					$scope.dataInfo = false;
				} else {
					$scope.dataInfo = true;
				}
			}
			$scope.cabinetCurrentTime = new Date().getTime();
			$scope.statusList = status;
			if(status == 60){
				$scope.isMatrix = true;
				$scope.isList   = false;
				$('#show-list-id').removeClass('active');
				$('#show-matrix-id').addClass('active');
			}else{
				$scope.isList = true;
				$scope.isMatrix = false;
				$('#show-list-id').addClass('active');
				$('#show-matrix-id').removeClass('active');
			}
			$.loading.hide();
		})
	};
	/**主界面(字段)搜索**/
	$scope.changeSort = function(attr, sort) {
		$scope.sortType = attr;
		$scope.switchSort(sort);
		$scope.searchClass();
	};

	$scope.switchSort = function(sort) {
		if(!sort) {
			sort = 'DES';
		} else if(sort == 'DES') {
			sort = 'ASC';
		} else {
			sort = 'DES'
		}
		$scope.sort = sort;
	};
	/**页面搜索（搜索栏）***/
	$scope.search = function() {
		return {
			typeId: $scope.cabinetypeId != undefined ? $scope.cabinetypeId : null,
			cabinetNum: $scope.cabinetNum != undefined ? $scope.cabinetNum : null,
			cabinetModel: $scope.cabinetModel != undefined ? $scope.cabinetModel : null,
			cabinetType: $scope.cabinetType != undefined ? $scope.cabinetType : null,
			customerName: $scope.customerName != undefined ? $scope.customerName : null,
			cabinetEndRent: $scope.cabinetEndRent != undefined ? $scope.cabinetEndRent : null,
			sortType: $scope.sortType != undefined ? $scope.sortType : null,
			sortName: $scope.sort != undefined ? $scope.sort : null,
			keyword: $scope.keyword != undefined ? $scope.keyword : null
		}
	};

	$scope.cabinetDeposit = '';
	// 新增无限增加多月设置
	$scope.btnAddMuchMonth = function() {
		$scope.htmlAttr = 'addCabinetMonth';
		$scope.num  = $scope.num + 1;
		$http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
			$scope.addCabinetMonthHtml = result.data.html;
		});
	}
	// 点击新增普通衣柜按钮初始化input框个数
	$scope.addCabinetModal = function() {
		$scope.giveMonthNum = '';
		$scope.cabinetSize = '';
		$scope.cabinetType = '';
		$scope.addCabinetNum = '';
		$scope.halfMonthMoney = null;
		$scope.cabinetPrefix = '';
		$scope.cabinetNumStart = '';
		$scope.cabinetDeposit = null; //押金
		$scope.cabinetMoney = null; //初始化多月设置金额
		$scope.muchMonth = ''; //初始化多月设置月数
		$scope.giveMonth = ''; //初始化多月设置赠送月数
		$scope.dis = ''; //初始化多月设置折扣
		$scope.addCabinetButtonFlag = false; //加载动画不显示
		$('div.myDiv').remove();  //初始化新增普通衣柜
	}
	//通过遍历判断用户输入的月数的值不重复
	function isRepeat(jsonMonth){
	    var filter = {};
		for(var i in jsonMonth) {
			if (filter[jsonMonth[i]]) {
                  return true;
			}
			filter[jsonMonth[i]] = true;
		}
		return false;
	}
	//租柜的赠送天数输入框change事件
	$scope.giveDayNumChange = function (time) {
	    if(time !== null && time !== undefined && time !== '' && $scope.giveMonthBingCabinet1 !== null && $scope.giveMonthBingCabinet1 !== undefined && $scope.giveMonthBingCabinet1 !== '') {
            if(time > $scope.giveMonthBingCabinet1) {
                Message.warning('赠送数不得大于' + $scope.giveMonthBingCabinet1);
                return false;
            }else {
                $scope.giveMonthBingCabinet = time;
                $scope.getEndDate(parseInt(Date.parse($scope.startRentCabinet)), $scope.cabinetDays, $scope.giveMonthBingCabinet, $scope.buyTimeType);
            }
        }else {
            $scope.giveMonthBingCabinet = 0;
            $scope.getEndDate(parseInt(Date.parse($scope.startRentCabinet)), $scope.cabinetDays, $scope.giveMonthBingCabinet, $scope.buyTimeType)
        }
    };
	//续柜的赠送天数输入框change事件
    $scope.giveTimenNumChange = function (time) {
        if(time !== null && time !== undefined && time !== '' && $scope.giveReletMonthNum1 !== null && $scope.giveReletMonthNum1 !== undefined && $scope.giveReletMonthNum1 !== '') {
            if(time > $scope.giveReletMonthNum1) {
                Message.warning('赠送数不得大于' + $scope.giveReletMonthNum1);
                return false;
            }else {
                $scope.getEndDate($scope.cabinetDetail.end_rent * 1000, $scope.reletMonth, time, $scope.giveTimeType);
            }
        }else {
            $scope.giveReletMonthNum = 0;
            $scope.getEndDate($scope.cabinetDetail.end_rent * 1000, $scope.reletMonth, time, $scope.giveTimeType);
        }
    };
	// 未绑定详情页面中的修改按钮，点击后进行分析判断
    $scope.isCabinetBindMember = false;
	//点击未绑定页面中的修改按钮
	$scope.editUnBinding = function(id,type) {
		$scope.editCompleteFlag = false;
		$scope.editCabinetId = id;
        $('#boundCabinet').modal('hide');
        if(type == 'isBind') {
            $scope.isCabinetBindMember = true;
        }else if(type == 'notBind') {
            $scope.isCabinetBindMember = false;
        }
		if($scope.cabinetInfoItem.deposit == undefined || $scope.cabinetInfoItem.deposit == '') {
			$scope.editCabinetDeposit = '';
		} else {
			$scope.editCabinetDeposit = parseFloat($scope.cabinetInfoItem.deposit);
		}
		if($scope.cabinetInfoItem.monthRentPrice == undefined || $scope.cabinetInfoItem.monthRentPrice == '') {
			$scope.editOneMonthPrice = '';
		} else {
			$scope.editOneMonthPrice = $scope.cabinetInfoItem.monthRentPrice;
		}
		if($scope.cabinetInfoItem.cabinet_model == undefined || $scope.cabinetInfoItem.cabinet_model == '') {
			$scope.editCabinetSize = '';
		} else {
			$scope.editCabinetSize = $scope.cabinetInfoItem.cabinet_model;
		}
		if($scope.cabinetInfoItem.cabinet_type == undefined || $scope.cabinetInfoItem.cabinet_type == '') {
			$scope.editCabinetType = '';
		} else {
			$scope.editCabinetType = $scope.cabinetInfoItem.cabinet_type;
		}
		$http.get('/cabinet/modify-one-cabinet?cabinetId=' + id).success(function(data){
			var cm  = angular.fromJson(data.data.cabinet_month);
			var cmy = angular.fromJson(data.data.cabinet_money);
			var md  = angular.fromJson(data.data.cabinet_dis);
            var gm  = angular.fromJson(data.data.give_month);
            if(cm != '' && cm != null && cm != undefined && cmy != '' && cmy != null && cmy != undefined && gm != '' && gm != null && gm != undefined && md != '' && md != null && md != undefined){
				var $max = cm.length;
				var i = -1;
				for(var n = 0; n < $max; n++){
					$scope.htmlAttr = 'modifyPlugins';
					$scope.num  = $scope.num + 1;
					$http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
						var $html = result.data.html;
						var $dom = $($html).get(0);
						i++;
						$($dom).find('input[name="cabinet_month"]').val(parseInt(cm[i]));
						$($dom).find('input[name="cabinet_money"]').val(parseFloat(cmy[cm[i]]));
						if(!gm[cm[i]].match(/^(\d+)(d|m)$/)) {
                            $($dom).find('input[name="give_month"]').val(gm[cm[i]]);
                            $($dom).find('select').val('m');
                        }else {
                            $($dom).find('select').val(gm[cm[i]].match(/^(\d+)(d|m)$/)[2] ? gm[cm[i]].match(/^(\d+)(d|m)$/)[2] : '');
                            $($dom).find('input[name="give_month"]').val(gm[cm[i]].match(/^(\d+)(d|m)$/)[1] ? gm[cm[i]].match(/^(\d+)(d|m)$/)[1] : '');
                        }
						$($dom).find('input[name="cabinet_dis"]').val(md[cm[i]]);
						$('#modify').append($dom);
					})
				}
				$('#boundCabinet').modal('hide');
			}else{
				return true;
			}
		});
		$('#noBoundCabinet').modal('hide');
		$('#isBind').attr('data-type',type);
	};
	/**
	 * @修改模态关闭初始化多月设置数据
	 *
	 **/
	$('#revise').on('hidden.bs.modal', function (e) {
		$('#modify').empty();
	})
	// 新增柜子，并把表单里填写的数据发送至后台
	//未绑定用户时显示
	$scope.editComplete = function() {
		/**
		 * @获取多月设置的值
		 **/
		if($scope.editCabinetSize == null || $scope.editCabinetSize == '' || $scope.editCabinetSize == undefined) {
			Message.warning("请选择柜子型号!");
			return;
		}
		if($scope.editCabinetType == null || $scope.editCabinetType == '' || $scope.editCabinetType == undefined) {
			Message.warning("请选择柜子类型!");
			return;
		}
		if($scope.editCabinetType == '2') {
			if($('#editCabinetDeposit555').val() == '') {
				Message.warning("请输入柜子押金!");
				return;
			}
		}
		if($scope.editOneMonthPrice == null || $scope.editOneMonthPrice == '' || $scope.editOneMonthPrice == undefined) {
			Message.warning("请输入单月金额!");
			return;
		}
		var $muchMoneyBox = $('#modify').children('div.leiGe');
		var jsonMonth = [];
		var jsonMoney = {};
		// var jsonGiveMonth = {};
        var jsonGiveTime = {};
		var jsonDis = {};
		var notPass = false;
		var notFormat = false;
		$muchMoneyBox.each(function (index, item) {
			var cabinet_month = $(this).find('input[name="cabinet_month"]').val();
			var cabinet_money = $(this).find('input[name="cabinet_money"]').val();
            // var give_month = $(this).find('input[name="give_month"]').val();
            var cabinet_dis = $(this).find('input[name="cabinet_dis"]').val();
            //赠送可以自由选择日或月
            var give_type = $(this).find('select').val();
            var give_value = $(this).find('input[name="give_month"]').val();
			//判断折扣是否格式化
			if(cabinet_dis != '' && cabinet_dis != undefined && cabinet_dis != null){
				if(/^0\.[123456789]+$/.test(cabinet_dis) || /^0\.[123456789]+(\/0\.[123456789]+)+$/.test(cabinet_dis)){
					notFormat = false;
				}else{
					notFormat = true;
				}
			}
			if (cabinet_month != '' && cabinet_month != null && cabinet_money != '' && cabinet_money != null) {
				jsonMonth.push(cabinet_month);
				jsonMoney[cabinet_month] = cabinet_money;
				// jsonGiveMonth[cabinet_month] = give_month;
				jsonDis[cabinet_month] = cabinet_dis;
                if(give_value === null || give_value === undefined || give_value === '') {
                    jsonGiveTime[cabinet_month] = null;
                }else {
                    jsonGiveTime[cabinet_month] = give_value + give_type;
                }
			} else {
				//如果有一条不符合就不能通过
				notPass = true;
				return;
			}
		});
		//如果多月设置为空
		// if (notPass == true) {
		// 	Message.warning('多月设置必填项不能为空');
		// 	return;
		// }
		//如果多月设置月数重复
		if (isRepeat(jsonMonth)) {
			Message.warning('多月设置月份不能"重复"');
			return;
		}
		//如果折扣没有格式化
		if(notFormat == true){
			Message.warning('折扣不符合格式');
			return;
		}
		$scope.editCompleteData = function() {
			return {
				cabinetModel   : $scope.editCabinetSize,
				cabinetType    : $scope.editCabinetType,
				deposit        : $('#editCabinetDeposit555').val(),
				cabinetId      : $scope.editCabinetId,
				monthRentPrice : $scope.editOneMonthPrice,
				yearRentPrice  : $scope.editOneYearPrice,
                // giveMonth      : jsonGiveMonth != undefined && jsonGiveMonth != '' ? jsonGiveMonth : null,  //多月设置赠送月数
                giveMonth      : jsonGiveTime != undefined && jsonGiveTime != '' ? jsonGiveTime : null,  //多月设置赠送月数
				cabinetMonth   : jsonMonth != undefined && jsonMonth != '' ? jsonMonth : null,    //多月设置月份
				cabinetMoney   : jsonMoney != undefined && jsonMoney != '' ? jsonMoney : null,  //多月设置金额
				cabinetDis     : jsonDis   != undefined && jsonDis   != '' ? jsonDis   : null,  // 多月设置折扣
				_csrf_backend  : $('#_csrf').val() //csrf防止跨站
			}
		};
		$scope.editCompleteFlag = true;
		var type = $('#isBind').attr('data-type');
		var page = $('#isBind').attr('data-page');
		$http({
			url: "/cabinet/cabinet-update",
			method: 'POST',
			data: $.param($scope.editCompleteData()),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function(result) {
			if(result.data.status == "success") {
				Message.success(result.data.data);
				// $scope.editCabinetInit();
				// $scope.searchClass();
				$('#revise').modal('hide'); //执行关闭模态框
				// $('#boundCabinet').modal('hide');
				if(type == 'isBind'){
					// $('#boundCabinet').modal('show');
				}else{
					// $('#noBoundCabinet').modal('show');
				}
				// console.log('page',page);
				if(page == 'matrix'){
					$scope.searchClass(60);
				}else{
					$scope.searchClass();
				}
                // $scope.getDate($scope.statusList);
			} else {
				Message.warning(result.data.data);
				$scope.editCompleteFlag = false;
			}
		});

	};
	//点击更衣柜详情中的点击绑定用户
	$scope.clickBinding = function(object, id) {
		$('#noBoundCabinet').modal('hide');
		$scope.bindingMember(object, id);
	};
	/**
	 * author: 程丽明       杨慧磊(修改)
	 * create: 2017-07-17  2017/12/22
	 * 函数描述: 绑定用户到柜子上，点击后打开模态框
	 * 修改:  声明全局变量
	 * */
	//点击绑定用户柜子的数据
	var currentCabinetData;
	//点击绑定用户柜子实时赠送月数
	var giveCurMonth;
	//点击绑定用户柜子实时折扣
	var rootCurDis;
	//点击绑定用户柜子租赁月数对应的金额
	var muchMonthMoney;
	//绑定用户
	$scope.bindingMember = function(object, id) {
		$scope.keywords = '';
		currentCabinetData = object;
		$scope.bindingCabinetCompleteFlag = false;
		$scope.cabinetCashPledge = parseInt(object.deposit != null && object.deposit != undefined && object.deposit != '' ? object.deposit : 0);
		$scope.containerId = id;
		$scope.containerNumber = object.cabinet_number;
		$scope.cabinetIsType = object.cabinetModel;
		$scope.cabinetOneMonMoney = object.monthRentPrice;
		$scope.bindingMemberPreCabinetDetail = object;
		//重置模态框
		$scope.selectedDis = '1';
		$scope.theAmountPayable = 0;
		$scope.display = 0;
		$('#bindingUser').modal('show');
	};
	//获取柜子到期时间
	$scope.getCabinetEndDate = function() {
		if($scope.cabinetDays !== undefined && $scope.cabinetDays !== '' && $scope.cabinetDays !== null && $scope.startRentCabinet !== undefined && $scope.startRentCabinet !== '' && $scope.startRentCabinet !== null) {
            $scope.getEndDate(parseInt(Date.parse($scope.startRentCabinet)), $scope.cabinetDays, $scope.giveMonthBingCabinet, $scope.buyTimeType);
            // if(giveCurMonth != 0 || giveCurMonth != undefined || giveCurMonth != null){
			// 	var num = $scope.cabinetDays + parseInt(giveCurMonth);
			// 	$scope.getEndDate(num);
			// }else{
			// 	$scope.getEndDate($scope.cabinetDays);
			// }
		}else{
			$scope.cabinetEnd = $scope.startRentCabinet;
		}
    }
	
	//实时计算
	$scope.rentCabinet = function(start) {
		$scope.startRentCabinet = start;
		//console.log(parseInt(Date.parse(start)));
		$scope.getCabinetEndDate();
	}
	//输入租赁月数实时计算赠送月数和租赁金额
	$scope.rentCabinetDays = function(start) {
		//初始化输入月数
		$scope.cabinetDays = parseInt(start);
		//初始化折扣
		$scope.selectedDis = '1';
		//根据输入月数获取赠送月数
		if(start === null || start === '' || start === undefined){
			giveCurMonth = 0;
		}else {
            $scope.reGiveTime = angular.fromJson(currentCabinetData.give_month);
		    if($scope.reGiveTime != null && $scope.reGiveTime != '' && $scope.reGiveTime != undefined) {
                if(!$scope.reGiveTime[$scope.cabinetDays]) {
                    $scope.buyTimeType = '';
                    $scope.giveMonthBingCabinet = 0;
                    $scope.giveMonthBingCabinet1 = 0;
                }else {
                    if(!$scope.reGiveTime[$scope.cabinetDays].match(/^(\d+)(d|m)$/)) {
                        //获取租赁月数(包含赠送月数)
                        var regexp = new RegExp('"'+start+'":\\s"\\d+"','g');
                        var pregRe = currentCabinetData.give_month.match(regexp);
                        if(pregRe != null){
                            var endRe = pregRe[0];
                            $scope.giveMonthBingCabinet = endRe.slice(endRe.indexOf(':')+3).replace('"','');
                            giveCurMonth = $scope.giveMonthBingCabinet;
                            $scope.buyTimeType = 'm';
                            $scope.giveMonthBingCabinet = parseInt(giveCurMonth);
                            $scope.giveMonthBingCabinet1 = parseInt(giveCurMonth);
                        }else{
                            $scope.giveMonthBingCabinet = 0;
                            giveCurMonth = 0;
                        }
                    }else {
                        giveCurMonth = $scope.reGiveTime[$scope.cabinetDays].match(/^(\d+)(d|m)$/)[1];
                        $scope.buyTimeType = $scope.reGiveTime[$scope.cabinetDays].match(/^(\d+)(d|m)$/)[2];
                        $scope.giveMonthBingCabinet = parseInt(giveCurMonth);
                        $scope.giveMonthBingCabinet1 = parseInt(giveCurMonth);
                    }
                }
            }else {
                $scope.buyTimeType = '';
                $scope.giveMonthBingCabinet = 0;
                $scope.giveMonthBingCabinet1 = 0;
            }
		}
	    //根据输入月数获取折扣
	    //定义数组容器
        var disArr = [];
        if(start == null || start == ''){
			//如果不存在对应的折扣
			$scope.dises = disArr;
			$scope.display = 0;
        }else if(currentCabinetData.cabinet_dis != null){
			var regdis = new RegExp('"'+start+'":\\s"\\d+(\\.\\d+)?(\\/\\d+(\\.\\d+)?)*"','g');
			var regdisRe = currentCabinetData.cabinet_dis.match(regdis);
			if(regdisRe != null){
				var disstr = regdisRe[0].slice(regdisRe[0].indexOf(':')+3).replace('"','');
				if(disstr.indexOf('/') > -1){
					//如果存在'/'
					$scope.dises = disstr.split('/');
					$scope.display = 1;
				}else{
					//如果折扣数量是1
					disArr[0] = disstr;
					$scope.dises = disArr;
					$scope.display = 1;
				}
			}else{
				//如果不存在对应的折扣
				$scope.dises   = disArr;
				$scope.display = 0;
			}
        }else{
			$scope.dises   = disArr;
			$scope.display = 0;
        }
		//实时计算租金
		if(start == null || start == ''){
			muchMonthMoney = 0;
		}else if(currentCabinetData.cabinet_money != null){
			var regMoney = new RegExp('"'+start+'":\\s"\\d+"','g');
			var regMoneyRe = currentCabinetData.cabinet_money.match(regMoney);
			if(regMoneyRe != null){
				var regMonneyEndRe = regMoneyRe[0];
				muchMonthMoney = regMonneyEndRe.slice(regMonneyEndRe.indexOf(':')+3).replace('"','');
			}else{
				muchMonthMoney = 0;
			}
		}else{
			muchMonthMoney = 0;
		}
		//实时计算金额加押金
		if(start == '' || start == null || start == 0){
			$scope.theAmountPayable = 0;
		}else if($scope.selectedDis != null && $scope.selectedDis != undefined && $scope.selectedDis != ''){
			$scope.theAmountPayable = $scope.getTheAmountPayable() * parseFloat($scope.selectedDis) + $scope.cabinetCashPledge;
		}else{
			$scope.theAmountPayable = $scope.getTheAmountPayable() + $scope.cabinetCashPledge;
		}
		//实时计算到期日期
		$scope.getCabinetEndDate();
	}
	//用户选择对应的折扣实时获取租赁金额
	$scope.getCurrentRootMoney = function(curDis){
		if($scope.getTheAmountPayable() == 0){
			$scope.theAmountPayable = 0;
		}else{
			$scope.theAmountPayable = $scope.getTheAmountPayable()*parseFloat(curDis) + $scope.cabinetCashPledge;
		}
	}
	//计算绑定用户应交金额
	$scope.getPayableMoney = function() {
		$scope.rentCabinetDays();
	}
	//绑定柜子
	$scope.bindingCabinetComplete = function(id) {
        $scope.bindingCabinetDataInit = function() {
			$scope.startRentCabinet = '';
			$scope.theAmountPayable = '';
			$scope.cabinetEnd = '';
			$scope.cabinetDays = '';
			$scope.bindCabinetNote = '';
		}
		$scope.rentalMoney = $scope.theAmountPayable - $scope.cabinetCashPledge;//租金
		$scope.bindingCabinetData = function() {
            if ($scope.giveMonthBingCabinet == 0 || $scope.giveMonthBingCabinet ===undefined || $scope.giveMonthBingCabinet === null || $scope.giveMonthBingCabinet ==='') {
                $scope.buyTimeType = '';
                $scope.giveMonthBingCabinet = '';
            }
			return {
				_csrf_backend: $('#_csrf').val(),
				memberId: $scope.memberDetail.id != undefined && $scope.memberDetail.id != "" ? $scope.memberDetail.id : null, //会员id
				cabinetRentStart: $scope.startRentCabinet != undefined && $scope.startRentCabinet != "" ? $scope.startRentCabinet : null, //时间
				cabinetRentEnd: $scope.cabinetEnd != undefined && $scope.cabinetEnd != "" ? $scope.cabinetEnd : null, //到期时间
				// price: $scope.theAmountPayable != undefined && $scope.theAmountPayable != "" ? $scope.theAmountPayable : null, //单日金额
				price: $scope.rentalMoney != undefined && $scope.rentalMoney != "" ? $scope.rentalMoney : null, //租金
				cabinetId: $scope.containerId != undefined && $scope.containerId != "" ? parseInt($scope.containerId) : null, //柜子ID
				deposit: $scope.cabinetCashPledge,
                giveDay:$scope.giveMonthBingCabinet,//赠送的月数
				giveType:$scope.buyTimeType,
				note: $scope.bindCabinetNote
			}
		}
		if($scope.startRentCabinet == null || $scope.startRentCabinet == undefined || $scope.startRentCabinet == '') {
			Message.warning("请输入租柜日期!");
			return;
		}
		if($scope.cabinetDays == null || $scope.cabinetDays == undefined || $scope.cabinetDays == '') {
			Message.warning("请输入租柜月数!");
			return;
		}
		if(parseInt($('.giveMonthBingCabinet11').val()) > $scope.giveMonthBingCabinet1) {
            Message.warning('租柜赠送数不得大于' + $scope.giveMonthBingCabinet1);
            return false;
        }
		$scope.bindingCabinetCompleteFlag = true;
		$http({
			url: "/cabinet/bind-member",
			method: 'POST',
			data: $.param($scope.bindingCabinetData()),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function(result) {
			if(result.data.status == 'success') {
				Message.success(result.data.data);
				$scope.bindingCabinetDataInit();
				$scope.getDate();
				$scope.allCabinetTypeData();
				$('#bindingCabinet').modal('hide');
			} else {
				$scope.bindingCabinetCompleteFlag = false;
				Message.warning(result.data.data);
			}
		});
	}
	//退租
	$scope.quitCabinet = function(id, memCabinetId, cabinetDetail) {
		$scope.quitCabinetCompleteFlag = false;
		$scope.containerId = id;
		$scope.memCabinetId = memCabinetId;
		$scope.cabinetDetail = cabinetDetail;
		$('#boundCabinet').modal('hide');
		$scope.cabinetCashPledge = parseInt(cabinetDetail.deposit != null && cabinetDetail.deposit != undefined ? cabinetDetail.deposit : 50);
		var currentTime = new Date().getTime();
		var endTime = new Date(($scope.getMyDate(cabinetDetail.end_rent * 1000) + " " + "23:59:59")).getTime();
		$scope.endNextWeek = endTime + 7 * 24 * 60 * 60 * 1000;
        /**
         * 退柜管理-退柜设置-获取退柜配置
         * 1.有设置配置,调用配置
         * 2.没有,则退全部押金
         */
        $http.get('/cabinet/get-quit-cabinet-value').then(function (result) {
            $scope.quitCabinetValue = result.data;
            var setDays = $scope.quitCabinetValue.setDays;
            var setCost = $scope.quitCabinetValue.setCost;
            var dateType = $scope.quitCabinetValue.dateType;
            if(currentTime < endTime) {
                $scope.depositRefund = $scope.cabinetCashPledge;return ;
            }
            if (setDays == null || setDays == '' || setDays == undefined) {
                //没有设置天数限制
                if (setCost == null || setCost == '' || setCost == undefined) {
                    $scope.depositRefund = $scope.cabinetCashPledge;
                } else {
                    var long = 1;
                    switch (dateType) {
                        case 'everyDay'     : long = 1;break;
                        case 'everyWeek'    : long = 7;break;
                        case 'everyMonth'   : long = 30;break;
                    }
                    //计算超出的日期
                    var overTime = Math.ceil(parseInt(parseInt(currentTime) - parseInt(endTime))/(24 * 60 * 60 * 1000));
                    var overDay = Math.ceil(overTime/long);
                    var deductMoney = parseInt(overDay*setCost);
                    $scope.depositRefund = parseInt(parseInt($scope.cabinetCashPledge) - parseInt(deductMoney));
                    if (parseInt($scope.depositRefund) < 0) {
                        $scope.depositRefund = 0;
                    }
                }
            } else {
                //设置了天数限制
                var overTime = Math.ceil(parseInt(parseInt(currentTime) - parseInt(endTime))/(24 * 60 * 60 * 1000));
                if (overTime <= parseInt(setDays)) {
                    $scope.depositRefund = $scope.cabinetCashPledge;
                } else {
                    if (setCost == null || setCost == '' || setCost == undefined) {
                        $scope.depositRefund = $scope.cabinetCashPledge;
                    } else {
                        var long = 1;
                        switch (dateType) {
                            case 'everyDay'     :
                                long = 1;
                                break;
                            case 'everyWeek'    :
                                long = 7;
                                break;
                            case 'everyMonth'   :
                                long = 30;
                                break;
                        }
                        var overDay = Math.ceil((parseInt(overTime) - parseInt(setDays)) / parseInt(long));
                        var deductMoney = parseInt(parseInt(overDay)*setCost);
                        $scope.depositRefund = parseInt(parseInt($scope.cabinetCashPledge) - parseInt(deductMoney));
                        if (parseInt($scope.depositRefund) < 0) {
                            $scope.depositRefund = 0;
                        }
                    }
                }
            }

        })
	};
	var currentTime = new Date().getTime();
	$scope.currentDate = $scope.getMyDate(currentTime);
	//退柜完成
	$scope.quitCabinetComplete = function(endTime) {
		$scope.quitCabinetData = function() {
			return {
				_csrf_backend: $('#_csrf').val(),
				quiteDate: $scope.currentDate, //退租时间
				memCabinetId: parseInt($scope.memCabinetId), //会员柜子id
				price: $scope.depositRefund,
				memberId: parseInt($scope.cabinetDetail.member_id),
				cabinetId: parseInt($scope.containerId)
			}
		}
		$scope.quitCabinetCompleteFlag = true;
		$http({
			url: "/cabinet/quite-cabinet",
			method: 'POST',
			data: $.param($scope.quitCabinetData()),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function(result) {
			if(result.data.status == 'success') {
				$scope.searchClass();
				$scope.allCabinetTypeData();
				Message.success(result.data.data);
				$('#backCabinet').modal('hide');
			} else {
				$scope.quitCabinetCompleteFlag = false;
				Message.warning(result.data.data);
			}
		});
	}
	//声明全局变量柜子的数据
	var reCabinetData;
	//声明全局变量续柜赠送月数
	var reGiveMonth;
	//声明全局变量续柜金额
	var reMuchMoney;
	//声明全局变量防止折扣链式反应
	var disContainer;
	$scope.renewCabinet = function(cabinetDetail) {
		$scope.renewCabinetCompleteFlag = false;
		$scope.reletPrice = 0;
		$scope.reletMonth = '';
        $scope.giveReletMonthNum = 0;
        $scope.giveReletMonthNum1 = 0;
		$scope.cabinetDetail = cabinetDetail;
		/*新增*/
		//初始化折扣
		$scope.redisplay = 0;
		$scope.reDis = '1';
		//获取续租柜子数据
		reCabinetData = cabinetDetail;
		//初始化折扣
		$scope.reDis = '';
		$scope.cabinetreletEndDate = $scope.getMyDate($scope.cabinetDetail.end_rent * 1000);
		$http.get('/user/member-card?memberId=' + $scope.cabinetDetail.member_id).then(function(response) {
			$scope.memberCardInvalidTime = response.data.invalid_time;
		});
		$('#boundCabinet').modal('hide');
	}
	//当月的输入框变化时获取柜子到期时间
	$scope.reletMonthChange = function(reletMonth) {
		//初始化折扣
		$scope.reDis = '1';
		if(reletMonth == null || reletMonth == '' || reletMonth == 0){
			//初始化赠送月数
			$scope.giveReletMonthNum = 0;
			//初始化续柜初始到期时间
			$scope.cabinetreletEndDate = $scope.getMyDate($scope.cabinetDetail.end_rent * 1000);
		}else{
			//实时计算获取续柜到期日期和赠送月数
			if($scope.reletMonth != undefined && $scope.reletMonth != '' && $scope.reletMonth != null && $scope.cabinetDetail.end_rent != undefined && $scope.cabinetDetail.end_rent != '' && $scope.cabinetDetail.end_rent != null && reCabinetData.give_month != null) {
				$scope.reGiveMonth = angular.fromJson(reCabinetData.give_month);
                if($scope.reGiveMonth == null || $scope.reGiveMonth == undefined || $scope.reGiveMonth == '') {
                    reGiveMonth = 0;
                    $scope.giveTimeType = '';
                	$scope.giveReletMonthNum = 0;
                    $scope.giveReletMonthNum1 = 0;
				}else {
                	var __pattern = new RegExp(/^(\d+)(d|m)$/);
                	if(!__pattern.test($scope.reGiveMonth[$scope.reletMonth])) {
                        //获取租赁月数(包含赠送月数)
                        var reRentreg = new RegExp('"'+$scope.reletMonth+'":\\s"\\d+"','g');
                        var reRentRe = reCabinetData.give_month.match(reRentreg);
                        if(reRentRe != null){
                            var reEndRe = reRentRe[0];
                            reGiveMonth = reEndRe.slice(reEndRe.indexOf(':')+3).replace('"','');
                            $scope.giveReletMonthNum = parseInt(reGiveMonth);
                            $scope.giveReletMonthNum1 = parseInt(reGiveMonth);
                        }else{
                            reGiveMonth = 0;
                            $scope.giveTimeType = '';
                            $scope.giveReletMonthNum = 0;
                            $scope.giveReletMonthNum1 = 0;
                        }
					}else {
                        reGiveMonth = $scope.reGiveMonth[$scope.reletMonth].match(/^(\d+)(d|m)$/)[1];
                        $scope.giveTimeType = $scope.reGiveMonth[$scope.reletMonth].match(/^(\d+)(d|m)$/)[2];
                        $scope.giveReletMonthNum = parseInt(reGiveMonth);
                        $scope.giveReletMonthNum1 = parseInt(reGiveMonth);
					}
				}
                //计算到期时间(自然月的形式)
                $scope.getEndDate($scope.cabinetDetail.end_rent * 1000, $scope.reletMonth, parseInt(reGiveMonth), $scope.giveTimeType)
			}else{
				reGiveMonth = 0;
                $scope.giveTimeType = '';
				$scope.giveReletMonthNum = 0;
                $scope.giveReletMonthNum1 = 0;
                $scope.cabinetreletEndDate = $scope.getMyDate($scope.cabinetDetail.end_rent * 1000);
			}
		}
		//租赁月数对应的金额
		if(reletMonth == null || reletMonth == ''){
			reMuchMoney = 0;
		}else if(reCabinetData.cabinet_money != null){
			var regReMoney = new RegExp('"'+reletMonth+'":\\s"\\d+"','g');
			var regReMoneyRe = reCabinetData.cabinet_money.match(regReMoney);
			if(regReMoneyRe != null){
				var endMoney = regReMoneyRe[0];
				reMuchMoney = endMoney.slice(endMoney.indexOf(':')+3).replace('"','');
			}else{
				reMuchMoney = $scope.reletMonth * $scope.cabinetDetail.monthRentPrice;
			}
		}else{
			reMuchMoney = $scope.reletMonth * $scope.cabinetDetail.monthRentPrice;
		}
		//实时计算续租金额
		if($scope.reletMonth != undefined && $scope.reletMonth != '' && $scope.reletMonth != null && $scope.cabinetDetail.monthRentPrice != undefined && $scope.cabinetDetail.monthRentPrice != '' && $scope.cabinetDetail.monthRentPrice != null) {
			if(reGiveMonth != undefined && reGiveMonth != null){
				$scope.reletPrice = reMuchMoney;
				disContainer = $scope.reletPrice;
			}else{
				$scope.reletPrice = reMuchMoney;
				disContainer = $scope.reletPrice;
			}
		}else{
			$scope.reletPrice = 0;
			disContainer = 0;
		}
		//定义数组容器
		var redisArr = [];
		//获取续租折扣
		if(reletMonth == null || reletMonth == ''){
			//如果不存在对应的折扣
			$scope.redises = redisArr;
			$scope.redisplay = 0;
		}else if(reCabinetData.cabinet_dis != null){
			var reRegdis = new RegExp('"'+reletMonth+'":\\s"\\d+(\\.\\d+)?(\\/\\d+(\\.\\d+)?)*"','g');
			var reRegdisRe = reCabinetData.cabinet_dis.match(reRegdis);
			if(reRegdisRe != null){
				var disRestr = reRegdisRe[0].slice(reRegdisRe[0].indexOf(':')+3).replace('"','');
				if(disRestr.indexOf('/') > -1){
					//如果存在'/'
					$scope.redises = disRestr.split('/');
					$scope.redisplay = 1;
				}else{
					//如果折扣数量是1
					redisArr[0] = disRestr;
					$scope.redises = redisArr;
					$scope.redisplay = 1;
				}
			}else{
				//如果不存在对应的折扣
				$scope.redises   = redisArr;
				$scope.redisplay = 0;
			}
		}else{
			//如果不存在对应的折扣
			$scope.redises   = redisArr;
			$scope.redisplay = 0;
		}
	}
	//选择折扣获取续费最终金额
	$scope.getReDis = function(reDis){
		if($scope.reletPrice != 0 && $scope.reletPrice != undefined && $scope.reletPrice != null && $scope.reletPrice != ''){
			$scope.reletPrice = disContainer * parseFloat(reDis);
		}else{
			$scope.reletPrice = 0;
		}
	}
	
    $scope.reletEndDate = function(){
        if($scope.reletMonth != undefined && $scope.reletMonth !='' && $scope.reletMonth != null && $scope.cabinetDetail.end_rent != undefined && $scope.cabinetDetail.end_rent !='' && $scope.cabinetDetail.end_rent != null ){
            if($scope.reletMonth >= 12){
                var numYears = Math.floor($scope.reletMonth/12);
                if($scope.reletGiveMonthNum !== 0){
                    $scope.reletMonth = numYears*2 + $scope.reletMonth;
                }
            }
            $http.get('/cabinet/calculate-date?numberMonth='+ $scope.reletMonth +'&startRent='+ $scope.cabinetreletEndDate).then(function(result){
                $scope.cabinetreletEndDate = (result.data).replace(/\"/g, "");
            });
        }
    }
    //续租完成
    $scope.renewCabinetComplete = function(){
        $scope.renewCabinetData = function(){
            $scope.dayGive = $('.giveReletMonthNum11').val();
            if ($scope.dayGive === undefined || $scope.dayGive === '' || $scope.dayGive == null) {
                $scope.dayGive = '';
                $scope.giveTimeType = '';
            }
            return {
                _csrf_backend: $('#_csrf').val(),
                memCabinetId :parseInt($scope.cabinetDetail.memberCabinetId),      //会员柜子id
                memberId:parseInt($scope.cabinetDetail.member_id),
                renewDate   :$scope.cabinetreletEndDate, //续组日期
                renewNumDay:$scope.reletMonth,      //续组月数
                renewRentPrice:$scope.reletPrice,  //续组价格
                // give_month:$scope.giveReletMonthNum//续租的赠送的月数
                giveDay:    $scope.dayGive,//续租的赠送的月数
                giveType:   $scope.giveTimeType
            }
        }
        if($scope.reletMonth == null || $scope.reletMonth == ''|| $scope.reletMonth== undefined){
            Message.warning('请输入续租的月数!');
            return;
        }
        // if(parseInt($scope.memberCardRentInvalidTime) < $scope.endTime){
        //     Message.warning("您的租柜到期日期在会员卡到期日期之后!");
            // return;
        // }
        if(parseInt($('.giveReletMonthNum11').val()) > $scope.giveReletMonthNum1) {
            Message.warning('续柜赠送数不得大于' + $scope.giveReletMonthNum1);
            return false;
        }
        $scope.renewCabinetCompleteFlag = true;
        $http({
            url: "/cabinet/renew-cabinet",
            method: 'POST',
            data: $.param( $scope.renewCabinetData()),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.reletMonth = '';
                $scope.reletPrice= '';
                $scope.getDate();
                $scope.allCabinetTypeData();
                $('#renewCabinet').modal('hide');
            }else{
                $scope.renewCabinetCompleteFlag = false;
                Message.warning(result.data.data);
            }
        })
    }
    //冻结柜子
    $scope.freezeCabinet = function(id){
        $http.get('/cabinet/frozen-cabinet?cabinetId='+ id).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.getDate();
            }else if(result.data.status == 'error'){
                Message.warning(result.data.data);
            }
        })
    }
    //取消冻结
    $scope.cancelFreezeCabinet  = function(id){
        $http.get('/cabinet/frozen-cabinet?cabinetId='+ id +'&status='+2).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.getDate();
            }else if(result.data.status == 'error'){
                Message.warning(result.data.data);
            }
        })
    }
    
	/**
	 * @柜子类型修改
	 * 根据柜子ID,类型,类别获取柜子详情
	 * @param : id(最小柜子ID)
	 *         count(柜子数量)
	 *         number(柜子名称)
	 *         model(柜子类型)
	 *         type(柜子类别)
	 **/
	
	//类型管理批量删除
	$scope.deleteCabinetType = function(id,count) {
		Sweety.remove({
				url              : '/cabinet/delete-cabinet-type?cabinetId=' + id + '&cabinetNum=' + count,
				http             : $http,
				title            : '确定要删除吗?',
				text             : '删除后所有信息无法恢复',
				confirmButtonText: '确定',
				data             : {
					action: 'unbind'
				}
			}, function () {
				$scope.getCabinetTypeLister();
		});
	}
	//修改模态关闭初始化数据
	$('#typeClass').on('hidden.bs.modal', function (e) {
		$scope.modifyCabinetSize     = '';
		$scope.modifyCabinetType     = '';
		$scope.modifyCabinetPrefix   = '';
		$scope.modifyCabinetNumStart = null;
		$scope.modifyCabinetNum      = null;
		$scope.modifyHalfMonthMoney  = null;
		$scope.modifyCabinetDeposit  = null;
		$scope.modifyMuchMonth       = '';
		$scope.modifyCabinetMoney    = null;
		$scope.modifyGiveMonth       = '';
		$scope.modifyDis             = '';
		$('.myDiv').remove();
	})
	/**
	 * author: 程丽明
	 * create: 2017-06-07
	 * 函数描述: 冻结柜子
	 * param: id:要被冻结的柜子的id
	 * */
	//冻结柜子
	$scope.freezeCabinet = function(id) {
		$http.get('/cabinet/frozen-cabinet?cabinetId=' + id).then(function(result) {
			if(result.data.status == 'success') {
                $('#boundCabinet').modal('hide');
				Message.success(result.data.data);
				$scope.getDate();
			} else if(result.data.status == 'error') {
				Message.warning(result.data.data);
			}
		})
	}
	/**
	 * author: 程丽明
	 * create: 2017-06-09
	 * 函数描述: 取消冻结柜子
	 * param: id:取消冻结的柜子的id
	 * */
	//取消冻结
	$scope.cancelFreezeCabinet = function(id) {
		$http.get('/cabinet/frozen-cabinet?cabinetId=' + id + '&status=' + 2).then(function(result) {
			if(result.data.status == 'success') {
				Message.success(result.data.data);
				$scope.getDate();
			} else if(result.data.status == 'error') {
				Message.warning(result.data.data);
			}
		})
	}
	//获取所有未租的柜子
	$scope.allUnLeasedCabinet = function() {
	    $.loading.show();
		$http.get($scope.unLeasedCabinetUrl).then(function(result) {
			$scope.unLeasedCabinetLists = result.data;
			$.loading.hide();
		})
	}
	//点击调柜按钮调柜
	$scope.switchCabinet = function(cabinetDetail) {
        $('#boundCabinet').modal('hide');
		$scope.completeSwitchCabinetBtnFlag = false;
		$('.listCabinetStyle').eq(0).addClass('bgGrey').siblings('.listCabinetStyle').removeClass('bgGrey');
		$scope.oldCabinetId = cabinetDetail.cabinet_id;
		$scope.memCabinetId = cabinetDetail.memberCabinetId;
		$scope.oldCabinetDetail = cabinetDetail;
		var id = $scope.allCabinet[0].id;
		$scope.oldTypeName = $scope.allCabinet[0].type_name;
		$scope.unLeasedCabinetUrl = '/cabinet/get-all-cabinet?typeId=' + id;
		$scope.allUnLeasedCabinet();
        $('#checkCabinet').modal('show');
	}
	//调柜类型选择
	$scope.cabinetStyleList = function(id, ind, object) {
		$scope.oldTypeName = object.type_name;
		$('.listCabinetStyle').eq(ind).addClass('bgGrey').siblings('.listCabinetStyle').removeClass('bgGrey');
		$scope.unLeasedCabinetUrl = '/cabinet/get-all-cabinet?typeId=' + id;

		$scope.allUnLeasedCabinet();
	}
	//调柜选择按钮
	$scope.selectSwitchCabinetBtn = function(selectCabinet) {
	    // console.log('selectCabinet',selectCabinet);
		var oldObjectCabinet = $scope.oldCabinetDetail;
		// console.log('oldObjectCabinet',oldObjectCabinet);
		var oldCabinetEndTime = $scope.getMyDate(oldObjectCabinet.end_rent * 1000);
		$scope.selectCabinetDetail = selectCabinet;
		$scope.switchMonthNum = selectCabinet.give_month;
		var currentDate = new Date().getTime();
		var cabinetEndDate = (oldObjectCabinet.end_rent) * 1000;
		var $cabinetModel = oldObjectCabinet.cabinet_model; //当前柜子 3
		var $cabinet_model = selectCabinet.cabinet_model; //调换柜子型号 1
		//大柜型号 1  中柜型号 2     小柜型号3
		//同柜子调换
		if(parseInt($cabinetModel) == parseInt($cabinet_model)) {
			$scope.selectSwitchCabinetPrice = 0;
			$scope.switchCabinetEndDate = oldCabinetEndTime;
		}
        //大柜调下一级柜子剩余钱变成柜子的日期
       if (parseInt($cabinetModel) < parseInt($cabinet_model)) {
            //计算原柜子剩余的钱
            var freeMoney = parseFloat(parseFloat(oldObjectCabinet.monthRentPrice) / 30 * parseInt(oldObjectCabinet.surplusDay));
            //计算现柜子的能够使用的天数
            var nowDay = parseInt(freeMoney / (parseFloat(selectCabinet.monthRentPrice) / 30));
            var timestamp = Math.round(new Date()) + nowDay *24*60*60*1000;
            $scope.selectSwitchCabinetPrice = 0;
            $scope.switchCabinetEndDate = $scope.getMyDate(timestamp);
       }
		//小柜调大柜补交金额
		if(parseInt($cabinetModel) > parseInt($cabinet_model)) {
			var currentNext = $scope.getMyDate(currentDate) + " " + "23:59:59";
			var currentNextTime = new Date(currentDate).getTime();
			$scope.selectSwitchCabinetPrice = (Math.abs(oldObjectCabinet.monthRentPrice - selectCabinet.monthRentPrice) / 30 * Math.floor((cabinetEndDate - currentDate) / (1000 * 24 * 60 * 60))).toFixed(2);
			$scope.switchCabinetEndDate = oldCabinetEndTime;
		}
	}
	//完成调柜
	$scope.completeSwitchCabinetBtn = function() {
        $scope.completeSwitchCabinetData = function() {
			return {
				_csrf_backend: $('#_csrf').val(), //csrf防止跨站
				memCabinetId: parseInt($scope.oldCabinetDetail.memberCabinetId), // 会员柜子id
				memberId: parseInt($scope.oldCabinetDetail.member_id),
				cabinetId: parseInt($scope.selectCabinetDetail.id), // 新柜子id
				originalCabinetId: parseInt($scope.oldCabinetId), //老柜子id
				price: $scope.selectSwitchCabinetPrice, //应补金额
				changeCabinetDate: $scope.switchCabinetEndDate //调柜的日期
			}
		}
		$scope.completeSwitchCabinetBtnFlag = true;
		$http({
			url: "/cabinet/change-cabinet",
			method: 'POST',
			data: $.param($scope.completeSwitchCabinetData()),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function(result) {
			if(result.data.status == 'success') {
				Message.success(result.data.data);
				$('#checkCabinetSuccess').modal('hide');
				$('#checkCabinet').modal('hide');
				$scope.getDate();
			} else {
				$scope.completeSwitchCabinetBtnFlag = false;
				Message.warning(result.data.data);
			}
		})
	}
	$scope.init1();
	$scope.init3();
	// 从柜子详细列表返回到柜子种类列表的点击事件
	$('.backHistoryBox').click(function() {
		$('.listBox').hide();
		$('.contentBox').show();
	});
	// 续柜日期插件的js
	$("#dateRenrw").datetimepicker({
		minView: "month", //设置只显示到月份
		format: 'yyyy-mm-dd ',
		language: 'zh-CN',
		autoclose: true,
		todayBtn: true, //今日按钮
	});
	// 租柜日期插件的js
	$("#dataCabinet").datetimepicker({
		minView: "month", //设置只显示到月份
		format: 'yyyy-mm-dd',
		language: 'zh-CN',
		autoclose: true,
		todayBtn: true, //今日按钮
	});
//	1229新增
	$scope.backShaPage =function () {
		location.href = "/new-cabinet/index?";
	}
	$(".type-management").click(function(){
		$(".disNone").hide();
		$(".listBoxType").show();
	});
    /**
     * @desc: 更柜管理-退柜设置-设置退柜配置
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/30
     */
    //更柜管理-退柜设置-点击显示退柜设置模态框
    $scope.showQuitCabinetSetting = function (num) {
        if (num == 1) {
            $('#quitCabinetSetting').modal('show');
            $http.get('/cabinet/get-quit-cabinet-value').then(function (result) {
                $scope.quitCabinetValue = result.data;
                $scope.setDays = $scope.quitCabinetValue.setDays;
                $scope.setCost = $scope.quitCabinetValue.setCost;
                if ($scope.quitCabinetValue.dateType == null || $scope.quitCabinetValue.dateType=='' || $scope.quitCabinetValue.dateType==undefined) {
                    $('#getDateType').val('everyDay');
                } else {
                    $('#getDateType').val($scope.quitCabinetValue.dateType);
                }

            })

        }
        if (num == 2) {
            $('#quitCabinetSetting').modal('hide');
        }
    }
    //更柜管理-退柜设置-获取表单数据
    $scope.getQuitCabinetData = function () {
        return {
            setDays     : $scope.setDays,               //设置到期退款天数
            dateType    : $('#getDateType').val(),      //设置超期扣除类型(日,周,月)
            setCost     : $scope.setCost,               //设置超期扣除金额
			_csrf_backend:yii.getCsrfToken(),
        };
    }
    //更柜管理-退柜设置-提交表单数据
    $scope.setQuitCabinetHttp = function () {
        $http({
            url         : '/cabinet/set-quit-cabinet',
            method      : 'POST',
            data        : $.param($scope.getQuitCabinetData()),
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (result) {
            if(result.data.status == 'success') {
                Message.success('保存成功');
                $scope.showQuitCabinetSetting(2);
            }else {
                Message.warning('保存失败');
            }
        })
    }
    //获取节点
    $scope.classFunc = function () {
        $(document).ready(function () {
            $('.showBoxTitle').on('click',function () {
                $('.showBoxTitle').removeClass('activeBox');
                $(this).addClass('activeBox');
            })
        });
    }
    //显示绑定柜子的消费情况,切换显示
    $scope.showBox = 1;
    $scope.isShowBox = true;
    $scope.showBoxClick = function (n) {
		switch(n) {
			case 1:
				$scope.showBox = 1;
                $scope.isShowBox = true;
				break;
			case 2:
                $scope.showBox = 2;
                $scope.isShowBox = false;
                break;
			default:
                $scope.showBox = 1;
                $scope.isShowBox = true;
		}
    }
	//获取会员绑定柜子的消费记录
	$scope.memberConsumList = function (url) {
		$http.get(url).then(function (result) {
                $scope.memberConsumListData = result.data.data;
                $scope.recordPages          = result.data.page;
        })
    }
	$scope.isShow = function (index, e) {
		e.stopPropagation();
		console.log(index)
		$scope.allCabinet[index].btnShow = !$scope.allCabinet[index].btnShow;
		console.log($scope.allCabinet[index].btnShow)
	}
});
