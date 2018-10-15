$(function(){

    var interval = null; //倒计时函数
    new Vue({
        el:'#register',
        data:{
            fun_id: 2,
            time: '获取验证码', //倒计时
            currentTime: 61,
            disabledFlag: false,
            getCode:'',
            companyName:'',//公司名称
            userName:'',//负责人名称
            phone:'',//手机号
            inputCode:'',//验证码
            storefrontNum:'',//店面数量
            region:'',//所在地区
            address:'',//详细地址

        },
        methods:{
            cityClick:function(){
                // $("#city-picker").cityPicker({
                //     title: "请选择所在区域"
                // });
            },

            getVerificationCode() {
                var that = this;
                var phoneNum = that.phone;
                if (!(/^1[3|4|5|6|7|8|9][0-9]\d{4,8}$/.test(phoneNum)) || phoneNum.length != 11) {
                    wx.showToast({
                        title: '手机号有误！',
                        icon: 'none',
                        duration: 1000
                    });
                }else if (!that.data.disabledFlag) {
                    that.setData({
                        disabledFlag: true
                    });
                    let data = {
                        mobile: that.phone
                    }
                    // wxRequest.getRequest(gerCodeUrl,data).then(function(res){
                    //     console.log('获取验证码',res.data.data);
                    //     if (res.data.status == "success"){
                    //         that.getCode();
                    //         that.setData({
                    //             getCode:res.data.data.code
                    //         })
                    //     } else if (res.data.status == "error"){
                    //         that.setData({
                    //             disabledFlag: false
                    //         });
                    //         wx.showToast({
                    //             icon:'none',
                    //             title: res.data.message,
                    //         })
                    //     }
                    // })
                }
            },
        }
    })




})