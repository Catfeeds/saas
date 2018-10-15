var app = angular.module('App').controller('addAreaCtrl', function($scope, $http, $location, $rootScope, $interval) {
	$('.group-ul').height($(window).height()-145 + 'px');
	$('.detialS').height($(window).height()-173 + 'px');
	$('.pp').height($(window).height()-173 + 'px');
	$('.vv').height($(window).height()-173 + 'px');
	$('.nn').height($(window).height()-207 + 'px');
	$('.nn').css('overflow-y', 'auto');
	$scope.str = decodeURI(location.search);
	$scope.str1 = $scope.str.split('?');
	$scope.str3 = $scope.str1[1].split('=');
	//添加新的区域
	$scope.addNewArea = function() {
		if(!$scope.addAreaButtonFlag) {
			var buyCardName = /^([a-zA-Z0-9\u4e00-\u9fa5 ]+)$/;
			if(!$scope.areaName || !(buyCardName.test($scope.areaName))) {
				Message.warning("请正确的区域名称!");
				return;
			}
			$scope.AddNewAreaData = function() {
				return {
					cabinetTypeName: $scope.areaName ? $scope.areaName : null,
					venueId: $scope.str3[1] ? $scope.str3[1] : null,
					_csrf_backend: $('#_csrf').val()
				}
			}
			$scope.addAreaButtonFlag = true;
			$http({
				url: "/cabinet/add-cabinet-type",
				method: 'POST',
				data: $.param($scope.AddNewAreaData()),
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(function(result) {
				if(result.data.status == 'success') {
					Message.success(result.data.data);
					//执行关闭模态框
					window.location.href = '/wcabinet/index'
				} else {
					$scope.addAreaButtonFlag = false;
				}
			});
		}
	};
	$scope.cancel = function () {
		console.log('-------')
		window.history.go(-1);
	};
})
