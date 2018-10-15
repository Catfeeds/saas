define({ "api": [
  {
    "type": "get",
    "url": "/v1/api-member/is-update",
    "title": "app是否更新",
    "version": "1.0.0",
    "name": "App____",
    "group": "App",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "appType",
            "description": "<p>app类型      android 或则 ios</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venue",
            "description": "<p>场馆名称 \t   WAYD 代表我爱运动  maibu 代表迈步</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "versionCode",
            "description": "<p>版本号</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v1/api-member/is-update app更新设置\n  {\n     \"appType\" : android    // android 或则 ios（代表app类型）\n     \"venue\"   :  WAYD     //WAYD 代表我爱运动  maibu 代表迈步\n     \"versionCode\":  1.14.10  // 版本号\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>app是否更新 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/12/5</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/is-update"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n\"code\": 1,     // 参数传入是否合法\n\"message\": \"请求正常\",\n\"update\": 2,         // 1是必须更新 2是不必须更新\n\"hasVersion\": false  //是否有新版本\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,     // 参数传入是否合法\n\"message\": \"请求正常\",\n\"update\": 1,         // 1是必须更新 2是不必须更新\n\"hasVersion\": true  //是否有新版本\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "App"
  },
  {
    "type": "post",
    "url": "/v1/api-member/update-config",
    "title": "app更新设置",
    "version": "1.0.0",
    "name": "App____",
    "group": "AppConfig",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "appType",
            "description": "<p>app类型      android 或则 ios</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venue",
            "description": "<p>场馆名称 \t   WAYD 代表我爱运动  maibu 代表迈步</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "isMustUpdate",
            "description": "<p>是否必须更新  1代表必须更新 2代表不必须更新</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post           /v1/api-member/update-config  app更新设置\n  {\n     \"appType\" : android    // android 或则 ios（代表app类型）\n     \"venue\"   :  WAYD     //WAYD 代表我爱运动  maibu 代表迈步\n     \"isMustUpdate\" :  1  // 是否必须更新 1代表必须更新 2代表 不必须更新\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>app更新设置 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/12/5</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/update-config"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",        //成功标识\n \"message\":\"数据录入成功\"    //数据录入成功\n \"data\": true                // 录入成功的信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"录入失败信息\"     //失败返回信息\n \"data\": false 或者 true\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "AppConfig"
  },
  {
    "type": "post",
    "url": "/v1/api-member/login",
    "title": "密码登录",
    "version": "1.0.0",
    "name": "____",
    "group": "Login",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companySign",
            "description": "<p>app所属公司标识(WAYD:我爱运动瑜伽健身   MB:迈步运动健身;)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "loginVenueId",
            "description": "<p>登录场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/login\n{\n     \"mobile\":15011122233   //会员id\n     \"password\":******      //密码\n      \"companySign\":WAYD       // WAYD:我爱运动瑜伽健身   MB:迈步运动健身;\n      \"loginVenueId\": 33       // 登录场馆id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户登录 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/login"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情",
          "content": "{\n \"code\":1,                            //成功标识\n \"status\":\"success\",\n \"message\":\"登录成功\",\n \"data\": {\n    \"id\": 18112,\n    \"username\": \"刘\",                 //用户名（基本信息表）\n    \"password\": \"$2y$13$F6YkUNcKw6wduAkvVuhyxOOVJLliq3j.ykdu69TAw2j7FjNfqv7z6\",  //加密后的密码\n    \"mobile\": \"17740400375\",         //手机号\n    \"register_time\": \"1495699487\",   //注册时间\n    \"password_token\": null,\n    \"hash\": null,\n    \"update_at\": null,               //修改时间\n    \"last_time\": null,               //最近一次登录时间\n    \"last_fail_login_time\": null,    //上次登录失败时间\n    \"times\": null,                   //登录失败次数\n    \"status\": 0,                     //状态：0待审核，1正常，2禁用\n    \"lock_time\": null,               //锁定时长\n    \"params\": null,                  //扩展\n    \"counselor_id\": \"94\",            //顾问ID\n    \"member_type\": 1,                //1普通会员 2 潜在会员\n    \"venue_id\": null,                //场馆id\n    \"is_employee\": null,             //是不是员工：1 代表是\n    \"company_id\": null,              //公司id\n    \"fixPhone\": null,                //固定电话\n    \"detailsId\": \"13\",               //会员详情表id\n    \"detailsName\": \"黄鹏举\",         //姓名（详细信息表）\n    \"member_id\": \"13\",               //会员id\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/\", //会员头像\n    \"nickname\": \"张三\",              //昵称\n    \"identify\": 1                    //身份1 普通 2金爵、尊爵\n  }\n},\n{\n \"code\":0,                   //失败标识\n \"status\":\"error\",           //失败标识\n \"message\":\"登录失败\",       //登录失败信息\n  \"data\": {                  //登录失败报错信息\n     \"password\": [\n      \"密码不能为空\"\n     ]\n  }\n},",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "Login"
  },
  {
    "type": "post",
    "url": "/v1/api-member/get-member-one",
    "title": "获取会员信息",
    "version": "1.0.0",
    "name": "____",
    "group": "Login",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员ID</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/login\n{\n     \"memberId\":15011122233   //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户登录 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-one"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情",
          "content": "{\n \"code\":1,                            //成功标识\n \"status\":\"success\",\n \"message\":\"登录成功\",\n \"data\": {\n    \"id\": 18112,\n    \"username\": \"刘\",                 //用户名（基本信息表）\n    \"password\": \"$2y$13$F6YkUNcKw6wduAkvVuhyxOOVJLliq3j.ykdu69TAw2j7FjNfqv7z6\",  //加密后的密码\n    \"mobile\": \"17740400375\",         //手机号\n    \"register_time\": \"1495699487\",   //注册时间\n    \"password_token\": null,\n    \"hash\": null,\n    \"update_at\": null,               //修改时间\n    \"last_time\": null,               //最近一次登录时间\n    \"last_fail_login_time\": null,    //上次登录失败时间\n    \"times\": null,                   //登录失败次数\n    \"status\": 0,                     //状态：0待审核，1正常，2禁用\n    \"lock_time\": null,               //锁定时长\n    \"params\": null,                  //扩展\n    \"counselor_id\": \"94\",            //顾问ID\n    \"member_type\": 1,                //1普通会员 2 潜在会员\n    \"venue_id\": null,                //场馆id\n    \"is_employee\": null,             //是不是员工：1 代表是\n    \"company_id\": null,              //公司id\n    \"fixPhone\": null,                //固定电话\n    \"detailsId\": \"13\",               //会员详情表id\n    \"detailsName\": \"黄鹏举\",         //姓名（详细信息表）\n    \"member_id\": \"13\",               //会员id\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/\", //会员头像\n    \"nickname\": \"张三\",              //昵称\n    \"identify\": 1                    //身份1 普通 2金爵、尊爵\n  }\n},\n{\n \"code\":0,                   //失败标识\n \"status\":\"error\",           //失败标识\n \"message\":\"登录失败\",       //登录失败信息\n  \"data\": {                  //登录失败报错信息\n     \"password\": [\n      \"密码不能为空\"\n     ]\n  }\n},",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "Login"
  },
  {
    "type": "post",
    "url": "/v1/api-member/login-code",
    "title": "验证码登录",
    "version": "1.0.0",
    "name": "_____",
    "group": "Login",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companySign",
            "description": "<p>app所属公司标识(WAYD:我爱运动瑜伽健身   MB:迈步运动健身;)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "loginVenueId",
            "description": "<p>登录场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/login\n{\n     \"mobile\":15011122233  //会员手机号\n     \"code\":456123         //验证码\n      \"companySign\":WAYD   // 场馆标识\n       \"loginVenueId\":33   // 登录场馆id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户登录 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/login-code"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情",
          "content": "{\n \"code\":1,                   //成功标识\n \"status\":\"success\",\n \"message\":\"登录成功\",\n \"data\": {\n    \"id\": 18112,\n    \"username\": \"刘\",                 //用户名\n    \"password\": \"$2y$13$F6YkUNcKw6wduAkvVuhyxOOVJLliq3j.ykdu69TAw2j7FjNfqv7z6\",  //加密后的密码\n    \"mobile\": \"17740400375\",         //手机号\n    \"register_time\": \"1495699487\",   //注册时间\n    \"password_token\": null,\n    \"hash\": null,\n    \"update_at\": null,               //修改时间\n    \"last_time\": null,               //最近一次登录时间\n    \"last_fail_login_time\": null,    //上次登录失败时间\n    \"times\": null,                   //登录失败次数\n    \"status\": 0,                     //状态：0待审核，1正常，2禁用\n    \"lock_time\": null,               //锁定时长\n    \"params\": null,                  //扩展\n    \"counselor_id\": \"94\",            //顾问ID\n    \"member_type\": 1,                //1普通会员 2 潜在会员\n    \"venue_id\": null,                //场馆id\n    \"is_employee\": null,             //是不是员工：1 代表是\n    \"company_id\": null,              //公司id\n    \"fixPhone\": null,                //固定电话\n    \"detailsId\": \"13\",               //会员详情表id\n    \"detailsName\": \"黄鹏举\",         //姓名\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/\", //会员头像\n    \"nickname\": \"张三\",              //昵称\n    \"identify\": 1                    //身份1 普通 2金爵、尊爵\n  }\n},\n{\n \"code\":0,                   //失败标识\n \"status\":\"error\",\n \"message\":\"登录失败\",* },",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "Login"
  },
  {
    "type": "get",
    "url": "/v1/api-member/member-leave-record",
    "title": "",
    "version": "1.0.0",
    "name": "______",
    "group": "MemberLeaveRecord",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get    /v1/api-member/member-leave-record  用户活跃统计\n  {\n[member_card_id] => 20278          //  会员卡id\n[leaveProperty] =>1                // 1代表未审核 2代表已经审核 3:已拒绝 4：（针对特殊请假 正常请假直接是2）\n[leaveStatus] => 2                  // status 1代表假期中 2代表 已销假 3已过期\n[leave_start_time] => 1501084800    // 请假开始时间\n[leave_end_time] => 1503849599     // 请假结束时间\n[leaveType] => 1            //  1表示正常 请假   2代表特殊请假\n[create_at] => 1501854942   // 请假创建时间\n[note] =>                     // 请假原因\n[card_name] => *WDSXK0018*13个月卡 // 会员卡名称\n[hour] => 9:25:25             // 几点请的假\n[date] => 2017-08-04   // 请假日期\n[leaveDays]=>30       // 请假天数",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户活跃统计 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>侯凯新@itsprts.club <span><strong>创建时间：</strong></span>2017/01/03</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/member-leave-record"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",         //成功状态\n  \"data\": [\n      {\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "MemberLeaveRecord"
  },
  {
    "type": "post",
    "url": "/v1/api-about-record/set-about-record",
    "title": "约课接口",
    "version": "1.0.0",
    "name": "____",
    "group": "aboutClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "coachId",
            "description": "<p>教练id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "classId",
            "description": "<p>预约id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "classDate",
            "description": "<p>约课时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberCardId",
            "description": "<p>会员卡id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "seatId",
            "description": "<p>座位id(团课用)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "classType",
            "description": "<p>课程类型（charge表示私课，group表示团课）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "aboutType",
            "description": "<p>预约类型：团课app  私课 mobile</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数(私课)",
          "content": "POST /v1/api-about-record/set-about-record\n{\n     \"memberId\":107，              //会员id\n     \"coachId\":107，               //教练id\n     \"classId\":10，                //预约id\n     \"classDate\":2017-06-17 15:00，//会员id\n     \"classType\":\"group\"，          //group表示团课，charge表示私课\n     \"aboutType\":\"mobile\"，          //mobile表示手机自助预约\n}",
          "type": "json"
        },
        {
          "title": "请求参数(团课)",
          "content": "POST /v1/api-member/login\n{\n     \"memberId\":107，              //会员id\n     \"coachId\":107，               //教练id\n     \"classId\":10，                //预约id\n     \"classDate\":2017-06-17 15:00，//会员id\n     \"classType\":\"group\"，          //group表示团课，charge表示私课\n     \"aboutType\":\"mobile\"，          // 团课预约：app 私课预约 mobile\n     \"seatId\":12,                  //座位id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户约课 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-about-record/set-about-record"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                //成功返回标识\n \"status\": \"success\",     //成功返回标识\n \"message\": \"预约成功\",   //成功返回信息\n \"data\": \"50\"             //预约记录id\n \"isClass\" : 1            // 1 上课中 3 已使用 2待使用\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,             //失败标识\n  \"status\": \"error\",     //失败标识\n  \"message\": \"预约失败\", //失败信息\n  \"data\": \"not repeat\"  //重复预约\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiAboutRecordController.php",
    "groupTitle": "aboutClass"
  },
  {
    "type": "GET",
    "url": "/v1/api-member-card/absent-record",
    "title": "会员旷课记录",
    "version": "1.0.0",
    "name": "______",
    "group": "absentRecord",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "identify",
            "description": "<p>//请求身份  card：会员卡 member：会员</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "identifyId",
            "description": "<p>// 会员卡id 或 会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "courseType",
            "description": "<p>// 1 代表 私课  2代表 团课  3 代表私课和团课</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET  /v1/api-member-card/absent-record\n{\n     \"identify\":\"card\"             //请求身份  card：会员卡 member：会员\n     \"identifyId\":2              // 会员卡id 或 会员id\n     \"courseType\":1              // 1 代表 私课  2代表 团课\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员旷课记录 <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/10/06</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/absent-record"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n     \"code\": 1,              //成功标识\n     \"status\": \"success\",    //成功标识\n     \"data\": \"提交成功\",      //成功信息\n     \"data\":[\n      \"id\": \"4029\",       // 约课id\n      \"member_card_id\": \"43030\", // 会员卡id\n      \"class_id\": \"6387\",       // 排课id\n      \"coach_id\": \"76\",        // 教练id\n      \"coachName\": \"贾慧\",     // 教练名称\n      \"classroomName\": \"3号厅\",  // 上课教师\n      \"courseName\": \"爵士街舞\",   // 课程名称\n      \"memberCardName\": \"D12M MD\",  // 卡名称\n      \"courseStartTime\": \"1507188900\",  // 开课时间\n      \"courseEndTime\": \"1507189020\",   // 课程结束时间\n       \"courseDate\": \"2017-10-05\"    // 课程日期\n       \"courseType\": \"2\"\"            // 1 私课 2 团课\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n     \" code\": 0,             //购买失败\n     \"status\": \"error\",      //失败标识\n     \"message\": \"购买失败\",  //失败信息\n     \"data\": []              //保存失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "absentRecord"
  },
  {
    "type": "post",
    "url": "/v1/api-payment/sell-card",
    "title": "ios支付接口",
    "version": "1.0.0",
    "name": "ios____",
    "group": "api_payment",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "typeId",
            "description": "<p>类型Id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>类型:私课:'charge' 卡种:'card'</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "amountMoney",
            "description": "<p>金额</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "paymentType",
            "description": "<p>支付类型</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "num",
            "description": "<p>课程节数</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "coachId",
            "description": "<p>教练id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"typeId\"        => 1,\n     \"type\"          => 'charge',card\n      \"amountMoney\"  => '1000'\n     \"memberId\"      => 1,\n     \"paymentType\"   => \"1\",\n     'num'           =>'1000',\n     \"coachId\"       =>12     \n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>ios支付接口<br/> <span><strong>作    者：</strong></span>李慧恩<br> <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br> <span><strong>创建时间：</strong></span>2017/6/6<br> <span><strong>调用方法：</strong></span>/api-payment/sell-card</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/sell-card"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\": \"1\",\n\"status\": \"success\",\n\"message\": \"成功\",\n\"data\": {\n\"appid\": \"wxsajdhuuasjuhdjashb2\",\n\"partnerid\": \"1485481212432\",\n\"prepayid\": \"wx201707dwsadasjidahsidhass15718\",\n\"noncestr\": \"con0S2GmUA7AZdCu\",\n\"timestamp\": 1500262115,\n\"package\": \"Sign=WXPay\",\n\"sign\": \"AD03A38528F5FFFFFASDWS12324112DC52F4\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "api_payment"
  },
  {
    "type": "post",
    "url": "/v1/api-payment/ali-pay-sell-card",
    "title": "ios支付宝接口",
    "version": "1.0.0",
    "name": "ios_____",
    "group": "api_payment",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardId",
            "description": "<p>卡id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "courseType",
            "description": "<p>类型  1代表私课 2代表团课</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "amountMoney",
            "description": "<p>金额</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"cardId\"        => 2345,        // 卡id\n     \"courseType\"    => 1,          // 1私课 2团课\n     \"amountMoney\"  => '1000'       // 缴纳金额\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>ios支付接口<br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br> <span><strong>创建时间：</strong></span>2017/10/10<br> <span><strong>调用方法：</strong></span>/v1/api-payment/ali-pay-sell-card</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/ali-pay-sell-card"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\"  :１，\n\"status\": \"success\",\n\"message\": \"成功\"，\n\"data\"   :{\n 'appid'       => '123456457',\n 'secret'      => 私钥,\n 'service'     => 接口名称\n‘input_charset’ => 编码类型\n  'subject'       =>商品标题\n 'price'         =>  金额\n 'out_trade_no'   => '12356423514241234',订单号\n 'attach'   => '1',订单ID\n 'body'        => '商品介绍',\n‘sign’      => 签名\n ‘sign_type’ => 签名算法类型\n'callback'    => 'http://qa.aixingfu.net/payment/notify',\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "api_payment"
  },
  {
    "type": "post",
    "url": "/v1/api-payment/ali-pay-thaw-card",
    "title": "ios支付宝接口(罚金)",
    "version": "1.0.0",
    "name": "ios_________",
    "group": "api_payment",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardId",
            "description": "<p>卡id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "courseType",
            "description": "<p>类型  1代表私课 2代表团课</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "amountMoney",
            "description": "<p>金额</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueType",
            "description": "<p>是否是迈步场馆 如果是：maiBu 不是:notMaiBu</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"cardId\"        => 1,\n      \"amountMoney\"  => '1000'\n     \"paymentType\"   => \"1\",\n      \"venueType\"    => \"maiBu\"    // 场馆类型 是迈步场馆\"maiBu\"  不是迈步 \"notMaiBu\"\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>ios支付接口<br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br> <span><strong>创建时间：</strong></span>2017/6/6<br> <span><strong>调用方法：</strong></span>/v1/api-payment/ali-pay-thaw-card</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/ali-pay-thaw-card"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\"  :１，\n\"status\": \"success\",\n\"message\": \"成功\"，\n\"data\"   :{\n 'appid'       => '123456457',\n 'secret'      => 私钥,\n 'service'     => 接口名称\n‘input_charset’ => 编码类型\n  'subject'       =>商品标题\n 'price'         =>  金额\n 'out_trade_no'   => '12356423514241234',订单号\n 'attach'   => '1',订单ID\n 'body'        => '商品介绍',\n‘sign’      => 签名\n ‘sign_type’ => 签名算法类型\n'callback'    => 'http://qa.aixingfu.net/payment/notify',\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "api_payment"
  },
  {
    "type": "post",
    "url": "/v1/api-payment/app-thaw-member-card",
    "title": "app团课被冻结解冻",
    "version": "1.0.0",
    "name": "______",
    "group": "api_thaw_payment",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardId",
            "description": "<p>卡id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "courseType",
            "description": "<p>类型  1代表私课 2代表团课</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "amountMoney",
            "description": "<p>金额</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueType",
            "description": "<p>场馆类型   是:&quot;maiBu&quot; 不是：&quot;notMaiBu&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"cardId\"        => 2345,        // 卡id\n     \"courseType\"    => 1,          // 1私课 2团课\n     \"amountMoney\"   => '1000'       // 缴纳金额\n     \"venueType\"     =>\"maiBu\"      //  是否是迈步的app 是:\"maiBu\" 不是：\"notMaiBu\"\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>app团课被冻结解冻缴纳罚金<br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>侯凯新@itsports.club<br> <span><strong>创建时间：</strong></span>2017/10/6<br> <span><strong>调用方法：</strong></span>/v1/api-payment/app-thaw-member-card</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/app-thaw-member-card"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\": \"1\",\n\"status\": \"success\",\n\"message\": \"成功\",\n\"data\": {\n\"appid\": \"wxsajdhuuasjuhdjashb2\",\n\"partnerid\": \"1485481212432\",\n\"prepayid\": \"wx201707dwsadasjidahsidhass15718\",\n\"noncestr\": \"con0S2GmUA7AZdCu\",\n\"timestamp\": 1500262115,\n\"package\": \"Sign=WXPay\",\n\"sign\": \"AD03A38528F5FFFFFASDWS12324112DC52F4\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "api_thaw_payment"
  },
  {
    "type": "post",
    "url": "/v1/api-member/bind-member-base-info",
    "title": "绑定会员信息",
    "version": "1.0.0",
    "name": "______",
    "group": "binds",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idCard",
            "description": "<p>身份证号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sex",
            "description": "<p>性别</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/login\n{\n     \"memberId\":15011122233   //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户登录 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/bind-member-base-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情",
          "content": "{\n \"code\":1,                            //成功标识\n \"status\":\"success\",\n \"message\":\"绑定成功\",\n \"data\": {\n  }\n},\n{\n \"code\":0,                   //失败标识\n \"status\":\"error\",           //失败标识\n \"message\":\"绑定失败\",       //登录失败信息\n  \"data\": {                  //登录失败报错信息\n   \n  }\n},",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "binds"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-member-cabinet-info",
    "title": "柜子详细信息",
    "version": "1.0.0",
    "name": "______",
    "group": "cabinetInfo",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberCabinetId",
            "description": "<p>会员柜子id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-member-cabinet-info\n{\n   \"memberCabinetId\" :'100'                            //会员柜子id\n   \"memberId\" :'100'                                   //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员卡列表 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-cabinet-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": {\n     \"memberCabinetId\": \"1\",         //会员柜子id\n     \"cabinet_id\": \"1\",              //柜子表id\n     \"price\": \"650\",                 //总金额\n     \"start_rent\": \"2017-06-27\",     //租用日期\n     \"end_rent\": \"2017-12-27\",       //结束日期\n     \"status\": \"1\",                  //柜子状态：1未到期，2快到期，3到期，4逾期\n     \"cabinetNum\": \"-0001\",          //柜子编号\n     \"cabinetModel\": \"大柜\",         //柜子类型\n     \"cabinetDay\": 183,              //租用天数\n     \"deposit\": 50                   //押金（注：会员绑定柜子时没有存押金，沟通后得知所有柜子押金都为50）\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //失败提示信息\n \"data\":\"柜子详细信息不存在\"    //具体报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "cabinetInfo"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-member-cabinet",
    "title": "会员所有柜子",
    "version": "1.0.0",
    "name": "______",
    "group": "cabinetList",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-member-cabinet\n{\n   \"memberId\" :'100'                                   //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员卡列表 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-cabinet"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": [\n {\n     \"memberCabinetId\": \"1\",     //会员柜子id\n     \"cabinet_id\": \"1\",          //柜子id\n     \"cabinetNum\": \"-0001\",      //柜子编号\n     \"cabinetModel\": \"大柜\"      //柜子类型\n },\n {\n     \"memberCabinetId\": \"2\",     //会员柜子id\n     \"cabinet_id\": \"2\",          //柜子id\n     \"status\": \"1\",              //柜子状态：1未到期，2快到期，3到期，4逾期\n     \"cabinetNum\": \"-0002\",      //柜子编号\n     \"cabinetModel\": \"大柜\"      //柜子类型\n }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //失败提示信息\n \"data\":\"该会员未租用柜子\"    //具体报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "cabinetList"
  },
  {
    "type": "post",
    "url": "/v1/api-payment/we-chat-cabinet-order",
    "title": "微信 柜子租赁下订单",
    "version": "1.0.0",
    "name": "_______",
    "group": "cabinet",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cabinetId",
            "description": "<p>柜子id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "price",
            "description": "<p>价格</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "startRent",
            "description": "<p>租用开始时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "endRent",
            "description": "<p>租用结束时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueType",
            "description": "<p>场馆类型   是:&quot;maiBu&quot; 不是：&quot;notMaiBu&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"venueId\"       => 12,        // 卡id\n     \"companyId\"    => 13,          // 1私课 2团课\n     \"memberId\"   => 1000          // 会员id\n     “cabinetId” =>76            // 柜子id\n      \"startRent\"  =>\"2017-01-12\"   // 租用开始时间\n      \"endRent\"    => \"2017-06-12\"  // 柜子租用的结束时间\n      \"price\"=>55                  // 价格55元\n     \"venueType\" =>\"maiBu\"         //  是否是迈步的app 是:\"maiBu\" 不是：\"notMaiBu\"\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>柜子租赁下订单<br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>侯凯新@itsports.club<br> <span><strong>创建时间：</strong></span>2017/01/08<br> <span><strong>调用方法：</strong></span>/v1/api-payment/we-chat-cabinet-order</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/we-chat-cabinet-order"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\": \"1\",\n\"status\": \"success\",\n\"message\": \"成功\",\n\"data\": {\n\"appid\": \"wxsajdhuuasjuhdjashb2\",\n\"partnerid\": \"1485481212432\",\n\"prepayid\": \"wx201707dwsadasjidahsidhass15718\",\n\"noncestr\": \"con0S2GmUA7AZdCu\",\n\"timestamp\": 1500262115,\n\"package\": \"Sign=WXPay\",\n\"sign\": \"AD03A38528F5FFFFFASDWS12324112DC52F4\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "cabinet"
  },
  {
    "type": "get",
    "url": "/v1/api-member/calculate-date",
    "title": "计算柜子到期日期",
    "version": "1.0.0",
    "name": "________",
    "group": "cabinet",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "startRent",
            "description": "<p>租柜开始日期</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "numberMonth",
            "description": "<p>租柜月数</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "GET   /v1/api-member/home-data\n{\n      startRent :2016-12-08,     //租柜开始日期\n      numberMonth：3,            // 租用月数\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>根据前端输入值计算柜子到期日期 <br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>houkaixin@itsports.club <span><strong>创建时间：</strong></span>2017/01/08</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/calculate-date"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n  'id' => string '1' ,                    //柜子id\n};",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "cabinet"
  },
  {
    "type": "get",
    "url": "/v1/api-payment/text-notify",
    "title": "柜子回调业务测试",
    "version": "1.0.0",
    "name": "________",
    "group": "cabinet",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "orderId",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"orderId\"        => 5567,   //订单id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>柜子回调业务测试 <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>houkaixn@itsports.club<br> <span><strong>创建时间：</strong></span>2018/01/09<br> <span><strong>调用方法：</strong></span>/v1/api-payment/text-notify</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/text-notify"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\"  :１，\n\"status\": \"success\",\n\"message\": \"成功\"，\n\"data\"   :{\n 'appid'       => '123456457',\n 'secret'      => 私钥,\n 'service'     => 接口名称\n‘input_charset’ => 编码类型\n  'subject'       =>商品标题\n 'price'         =>  金额\n 'out_trade_no'   => '12356423514241234',订单号\n 'attach'   => '1',订单ID\n 'body'        => '商品介绍',\n‘sign’      => 签名\n ‘sign_type’ => 签名算法类型\n'callback'    => 'http://qa.aixingfu.net/payment/notify',\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "cabinet"
  },
  {
    "type": "post",
    "url": "/v1/api-payment/ali-cabinet-order",
    "title": "支付宝柜子租赁订单",
    "version": "1.0.0",
    "name": "__________",
    "group": "cabinet",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cabinetId",
            "description": "<p>柜子id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "price",
            "description": "<p>价格</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "startRent",
            "description": "<p>租用开始时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "endRent",
            "description": "<p>租用结束时间</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueType",
            "description": "<p>场馆类型   是:&quot;maiBu&quot; 不是：&quot;notMaiBu&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "{\n     \"venueId\"       => 12,        // 卡id\n     \"companyId\"    => 13,          // 1私课 2团课\n     \"memberId\"   => 1000          // 会员id\n     “cabinetId” =>76            // 柜子id\n      \"startRent\"  =>\"2017-01-12\"   // 租用开始时间\n      \"endRent\"    => \"2017-06-12\"  // 柜子租用的结束时间\n      \"price\"=>55                  // 价格55元\n     \"venueType\" =>\"maiBu\"         //  是否是迈步的app 是:\"maiBu\" 不是：\"notMaiBu\"\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>柜子租赁下订单<br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>侯凯新@itsports.club<br> <span><strong>创建时间：</strong></span>2017/01/08<br> <span><strong>调用方法：</strong></span>/v1/api-payment/we-chat-cabinet-order</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-payment/ali-cabinet-order"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>返回状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回状态的数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n\"code\": \"1\",\n\"status\": \"success\",\n\"message\": \"成功\",\n\"data\": {\n\"appid\": \"wxsajdhuuasjuhdjashb2\",\n\"partnerid\": \"1485481212432\",\n\"prepayid\": \"wx201707dwsadasjidahsidhass15718\",\n\"noncestr\": \"con0S2GmUA7AZdCu\",\n\"timestamp\": 1500262115,\n\"package\": \"Sign=WXPay\",\n\"sign\": \"AD03A38528F5FFFFFASDWS12324112DC52F4\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{\n\"status\": \"error\",\n\"message\": \"失败\",\n\"data\": {\n\"name\": [\n\"请填写姓名\"\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPaymentController.php",
    "groupTitle": "cabinet"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-cabinet-type",
    "title": "获取柜子类型各个类型",
    "version": "1.0.0",
    "name": "_____________",
    "group": "cabinet",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "GET  /v1/api-member/get-cabinet-type\n{\n     venueId :52,   //场馆id\n\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取柜子类型的各个参数 1 柜子名称 2 柜子总数量 3 已租柜子数量 <br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br> <span><strong>创建时间：</strong></span>2017/6/4</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-cabinet-type"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n     \"id\":1,             //柜子类型id\n     \"type_name\":\"女大柜\"， //柜子类型名称\n     'cabinetNum':13，    //柜子总数量\n     'is_rent':12，      //柜子被租数量\n};",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "cabinet"
  },
  {
    "type": "get",
    "url": "/v1/api-member/home-data",
    "title": "柜子（对应柜子类型下面的）",
    "version": "1.0.0",
    "name": "_________________",
    "group": "cabinet",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "typeId",
            "description": "<p>柜子类型id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "nowBelongId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>第几页 如果是 第一页 可以不传  第二页 传2</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "GET   /v1/api-member/home-data\n{\n      typeId   :52,             //柜子类型id\n      nowBelongId：55,         // 场馆id\n      page：2                  // 请求页码\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>指定各个柜子的租用状态数据分页显示 <br/> <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>houkaixin@itsports.club <span><strong>创建时间：</strong></span>2017/6/4</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/home-data"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "optional": false,
            "field": "data",
            "description": "<p>返回数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{\n  'id' => string '1' ,                    //柜子id\n  'cabinet_type_id' => string '1' ,       //柜子类型id\n 'cabinet_number' => string '大大上海瑜伽健身馆-0001'  //柜子编号\n  'status' => string '2'                 // 柜子租用状态 （1未租 2 已租 3 维修状态）\n 'type_name' => string '萨嘎'            // 柜子类型名字\n 'venueId' => string '47' (length=2)    // 柜子场馆id\n 'cabinetModel' => string '2'           //柜子规格 1:大柜2:中柜3:小柜\n 'cabinetType' => string '2'           //柜子类型  1:临时2:正式\n  \"old_give_month\"=>1                      //赠送月数(老规则)\n  \"monthRentPrice\"=>\"50\"               // 月租金\n  \"yearRentPrice\"=>\"100\"               // 年租金\n  \"give_month\"{\n     \"month\": 6,      // 购买6个月\n     \"give\": 1,      // 赠送一个月\n    \"money\": \"600\"   // 金额 600\n}\n],\n};",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "cabinet"
  },
  {
    "type": "get",
    "url": "/v1/api-about-record/cancel-about",
    "title": "取消约课接口",
    "version": "1.0.0",
    "name": "______",
    "group": "cancelClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "aboutId",
            "description": "<p>会员约课记录id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-about-record/cancel-about\n{\n     \"aboutId\":107，              会员约课记录id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户取消约课 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-about-record/cancel-about"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\":1,               //成功标识            \n \"status\": \"success\",    //成功状态\n \"message\": \"取消成功\"   //取消信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiAboutRecordController.php",
    "groupTitle": "cancelClass"
  },
  {
    "type": "get",
    "url": "/v1/api-private/get-private-class-info",
    "title": "私课产品详情",
    "version": "1.0.0",
    "name": "______",
    "group": "chargeClassDetail",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>产品id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/get-private-class-info\n{\n     \"id\":10                  //产品id\n     \"memberId\":10            //会员id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>私课产品详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/3</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/get-private-class-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,\n\"status\": \"success\",\n\"message\": \"请求成功\",\n\"data\": {\n   \"id\": \"2\",                                    //产品id\n   \"product_name\": \"私课单节\",                   //产品名称\n   \"desc\": \"这是单节课\",                        //产品描述\n   \"pic\": \"xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\",     //产品描述\n   \"score\": 4,                                   //产品级别\n   \"venue_id\": \"2\",                              //场馆id\n   \"venueName\": \"大上海馆\",                      //场馆名称\n   \"venueAddress\": \"\",                           //场馆地址\n   \"venuePic\": \"http://oo0oj2qmr.bkt.cloudcom\",  //场馆图片\n   \"intervalArr\": [                              //价位区间（单节课时出现，套餐时不出现）false表示没有区间价\n   {\n         \"intervalStart\": \"1\",                   //区间开始数\n         \"intervalEnd\": \"10\",                    //区间结束数\n         \"unitPrice\": \"10\",                      //优惠单价\n         \"posPrice\": \"10\"                        //pos机价\n   },\n   {\n         \"intervalStart\": \"11\",                  //区间开始数\n         \"intervalEnd\": \"20\",                    //区间结束数\n         \"unitPrice\": \"5\",                       //优惠单价\n         \"posPrice\": \"5\"                         //pos机价\n   },\n   ],\n   \"product\": false,                             //true表示该课程（已购买）可以预约，false表示该课程（未购买）不能预约\n    \"newMember\": false,                           // true是新会员（用posPrice价）, false不是新会员（unitPrice价）\n   \"memberCard\":true,                            //true表示买过会员卡，false表示没买个\n   \"category\": \"2\",                              //1表示是套餐，2表示是单节课程\n   \"orderId\": false,                             //false会员没有买该课程（同上），当会员买个课时此字段的值就是订单id\n   \"money_amount\": 10,                           //套餐的总价，单节课程的单节原价\n   \"course_amount\": 1,                           //总量\n   \"memberCourseOrderDetails\": [\n   {\n       \"course_num\": 1,                          //课量\n       \"course_id\": \"18\",                        //课种id\n       \"id\": \"3\",                                //课程套餐详情表id\n       \"charge_class_id\": \"2\",                   //产品id\n       \"course_length\": \"100\",                   //课时长\n       \"original_price\": \"10\",                   //售卖单价\n       \"category\": \"2\",                          //1表示多节2表示单节课程\n       \"name\": \"减脂\"                            //课种名称\n   }\n   ]\n \"score\": 4,                                     //星级\n  \"scoreImg\": {\n  \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241W3S:\",\n  \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=14:-mWe\",\n  \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=14W3S:-\",\n  \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=14S:-mW\",\n  \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=14S:dh\"\n  },\n  \"tag\": [                                       //特色\n  \"减脂\",\n  \"特色\"\n  ]\n}\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败状态\n  \"message\": \"未获取到数据\"                   //失败原因\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "chargeClassDetail"
  },
  {
    "type": "get",
    "url": "/v1/api-private/get-private-detail",
    "title": "产品中的课程详情",
    "version": "1.0.0",
    "name": "________",
    "group": "chargeClassDetail",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>产品id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/get-private-detail\n{\n     \"id\":10                  //产品id\n     \"memberId\":10            //会员id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>私课产品详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/3</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/get-private-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,               //成共标识\n\"status\": \"success\",     //成功状态\n\"message\": \"请求成功\",   //成功返回信息\n\"data\": [\n     {\n     \"id\": \"2\",                                //产品id\n     \"product_name\": \"私课单节\",               //产品名称\n     \"pic\": \"xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\", //产品图片\n     \"packageClass\": [                         //产品详细\n     {\n         \"name\": \"减脂\",                       //课种名称\n         \"times\": 1,                           //第几节\n         \"class_length\": \"100\",                //课时长\n         \"sale_price\": \"10\",                   //售卖单价\n         \"is_member\": \"1\",                     //是不是会员\n         \"status\": \"1\"                         //1表示上过，2表示没上过\n     }\n     ],\n     \"money_amount\": 10,                      //总价\n     \"course_amount\": 1,                      //总节数\n     \"score\": 4,                              //级别\n     \"scoreImg\": {                            //星星图片\n         \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n         \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n         \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n         \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n         \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?\"\n     }\n     }\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败状态\n  \"message\": \"未获取到数据\"                   //失败原因\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "chargeClassDetail"
  },
  {
    "type": "get",
    "url": "/v3/api-class/get-all-venue",
    "title": "所有场馆",
    "version": "1.0.0",
    "name": "____",
    "group": "chargeClass",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-class/get-all-venue\n{\n     \"companyId\":1,                 //公司id\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "description": "<p>所有场馆 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/7/4</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-all-venue"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                   //成功表示\n\"status\": \"success\",         //成功状态\n\"message\": \"请求成功\",        //成功信息\n\"data\": [\n     {\n     \"id\": \"2\",                    //场馆id\n     \"name\": \"大上海瑜伽健身馆\"       //场馆名称\n     },\n     {\n     \"id\": \"10\",                  //场馆id\n     \"name\": \"大学路舞蹈健身馆\"      //场馆名称\n     }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                         //失败标识\n  \"status\": \"error\",                 //失败标识\n  \"message\": \"没有找到场馆信息\"         //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v1/api-private/get-all-private-class",
    "title": "所有私课产品",
    "version": "1.0.0",
    "name": "______",
    "group": "chargeClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "course",
            "description": "<p>课种id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>分页加载页数（必传字段）第一次传1 第二次 2 第三次3 第四次4</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>请求类型</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestSign",
            "description": "<p>请求标志 （有值的话只有前两条数据  没有值的所有数据 有值的话前两条 ）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "versionNum",
            "description": "<p>版本号</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/get-all-private-class\n{\n     \"venueId\":1             //场馆id\n     \"requestType\":\"ios\"     //请求类型是ios\n     \"course\":10             //课种id(搜索时传)\n      \"page\":2               // 分页加载参数   表示第几页\n      \"type\":hhh             // 类型（忘了）\n      \"versionNum\":1.10.1    // 版本号\n     \"requestSign\":sign      // 请求标志       有值的话只有前两条数据  没有值表示按照先前加载分页\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>所有私课产品 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/30</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/get-all-private-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n  \"code\": 1,                                      //请求成功标识\n  \"status\": \"success\",                            //请求成功状态\n  \"message\": \"请求成功\",                          //请求成功信息\n  \"data\": [\n  {\n     \"id\": \"1\",                                   //产品id\n     \"name\": \"私课套餐\",                          //产品名称\n     \"type\": 1,                                   // 1 多课程 2 是单课程\n     \"pic\": \"http://oo0oj2qm.com/x1.png\",         //产品图片\n     \"classCount\": \"20\",                          //产品总量\n     \"totalPrice\": 150,                           //产品总价\n     \"charge\": \"减脂课程10节 /塑形课程10节 \",     //产品详细\n     \"score\": 4,                                  //产品星级\n     \"scoreImg\": {                                //产品星星\n     \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=\",\n     \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=\",\n     \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=\",\n     \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=\",\n     \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=\"\n  },\n  \"tag\": [                                       //产品特色\n         \"减脂\",\n         \"特色\"\n     ]\n  },\n  ]\n  }",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败状态\n  \"message\": \"场馆暂时没有排课\"                //失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v3/api-class/get-coach-info",
    "title": "教练详情",
    "version": "1.0.0",
    "name": "_________",
    "group": "chargeClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "coachId",
            "description": "<p>教练id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-class/get-coach-info  教练详情\n  {\n     \"coachId\"   :  \"1\"            //教练id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>教练详情 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-coach-info"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-coach-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": {\n     \"id\": \"446\",         //教练id\n     \"pic\": \"\",           //头像\n     \"name\": \"胡媛媛\",     //名字\n     \"age\": null,         //年龄\n     \"work_time\": null,   //从业时间\n     \"intro\": \"毕业于河南大学体育学院\\n 亚洲体适能专业私人教练认证\\n Adidas签约体适能教练认证\\n Adidas-training专项认证\\n BOSU国际专项认证\\n台湾皮拉提斯课程专项认证\\nA+健身学院产前产后私人教练证书\\n 海培妈咪孕产初级体能训导师认证\\n海培妈咪孕产中级体能训导师认证\"\n     }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                             //参数传入是否合法\n \"status\": \"error\",                     //错误状态\n \"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v3/api-class/get-coach-list",
    "title": "教练列表",
    "version": "1.0.0",
    "name": "_________",
    "group": "chargeClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "orderTime",
            "description": "<p>约课时间</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-class/get-coach-list  教练列表\n  {\n     \"venueId\"   :  \"1\"            //场馆id\n     \"orderTime\" :  \"1515491689\"   //约课时间\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号二次登陆 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-coach-list"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-coach-list"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": [\n     {\n     \"id\": \"446\",         //教练id\n     \"pic\": \"\",           //头像\n     \"name\": \"胡媛媛\",     //名字\n     \"age\": null,         //年龄\n     \"work_time\": null,   //从业时间\n     \"isAccess\": true     //是否可以预约：true 可以 ，false 不可以   （预约的时间段内教练有没有给其他人上课）\n     },\n     {\n     \"id\": \"605\",\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4709461514365481.blob?e=1514369081&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:WyBF_iqKJBv3UMi5twLZiwGnnas=\",\n     \"name\": \"唐成\",\n     \"age\": null,\n     \"work_time\": null,\n     \"isAccess\": true\n     },\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                             //参数传入是否合法\n \"status\": \"error\",                     //错误状态\n \"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v3/api-class/show-coach-list",
    "title": "展示教练列表",
    "version": "1.0.0",
    "name": "_____________",
    "group": "chargeClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-class/show-coach-list  教练列表\n  {\n     \"venueId\"   :  \"1\"            //场馆id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>展示教练列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/show-coach-list"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/show-coach-list"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": [\n     {\n     \"id\": \"446\",         //教练id\n     \"pic\": \"\",           //头像\n     \"name\": \"胡媛媛\",     //名字\n     \"age\": null,         //年龄\n     \"work_time\": null,   //从业时间\n     },\n     {\n     \"id\": \"605\",\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4709461514365481.blob?e=1514369081&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:WyBF_iqKJBv3UMi5twLZiwGnnas=\",\n     \"name\": \"唐成\",\n     \"age\": null,\n     \"work_time\": null,\n     },\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                             //参数传入是否合法\n \"status\": \"error\",                     //错误状态\n \"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v3/api-class/get-coach-lessons",
    "title": "展示课程列表",
    "version": "1.0.0",
    "name": "_____________",
    "group": "chargeClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-class/show-coach-list  教练列表\n  {\n     \"venueId\"   :  \"1\"            //场馆id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>展示课程列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-coach-lessons"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-coach-lessons"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": [\n   {\n     \"id\": \"126\",\n     \"name\": \"其味无穷多\",\n     \"valid_time\": \"0\",\n     \"total_amount\": null,\n     \"total_sale_num\": \"-1\",\n     \"sale_start_time\": \"1514649600\",\n     \"sale_end_time\": \"1556553600\",\n     \"created_at\": \"1516095208\",\n     \"status\": \"1\",\n     \"app_amount\": null,\n     \"show\": \"1\",\n     \"courseName\": \"减脂\"\n   },\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                             //参数传入是否合法\n \"status\": \"error\",                     //错误状态\n \"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v3/api-class/get-lessons-info",
    "title": "私教课程详情",
    "version": "1.0.0",
    "name": "_____________",
    "group": "chargeClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "chargeId",
            "description": "<p>私课id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-class/get-lessons-info   私教课程详情\n  {\n     \"chargeId\"   :  \"1\"              //私课id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>展示课程列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/22</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-lessons-info"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-lessons-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": {\n         \"id\": \"37\",\n         \"name\": \"0元WD增肌课程2A\",\n         \"valid_time\": \"365\",\n         \"total_amount\": \"0.00\",\n         \"total_sale_num\": \"999\",\n         \"sale_start_time\": \"1500952881\",\n         \"sale_end_time\": \"1532488881\",\n         \"created_at\": \"1500952881\",\n         \"status\": \"3\",\n         \"app_amount\": null,\n         \"show\": \"1\",\n         \"describe\": \"111111234567爱的刚刚胜多负少的沙发斯蒂芬\",\n         \"courseName\": \"艾博遗留课程\",\n         \"chargeClassPrice\": [\n              {\n                  \"id\": \"249\",\n                  \"charge_class_id\": \"37\",\n                  \"course_package_detail_id\": \"459\",\n                  \"intervalStart\": \"1\",\n                  \"intervalEnd\": \"11\",\n                  \"unitPrice\": \"350\",\n                  \"posPrice\": \"350\",\n                  \"create_time\": \"1516587819\"\n              }\n         ]\n      }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                             //参数传入是否合法\n \"status\": \"error\",                     //错误状态\n \"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "chargeClass"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-class-detail",
    "title": "会员预约课程详情",
    "version": "1.0.0",
    "name": "______",
    "group": "class",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "aboutId",
            "description": "<p>会员预约记录id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>课程类型(charge表示私课，group表示团课)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>登录端场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-class-detail\n{\n     \"aboutId\":107              //会员预约记录id\n     \"type\":\"charge\",          //私课\n     \"requestType\":\"ios\"       //请求类型：ios是区别其他app请求的标识\n     \"venueId\" : 22;           // 场馆id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员课程详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-class-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(团课 成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n\"data\": {\n        \"id\": \"5\",                   //团课课程id\n        \"coach_id\": \"3\",             //教练id\n       \"classroomName\": \"瑜伽教室\"           // 教室名称\n       \"seatNum\": 1                         // 座位号\n        \"course_id\": \"2\",            //课种id\n        \"classroom_id\": \"1\",         //教室id\n        \"start\": \"1496556000\",       //上课时间点\n        \"end\": \"1496560500\",         //下课时间点\n        \"class_date\": \"2017-06-13\",  //上课日期\n        \"difficulty\": \"2\",           //课程难度（1低，2中，3高）\n        \"pic\": \"\",                   //图片\n        \"aboutId\": \"32\",             //约课记录id\n        \"class_id\": \"5\",             //团课课程id\n        \"coachId\": \"3\",              //教练id\n        \"coachName\": \"舞蹈教练\",     //教练姓名\n        \"age\": null,                 //教练姓名\n        \"entry_date\": null,          //任职日期\n        \"classroomId\": \"1\",          //教室id\n        \"total_seat\": \"12\",          //总座位数\n        \"venue_id\": \"2\",             //场馆id\n        \"courseId\": \"2\",             //课种id\n        \"classLength\":\"60\"，         //时长\n        \"name\": \"单车2\",             //课种名称\n        \"course_desrc\": \"这是团课\",  //介绍\n        \"venueName\": null,           //场馆名称\n        \"venueAddress\": null,        //场馆地址\n        \"unusedFlag\": true,          //true表示未使用，false表示已使用（先不用）\n        \"courseFlag\": false,         //false表示团课       （先不用）\n         \"isClass\": 2                // 1 上课中 3 已使用 2待使用  (目前使用)\n        \"level\": \"中级\",             //课程级别\n        \"create_at\": \"2017-06-12 10:00\",     //预约时间\n        \"cancel_time\": null,                 //取消时间\n        \"score\": 4,                          //级别\n   \"scoreImg\": {\n       \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n   },\n   \"limit\": true       //true限制取消预约 ,false不限制取消预约\n  }",
          "type": "json"
        },
        {
          "title": "返回值详情(私课 成功时)",
          "content": "{\n    \"code\": 1,               //成功标识\n    \"status\": \"success\",     //成功标识\n    \"message\": \"请求成功\",   //成功提示信息\n    \"data\": {\n    \"id\": \"788\",                         //预约记录id\n    \"member_card_id\": \"12516\",           //会员卡id\n    \"classroomName\": \"瑜伽教室\"           // 教室名称\n     \"seatNum\": 1                         // 座位号\n    \"class_id\": \"94\",                    //订单详情id\n    \"status\": \"1\",                       //预约状态\n    \"create_at\": \"2017-06-22 16:00\",     //预约时间\n    \"coach_id\": \"135\",                   //教练id\n    \"unusedFlag\": true,                  //true表示未使用，false表示已使用\n    \"class_date\": \"2017-06-24\",          //上课日期\n    \"start\": \"1498233600\",               //上课时间点\n    \"end\": \"1498239600\",                 //下课时间点\n    \"cancel_time\": null,                 //预约取消时间\n    \"member_id\": \"18112\",                //会员id\n    \"orderId\": \"1386\",                   //订单id\n    \"type\": \"charge\",                    //课程类型\n    \"productName\": \"手机端\",             //产品名\n    \"courseName\": \"app测试\",             //课程名\n    \"coachName\": \"lala私教\",             //教练名\n     \"coachPic\":\"dddddd\"，               //教练头像\n    \"classLength\": \"100\",                //课时长\n    \"category\": \"2\",                     //课程类型：1多课程2单课程\n    \"courseNum\": \"10\",                   //课量\n    \"courseAmount\": \"10\",                //总数量\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?\",//图片\n    \"originalPrice\": \"12.00\",                        //单节原价\n    \"totalPrice\": \"100\",                             //总价\n    \"venueId\":234,                                   //场馆id    \n    \"venueName\": \"大上海瑜伽健身馆\",                 //场馆名称\n    \"venueAddress\": \"√东太康路大上海城C区6楼\",      //场馆地址\n    \"chargeNum\": 5,                                  //目前第几课\n    \"score\": 4,                                      //星级\n    \"scoreImg\": {\n         \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n         \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n         \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n         \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n         \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n    },\n\"packageClass\": [\n     {\n     \"coachName\": \"lala私教\",          //教练名\n     \"name\": \"app测试\",                //课程名\n     \"times\": 1,                       //第一节\n     \"course_length\": \"100\",           //课时长\n     \"sale_price\": \"12.00\",            //单节原价\n     \"is_member\": \"1\",                 //1表示是会员\n     \"status\": \"1\"                     //1表示课程上过了\n     },\n     {\n     \"coachName\": \"lala私教\",          //教练名\n     \"name\": \"app测试\",                //课程名\n     \"times\": 2,                       //第二节\n     \"course_length\": \"100\",           //课时长\n     \"sale_price\": \"12.00\",            //单节原价\n     \"is_member\": \"1\",                 //1表示是会员\n     \"status\": \"2\"                     //2表示课程没上过\n     },\n],\n  \"courseFlag\": true,\n  \"limit\": false\n  }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败状态\n  \"message\": \"没找到会员的预约信息\"      //失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "class"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-class-comment",
    "title": "会员预约课程结束信息",
    "version": "1.0.0",
    "name": "__________",
    "group": "class",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "aboutId",
            "description": "<p>会员预约记录id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>课程类型(charge表示私课，group表示团课)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-class-comment\n{\n     \"aboutId\":107              //会员预约记录id\n     \"type\":\"charge\",          //私课\n     \"requestType\":\"ios\"       //请求类型：ios是区别其他app请求的标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员课程结束信息 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-class-comment"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(团课成功时)",
          "content": "{\n \"code\": 1,                      //成功标识\n \"status\": \"success\",            //成功标识\n \"message\": \"请求成功\",          //成功提示信息\n \"data\": {\n \"coachName\": \"花花虎\",          //教练名称\n \"courseName\": \"团a\",            //课种名称\n \"classPic\": \"http://oo0oj2qmr.bkt.cl.com/201609_6316.jpg?Upr\",//团课图片\n \"score\": 4,                     //课程级别\n \"scoreImg\": {                   //课程星星\n     \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?\"\n  },\n     \"venueName\": \"大上海馆\",    //场馆名称\n     \"venueAddress\": \"\",         //场馆地址\n     \"endTime\": \"2017-07-01 20:00\",//课程下课时间\n     \"classType\": \"group\"        //课程类型：group表示团课\n }\n }",
          "type": "json"
        },
        {
          "title": "返回值详情(私课成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": {\n    \"coachName\": \"xiaoA\",            //教练名称\n    \"productName\": \"私课单节\",       //私课产品名称\n    \"chargeNum\": 1,                  //第几节课\n    \"courseName\": \"减脂\",            //课种名称\n    \"classLength\": \"100\",            //课时长\n    \"classPic\": \"http://oo0oj2qmr.bkt.clouddn.com/128432235.jpg?\",//私课产品图片\n    \"totalPrice\": \"90\",              //总价\n    \"classCount\": \"10\",              //总节数\n    \"score\": 4,                      //产品级别\n    \"scoreImg\": {                    //评论星星\n     \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?\",\n     \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?\"\n    },\n     \"venueName\": \"大上海馆\",        //场馆名称\n     \"venueAddress\": \"\",             //场馆地址\n     \"endTime\": \"2017-06-29 15:00\",  //课程结束时间\n     \"classType\": \"charge\"           //课程类型：charge表示私课\n   }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n    \"code\": 0,                       //失败标识\n    \"status\": \"error\",               //失败标识\n    \"message\": \"没找到预约课程相关信息\"  //失败提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "class"
  },
  {
    "type": "get",
    "url": "/v1/api-coach/get-coach",
    "title": "获取所有教练",
    "version": "1.0.0",
    "name": "______",
    "group": "coach",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "orderId",
            "description": "<p>订单id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-coach/get-coach\n{\n     \"requestType\":\"ios\"     //请求类型是ios\n     \"venueId\":11           // 场馆id\n      \"orderId\":12         // 不传值将会查询所有 教练   传值 查询 订单绑定的教练\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取教练详细详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-coach/get-coach"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\":1,               //成功标识\n \"status\": \"success\",    //请求状态\n \"message\": \"请求成功\"， //返回信息\n  \"data\": [\n  {\n     \"name\": \"lala私教\",               //教练名称\n     \"age\": null,                      //教练年龄\n     \"id\": 135,                        //教练约课\n     \"pic\": \"img/touxiang.png\",        //教练头像\n     \"workTime\": 5,                    //教练工作年限\n     \"score\": 4,                       //评分\n     \"scoreImg\": {                     //图片\n        \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n        \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n        \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n        \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n        \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n    }\n  },\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"code\": 0,                   //失败表示\n    \"status\": \"error\",           //请求状态\n    \"message\": \"未查到教练信息\"  //失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiCoachController.php",
    "groupTitle": "coach"
  },
  {
    "type": "get",
    "url": "/v1/api-coach/get-coach-detail",
    "title": "获取教练详细详情",
    "version": "1.0.0",
    "name": "________",
    "group": "coach",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>教练id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-coach/get-coach-detail\n{\n     \"id\":107，              //教练id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取教练详细详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-coach/get-coach-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\":1,               //成功标识\n \"status\": \"success\",    //请求状态\n \"message\": \"请求成功\"， //返回信息\n \"data\": {\n     \"id\": \"135\",                //教练id\n     \"name\": \"lala私教\",         //教练姓名\n     \"age\": null,                //教练年龄\n     \"sex\": null,                //教练性别\n     \"position\": \"\",             //教练职务\n     \"status\": \"1\",              //教练状态：1在职 2离职\n     \"created_at\": \"1494817574\", //创建时间(教练信息添加时间)\n     \"intro\": \"为健身爱好者提供一对一具体指导的健身指导者。\",//个人简介\n     \"level\": null,              //等级:0新员工1低级2中级3高级\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?e=1498014950&to=\",//头像\n     \"class_hour\": \"0\",          //课时\n     \"is_check\": \"0\",            //是否需要审核:1需要,0不需要\n     \"is_pass\": null,            //是否通过审核:1通过,0未通过\n     \"alias\": \"是否\",            //教练的别名\n     \"work_time\": null,          //从业时间\n     \"company_id\": \"42\",         //公司id\n     \"venue_id\": \"43\",           //场馆id\n     \"workTime\": null,           //从业时间\n     \"score\": 4,                 //星级\n     \"scoreImg\": {\n             \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n             \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n             \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n             \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n             \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n         },\n     \"coachPic\": \"http://oo0oj2qmr.bkt.cloudsW3S:vY0iRs1U=\"  //教练头像（为空时，这个字段有默认值）\n    }\n  }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"code\": 0,                   //失败表示\n    \"status\": \"error\",           //请求状态\n    \"message\": \"未查到教练信息\"  //失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiCoachController.php",
    "groupTitle": "coach"
  },
  {
    "type": "post",
    "url": "/v1/api-member/create-code",
    "title": "获取验证码",
    "version": "1.0.0",
    "name": "_____",
    "group": "code",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/create-code\n{\n     \"mobile\":15011122233   //手机号\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户登录 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/create-code"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回验证码或者失败信息</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"data\": 404316          //验证码\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n  \"code\": 0,             //失败标识\n  \"status\": \"error\",     //失败标识\n  \"data\": [\n  \"发送失败\"             //失败信息\n  ]\n }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "code"
  },
  {
    "type": "get",
    "url": "/v1/api-venue/gain-com-about-data",
    "title": "公司,场馆",
    "version": "1.0.0",
    "name": "_____",
    "group": "company",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "isNOtMB",
            "description": "<p>是否是迈步公司</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET  /v1/api-venue/get-complain-message\n{\n     \"isNOtMB \":\"maibu\",                   // 迈步标志\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "管理员"
      },
      {
        "name": "管理员"
      }
    ],
    "description": "<p>获取对应公司的所有部门（是迈步公司的传标志,不是的不传） <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/8/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-venue/gain-com-about-data"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                   //成功表示\n\"status\": \"success\",         //成功状态\n\"message\": \"请求成功\",       //成功信息\n\"data\": []                  //返回的数据信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败标识\n  \"message\": \"没有找到场馆信息\"         //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiVenueController.php",
    "groupTitle": "company"
  },
  {
    "type": "get",
    "url": "/v1/api-venue/get-all-company",
    "title": "获取所有公司",
    "version": "1.0.0",
    "name": "______",
    "group": "company",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-venue/get-all-company",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取所有公司 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/3</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-venue/get-all-company"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                   //成功标识\n\"status\": \"success\",         //成功状态\n\"message\": \"请求成功\",       //成功信息\n\"data\": [\n{\n     \"id\": \"1\",              //公司id\n     \"name\": \"我爱运动\"      //公司名称\n},\n{\n     \"id\": \"8\",              //公司id\n     \"name\": \"多少度\"        //公司名称\n}\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败标识\n  \"message\": \"获取公司信息失败\"      //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiVenueController.php",
    "groupTitle": "company"
  },
  {
    "type": "get",
    "url": "/v1/api-venue/get-dep-message",
    "title": "获取指定场馆的部门",
    "version": "1.0.0",
    "name": "_________",
    "group": "company",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>部门id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET  /v1/api-venue/get-complain-message\n{\n     \"venueId\":2,                   // 部门id\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "description": "<p>获取指定场馆的部门 <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/8/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-venue/get-dep-message"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                   //成功表示\n\"status\": \"success\",         //成功状态\n\"message\": \"请求成功\",       //成功信息\n\"data\": []                  //返回的数据信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败标识\n  \"message\": \"没有找到场馆信息\"         //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiVenueController.php",
    "groupTitle": "company"
  },
  {
    "type": "get",
    "url": "/v1/api-venue/get-complain-message",
    "title": "指定场馆部门信息",
    "version": "1.0.0",
    "name": "___________",
    "group": "company",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>部门id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET  /v1/api-venue/get-complain-message\n{\n     \"companyId\":1,                 //公司id\n     \"venueId\":2,                   // 部门id\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "description": "<p>获取指定公司下的场馆信息和 所属场馆部门信息 <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/8/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-venue/get-complain-message"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                   //成功表示\n\"status\": \"success\",         //成功状态\n\"message\": \"请求成功\",       //成功信息\n\"data\":\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败标识\n  \"message\": \"没有找到场馆信息\"         //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiVenueController.php",
    "groupTitle": "company"
  },
  {
    "type": "get",
    "url": "/v1/api-venue/get-all-venue",
    "title": "获取选中的公司下面的场馆",
    "version": "1.0.0",
    "name": "____________",
    "group": "company",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>公司来源区分</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "maId",
            "description": "<p>公司账号Id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-venue/get-all-venue\n{\n     \"companyId\":1,                 //公司id\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "description": "<p>获取选中的公司下面的场馆 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/4</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-venue/get-all-venue"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n\"code\": 1,                   //成功表示\n\"status\": \"success\",         //成功状态\n\"message\": \"请求成功\",       //成功信息\n\"data\": [\n     {\n     \"id\": \"13\",              //场馆id\n     \"name\": \"迈步场馆\"       //场馆名称\n     },\n     {\n     \"id\": \"14\",              //场馆id\n     \"name\": \"瀑布场馆\"      //场馆名称\n     }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败标识\n  \"message\": \"没有找到场馆信息\"         //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiVenueController.php",
    "groupTitle": "company"
  },
  {
    "type": "post",
    "url": "/v1/api-about-record/member-complaint",
    "title": "会员投诉提交接口",
    "version": "1.0.0",
    "name": "________",
    "group": "complaint",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "departmentId",
            "description": "<p>部门id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "complaintType",
            "description": "<p>举报类别</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "complaintContent",
            "description": "<p>举报内容</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST  /v1/api-about-record/cancel-about\n  {\n       \"venueId\":2，              // 场馆id\n       \"departmentId\"，           // 部门id\n       \"complaintType\",           // 投诉类型\n       \"complaintContent\",        // 投诉内容\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员投诉提交接口 <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/8/22</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-about-record/member-complaint"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\":1,               //成功标识\n \"status\": \"success\",    //成功状态\n \"message\": \"成功信息\",  //成功信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n \"code\":0,               //失败标识\n \"status\": \"error\",    //成功状态\n \"message\": \"失败信息\", //失败信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiAboutRecordController.php",
    "groupTitle": "complaint"
  },
  {
    "type": "get",
    "url": "/v1/api-class/get",
    "title": "团课所有课程",
    "version": "1.0.0",
    "name": "______",
    "group": "groupClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>课程id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "date",
            "description": "<p>课程日期</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "course",
            "description": "<p>课程id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueName",
            "description": "<p>场馆名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "version",
            "description": "<p>请求版本app 请求类型不同  遍历数据不同</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-class/get\n{\n     \"venueId\": 1,\n     \"date\":\"2017-03-06,\n     \"course\": 3,\n     \"requestType\":\"ios\",          //ios请求标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>不发送日期：默认搜索 近5天的课程数据 不发送课程id  不限制搜索指定的课程 <br/> <span><strong>作   者：</strong></span>黄鹏举<br> <span><strong>邮   箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/30</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-class/get"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回课程数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(ios专属)",
          "content": "{\n\"code\": 1,                            //请求成功表示\n\"status\": \"success\",                  //请求成功状态0\n\"message\": \"请求成功\",                //请求成功信息\n\"data\": [\n{\n   \"class_date\": \"2017-06-30\",        // 课程上课日期\n   \"info\": \"今天\",                    // 上课日期别名\n   \"list\": [\n   {\n    \"id\": \"8\",                        // 团课课程id\n    \"start\": \"15:00\",                 //上课开始时间\n    \"end\": \"16:58\",                   //上课结束时间\n    \"class_date\": \"2017-06-30\",       //上课日期\n    \"difficulty\": \"1\",                //课程难度（1=>'初级',2=>'中级',3=>'高级'）\n    \"level\": \"初级\"                   // 课程难度（已经处理过）\n    \"isTimeEndClass\": true,           // 课程是否已经结束(true表示还未上课的课程（可以点击查看，预约），false表示课程已经上课)\n    \"courseName\": \"团b\",               //课种名称(代码优化后的课种名称)\n    \"coach\": \"玫瑰\",\n    \"coachPic\": \"http://oo0oj2qmr.bkt.clouddn.com/头像-拷贝@2x.png?eck3jtHKFXo=\",  //教练头像\n    \"scoreImg\": {\n         \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=14EysW3S:-3U-1EZN17xhI=\",\n         \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=149OqC6lg63U-1EZN17xhI=\",\n         \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1mwMiysW3U-1EZN17xhI=\",\n         \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/xwUM2iX2wn_2F6lg63U-1EZN17xhI=\",\n         \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=_2Dj3vNdMcJ-DXSkxBnp4=\"\n      },\n   }\n   ]\n   }\n]\n}\n\n{\n  \"code\": 0,                     //失败标识\n  \"status\": \"error\",           //失败状态\n  \"message\": \"场馆暂时没有排课\"  //失败原因\n}",
          "type": "json"
        },
        {
          "title": "返回值详情",
          "content": "data{\n{\n\"class_date\": \"2017-06-16\",      // 课程上课日期\n\"info\": \"今天\",                  // 上课日期别名\n\"list\": [\n{\n\"id\": \"17\",                      // 团课课程id\n\"start\": \"02:08\",                // 上课开始时间\n\"end\": \"05:25\",                  // 上课结束时间\n\"class_date\": \"2017-06-16\",      // 上课日期\n\"difficulty\": \"1\",               // 课程难度（1=>'初级',2=>'中级',3=>'高级'）\n\"level\": \"初级\",                 // 课程难度（已经处理过）\n\"isTimeEndClass\": false,         // 课程是否已经结束(true表示还未上课的课程（可以预约），false表示课程已经上课)\n\"courseName\": \"团b\",             //课种名称（优化后处理的字段）\n\"name\": {                        //优化后删除了(这个字段已删除，优化后课种名称是courseName)\n     \"name\": \"测试舞蹈\",              //  课种名称\n     \"category\": \"舞蹈\",              //  课程分类\n     \"courseDesrc\": \"存储\"            //  课程介绍\n},\n\"coach\": \"单车教练\",             //课程教练\n\"coachPic\": \"img/touxiang.png\",  // 教练头像\n\"scoreImg\": {                    //  课程*星星* 级别\n     \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n     \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n     \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n     \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n     \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n }\n}\n]\n}}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiClassController.php",
    "groupTitle": "groupClass"
  },
  {
    "type": "get",
    "url": "/v1/api-class/get-course-data",
    "title": "获取所有课种",
    "version": "1.0.0",
    "name": "__________",
    "group": "groupClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>1 代表私课 2代表团课</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-class/get-course-data\n{\n     \"type\": 2,             // 课程类别   1 代表私课 2代表团课\n     \"requestType\":\"ios\",   //ios请求标识\n     \"venueId\": 2,          // 场馆id   \n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取所有团课课程数据 <br/> <span><strong>作   者：</strong></span>侯凯新<br> <span><strong>邮   箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-class/get-course-data"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "{",
          "content": "{\n[\n{\n\"id\": \"1\",        //课程id\n\"name\": \"舞蹈\"    //课程名称\n\"pic\":\"\"          //课种图片\n},\n{\n\"id\": \"2\",        //课程id\n\"name\": \"单车2\"   //课程名称\n\"pic\":\"\"          //课种图片\n},\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiClassController.php",
    "groupTitle": "groupClass"
  },
  {
    "type": "get",
    "url": "/v1/api-class/get-seat-detail",
    "title": "获取指定课程的座位详情",
    "version": "1.0.0",
    "name": "___________",
    "group": "groupClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>团课课程id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberCardId",
            "description": "<p>会员卡id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-class/get-seat-detail\n{\n     \"id\":12,                      // 团课课程id\n     \"memberId\": 3,                // 会员id\n     \"requestType\":\"ios\",          //ios请求标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取指定课程的座位详情 <br/> <span><strong>作   者：</strong></span>侯凯新<br> <span><strong>邮   箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-class/get-seat-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情",
          "content": "\"id\": \"18\",         //团课排课id\n\"start\": \"11:50\",   //上课开始时间\n\"end\": \"17:30\",     //上课结束时间\n\"class_date\": \"2017-06-16\",   //上课日期\n\"created_at\": \"1497489158\",   //课程创建时间\n\"status\": \"1\",           // 课程状态 1正常2调课3旷课4请假\n\"course_id\": \"3\",        //课程id\n\"coach_id\": \"2\",          //教练id\n\"classroom_id\": \"1\",      //教室id\n\"create_id\": \"2\",         //创建人id\n\"difficulty\": \"1\",        // 课程难度（1 中 2 底 3 高）\n\"desc\": null,              //课程介绍\n\"pic\": null,              //课程图片\n\"class_limit_time\": null, //开课前多少分钟不能约课\n\"cancel_limit_time\": null,// 开课前多少分钟不能取消约课\n\"least_people\": null,    //最少开课人数\n\"company_id\": null,     // 公司id\n\"venue_id\": \"2\",        //场馆id\n\"classroomName\": \"瑜伽室\", //教室名称\n\"venue\": \"大上海\",       //场馆名称\n\"venueAddress\": \"12\",    //场馆地址\n\"isAboutClass\": false,  // 是否约过此课程\n\"isCanClass\": false,     //是否买过此课程\n\"name\": \"测试舞蹈\",     //课程名称\n\"coach\": \"单车教练\",    //教练名称\n\"coachPic\": \"img/touxiang.png\", //教练头像\n\"classroom\": \"12\",      //教室最大容纳人数\n \"isCanOrder\":true,     // 是否能够跨店预约\n\"seatDetail\": [        //教室详情\n{\n\"id\": \"1\",            // 座位id\n\"classroom_id\": \"1\",  //教室id\n\"seat_type\": \"2\",    // 座位级别 1普通，2VIP，3贵族\n\"seat_number\": \"1\",   // 座位编号\n\"is_anyone\": 0       // 是否有人占用此位置 0 表示无人 1表示有人\n \"authority\":true    //  true表示有权限预约 false无权限预约\n},\n{\n\"id\": \"11\",\n\"classroom_id\": \"1\",\n\"seat_type\": \"1\",\n\"seat_number\": \"11\",\n\"is_anyone\": 0\n \"authority\":true    //  true表示有权限预约 false无权限预约\n},\n{\n\"id\": \"12\",\n\"classroom_id\": \"1\",\n\"seat_type\": \"1\",\n\"seat_number\": \"12\",\n\"is_anyone\": 0\n \"authority\":true    //  true表示有权限预约 false无权限预约\n }\n],\n\"score\": 4,    // 教练分数\n\"scoreImg\": {  //教练 头像\n\"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiClassController.php",
    "groupTitle": "groupClass"
  },
  {
    "type": "get",
    "url": "/v1/api-class/get-detail",
    "title": "获取单条团课课程详情数据",
    "version": "1.0.0",
    "name": "____________",
    "group": "groupClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>团课课程id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-class/get-detail\n{\n     \"id\":12,                      // 团课课程id\n     \"memberId\": 3,                // 会员id\n     \"requestType\":\"ios\",          //ios请求标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取单条团课课程详情数据 <br/> <span><strong>作   者：</strong></span>侯凯新<br> <span><strong>邮   箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-class/get-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情",
          "content": "{\n\"id\": \"18\",          // 团课课程id\n\"start\": \"11:50\",   // 上课开始时间\n\"end\": \"17:30\",     // 上课结束时间\n\"class_date\": \"2017-06-16\",  // 上课日期\n\"created_at\": \"1497489158\",  // 课程创建时间\n\"status\": \"1\",      // 课程状态 1正常2调课3旷课4请假\n\"course_id\": \"3\",  // 课程id\n\"coach_id\": \"2\",    // 教练id\n\"classroom_id\": \"1\", // 教室id\n\"create_id\": \"2\",    // 创建人id（员工id）\n\"difficulty\": \"1\",    // 课程难度（1 中 2 底 3 高）\n\"desc\": null,         // 团课课程介绍\n\"pic\": null,          //团课课程图片\n\"class_limit_time\": null,  //开课前多少分钟不能约课\n\"cancel_limit_time\": null,  // 开课前多少分钟不能取消约课\n\"least_people\": null,      //最少开课人数\n\"company_id\": null,      //公司id\n\"venue_id\": \"2\",          //场馆id\n\"limitTime\": true,        // true可以预约 ,false表示快上课了\n\"isAboutClass\": false,    //会员没有约课记录（true表示在这个课程的上课时间段会员已经预约过其他课程了，false表示没有预约过其他课程）\n\"isCanClass\": false,       // 是否有绑定这节课程(true有，可以预约，false没有，不可以预约)\n\"name\": \"测试舞蹈\",        //课程名称\n\"courseDesrc\": \"存储\",     //课程介绍\n\"isDance\": false,          // 是否是舞蹈课\n\"classScore\": 4,           // 课程分数\n\"classScoreImg\": {        // 课程  星星级别\n\"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n    },\n\"coach\": \"单车教练\",     // 教练\n\"coachAge\": null,        //教练年龄\n\"coachPic\": \"img/touxiang.png\", //教练头像\n\"workTime\": null,         // 工作时间\n\"venue\": \"大上海\",        // 工作场馆\n\"classroom\": \"12\",        //教室最大容纳人数\n\"classroomName\": \"瑜伽室\", //教室名称\n\"score\": 4,               // 教练分数\n\"scoreImg\": {             //教练星星\n\"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n\"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n},                       //\n    \"address\": \"12\"           // 场馆地址\n    }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiClassController.php",
    "groupTitle": "groupClass"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-member-info",
    "title": "详细信息",
    "version": "1.0.0",
    "name": "____",
    "group": "memberCardData",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberCardId",
            "description": "<p>会员卡id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-member-info\n{\n   \"memberCardId\":3,                                   //会员卡id\n   \"memberId\" :100                                     //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>详细信息 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n  \"data\": {\n     \"cardNumber\": \"041497854875\",       //会员卡号\n     \"createAt\": \"2017-06-19\",           //开卡时间\n     \"amountMoney\": \"6666\",              //总金额\n     \"status\": \"1\",                      //卡状态：1正常，2异常，3冻结，4未激活\n     \"activeTime\": \"2017-06-19\",         //激活时间\n     \"invalidTime\": \"2017-09-27\",        //失效时间\n     \"balance\": 0,                       //余额\n     \"cardName\": \"时间卡\",               //卡名\n     \"duration\": \"100\",                  //有效期（单位：天）\n     \"memberId\": \"3\",                    //会员id\n     \"lastTime\": 92                      //剩余天数\n  }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //成功提示信息\n \"data\":\"该会员没有会员卡\"   //具体报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberCardData"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-member-card-all",
    "title": "会员卡列表",
    "version": "1.0.0",
    "name": "_____",
    "group": "memberCardData",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-member-card-all\n{\n   \"memberId\" :'100'                                   //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员卡列表 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-card-all"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": [\n  {\n     \"memberCardId\": \"3\",                //会员卡id\n     \"cardNumber\": \"041497854875\",       //会员卡号\n     \"cardName\": \"时间卡\"                //会员卡名称\n     \"cardStatus\":1                      //  1正常 2异常 3冻结 4未激活\n     \"leaveRecordStatus\":0               // 0表示不在请假中 1表示在请假中\n  },\n  {\n     \"memberCardId\": \"9\",                //会员卡id\n     \"cardNumber\": \"051497940599\",       //会员卡号\n     \"cardName\": \"时间卡\"                //会员卡名称\n     \"cardStatus\":1                      //  1正常 2异常 3冻结 4未激活\n     \"leaveRecordStatus\":0               // 0表示不在请假中 1表示在请假中\n  }\n]\n \"cardStatus\":3                         // 1：有正常的会员卡 2：没有会员卡 3 卡有异常\n \"cardMessage\": \"您的卡有异常或未激活\"  // 会员办卡信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //成功提示信息\n \"data\":\"该会员没有会员卡\"   //具体报错信息\n \"cardStatus\":2                          // 1：有正常的会员卡 2：没有会员卡 3 卡有异常\n \"cardMessage\": \"您还没有办理会员卡\"      // 会员办卡信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberCardData"
  },
  {
    "type": "get",
    "url": "/v3/api-member/wechat-card-list",
    "title": "微信公众号会员卡列表",
    "version": "1.0.0",
    "name": "__________",
    "group": "memberCardData",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/wechat-card-list\n{\n   \"memberId\" :'100'   //会员id\n   \"venueId\"  : 2      //场馆id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号会员卡列表 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/wechat-card-list"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": [\n  {\n     \"memberCardId\": \"3\",                //会员卡id\n     \"cardNumber\": \"041497854875\",       //会员卡号\n     \"cardName\": \"时间卡\"                //会员卡名称\n     \"cardStatus\":1                      //  1正常 2异常 3冻结 4未激活\n     \"leaveRecordStatus\":0               // 0表示不在请假中 1表示在请假中\n  },\n  {\n     \"memberCardId\": \"9\",                //会员卡id\n     \"cardNumber\": \"051497940599\",       //会员卡号\n     \"cardName\": \"时间卡\"                //会员卡名称\n     \"cardStatus\":1                      //  1正常 2异常 3冻结 4未激活\n     \"leaveRecordStatus\":0               // 0表示不在请假中 1表示在请假中\n  }\n]\n \"cardStatus\":3                         // 1：有正常的会员卡 2：没有会员卡 3 卡有异常\n \"cardMessage\": \"您的卡有异常或未激活\"  // 会员办卡信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //成功提示信息\n \"data\":\"该会员没有会员卡\"   //具体报错信息\n \"cardStatus\":2                          // 1：有正常的会员卡 2：没有会员卡 3 卡有异常\n \"cardMessage\": \"您还没有办理会员卡\"      // 会员办卡信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "memberCardData"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-member-class",
    "title": "会员最近课程",
    "version": "1.0.0",
    "name": "______",
    "group": "memberClass1",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>分页请求 （第一次请求 传“” 第二次 1 第三次 2）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-member-class\n{\n     \"memberId\":107            //会员id\n     \"requestType\":\"ios\"      //请求类型：ios是区别其他app请求的标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员最近课程 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\" : \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n  \"endPage\":2            // 1 不是最后一页 2 最后一页\n   \"data\": [\n {\n     \"id\": \"17\",                     //团课课程id\n     \"start\": \"19:00\",               //上课时间\n     \"end\": \"1498910400\",            //下课时间\n     \"class_date\": \"2017-07-01\",     //上课日期\n     \"created_at\": \"1498897366\",     //创建时间\n     \"status\": \"1\",                  //团课状态 1正常2调课3旷课4请假\n     \"course_id\": \"12\",              //课种id\n     \"coach_id\": \"3\",                //教练id\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/20160803094909_6316.jpg?\",//课程图片\n     \"name\": \"团a\",                  //课种名称\n     \"aboutId\": \"18\",                //预约记录id\n     \"coachName\": \"花花虎\",         //教练姓名\n     \"classType\": \"group\",          //课程类型（group表示团课，charge表示私课）\n     \"type\": 2,                     //   2表示团课类型，1表示私课类型\n     \"courseFlag\": false,           //false表示团课，true表示私课\n     \"cancelFlag\": true             //true表示课程已取消，false表示未取消\n },\n{\n    \"id\": \"5\",                       //订单详情id\n    \"course_order_id\": \"5\",          //订单id\n    \"course_id\": \"11\",               //课种id\n    \"course_num\": null,              //课量\n    \"course_length\": \"1000\",         //有效期\n    \"original_price\": \"15.00\",       //单节原价\n    \"sale_price\": null,              //单节售价\n    \"pos_price\": null,               //单节pos售价\n    \"type\": \"1\",                     //订单类型：1私课2团课\n    \"category\": \"2\",                 //课程类型：1多课程2单课程\n    \"product_name\": \"month单节\",     //产品名称\n    \"course_name\": \"month\",          //课种名称\n    \"class_length\": \"100\",           //课种时长\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?=\", //图片\n    \"desc\": \"\",                      //描述\n    \"aboutId\": \"41\",                 //约课记录id\n    \"memberCardId\": \"34\",            //会员卡id\n    \"classId\": \"5\",                  //订单详情id\n    \"status\": \"3\",                   //订单状态 1.约课中，2取消，3上课中，4课程结束，5课程过期\n    \"classType\": \"charge\",           //课程类型：charge是私课，group是团课\n    \"create_at\": \"1498116444\",       //订单创建时间\n    \"seatId\": null,                  //座位id\n    \"coach_id\": \"5\",                 //教练id\n    \"class_date\": \"2017-06-22\",      //订单日期\n    \"start\": \"15:27\",                //开始时间\n    \"end\": \"1498116999\",             //结束时间\n    \"cancel_time\": null,             //取消时间\n    \"memberId\": \"107\",               //会员id\n    \"classStatus\": true,             //上课中,true表示上课中，false，表示下课\n    \"coachName\": \"小A\",              // 教练名称\n    \"chargeNum\": 0,                  //第几节课\n    \"courseFlag\": true,              //true表示是私课，false表示团课\n    \"unusedFlag\": false              //true表示待使用，false,表示已使用\n   }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                       //失败标识\n  \"status\": \"error\",               //失败标识\n  \"message\": \"该会员最近没有课程\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberClass1"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-whole-member-class",
    "title": "会员全部课程",
    "version": "1.0.0",
    "name": "______",
    "group": "memberClass2",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>空（表示第一页）  1（表示第二页） 2（表示第三页）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": " GET /v1/api-member/get-whole-member-class\n\"memberId\":107            //会员id\n\"requestType\":\"ios\"      //请求类型：ios是区别其他app请求的标识",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员全部课程 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-whole-member-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"endPage\":1             // 1 不是末页 2表示末页\n   \"data\": [\n {\n     \"id\": \"17\",                     //团课课程id\n     \"start\": \"19:00\",               //上课时间\n     \"end\": \"1498910400\",            //下课时间\n     \"class_date\": \"2017-07-01\",     //上课日期\n     \"created_at\": \"1498897366\",     //创建时间\n     \"status\": \"1\",                  //团课状态 1正常2调课3旷课4请假\n     \"course_id\": \"12\",              //课种id\n     \"coach_id\": \"3\",                //教练id\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/20160803094909_6316.jpg?\",//课程图片\n     \"name\": \"团a\",                  //课种名称\n     \"aboutId\": \"18\",                //预约记录id\n     \"coachName\": \"花花虎\",         //教练姓名\n     \"classType\": \"group\",          //课程类型（group表示团课，charge表示私课）\n     \"type\": 2,                     //   2表示团课类型，1表示私课类型\n     \"courseFlag\": false,           //false表示团课，true表示私课\n     \"cancelFlag\": true             //true表示课程已取消，false表示未取消\n },\n{\n    \"id\": \"5\",                       //订单详情id\n    \"course_order_id\": \"5\",          //订单id\n    \"course_id\": \"11\",               //课种id\n    \"course_num\": null,              //课量\n    \"course_length\": \"1000\",         //有效期\n    \"original_price\": \"15.00\",       //单节原价\n    \"sale_price\": null,              //单节售价\n    \"pos_price\": null,               //单节pos售价\n    \"type\": \"1\",                     //订单类型：1私课2团课\n    \"category\": \"2\",                 //课程类型：1多课程2单课程\n    \"product_name\": \"month单节\",     //产品名称\n    \"course_name\": \"month\",          //课种名称\n    \"class_length\": \"100\",           //课种时长\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?=\", //图片\n    \"desc\": \"\",                      //描述\n    \"aboutId\": \"41\",                 //约课记录id\n    \"memberCardId\": \"34\",            //会员卡id\n    \"classId\": \"5\",                  //订单详情id\n    \"status\": \"3\",                   //订单状态 1.约课中，2取消，3上课中，4课程结束，5课程过期\n    \"classType\": \"charge\",           //课程类型：charge是私课，group是团课\n    \"create_at\": \"1498116444\",       //订单创建时间\n    \"seatId\": null,                  //座位id\n    \"coach_id\": \"5\",                 //教练id\n    \"class_date\": \"2017-06-22\",      //订单日期\n    \"start\": \"15:27\",                //开始时间\n    \"end\": \"1498116999\",             //结束时间\n    \"cancel_time\": null,             //取消时间\n    \"memberId\": \"107\",               //会员id\n    \"classStatus\": true,             //上课中,true表示上课中，false，表示下课\n    \"coachName\": \"小A\",              // 教练名称\n    \"chargeNum\": 0,                  //第几节课\n    \"courseFlag\": true,              //true表示是私课，false表示团课\n    \"unusedFlag\": false              //true表示待使用，false,表示已使用\n   }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                       //失败标识\n  \"status\": \"error\",               //失败标识\n  \"message\": \"该会员最近没有课程\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberClass2"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-class-not-class",
    "title": "会员未使用课程",
    "version": "1.0.0",
    "name": "_______",
    "group": "memberClass3",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>分页参数   空（表示第一页） 1（表示第二页） 2（表示第三页）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-class-not-class\n{\n     \"memberId\":107            //会员id\n     \"requestType\":\"ios\"      //请求类型：ios是区别其他app请求的标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员全部课程 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-class-not-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"endPage\": 1            // 1 不是末页 2是末页\n \"data\":[\n{\n  \"id\": \"357\",                   //团课课程id\n  \"start\": \"12:00\",              //开始时间\n  \"end\": \"1498194000\",           //结束时间（时间戳）\n  \"class_date\": \"2017-06-23\",    //上课日期\n  \"created_at\": \"1498042669\",    //约课时间\n  \"status\": \"1\",                 //团课状态 1正常2调课3旷课4请假\n  \"course_id\": \"48\",             //课种id\n  \"coach_id\": \"138\",             //教练id\n  \"pic\": null,                   //图片\n  \"name\": \"瑜伽理疗\",            //课种名称\n  \"aboutId\": \"789\",              //预约记录id\n  \"aboutStatus\": \"1\",            //预约记录的状态 1正常，2取消，3上课，4下课，5过期\n  \"coachName\": \"测试人员\",       //教练姓名\n  \"classType\": \"group\",          //课程类型（group:团课，charge:私课）\n  \"type\": 2,                     //预约类型1私课2团课\n  \"courseFlag\": false,           //false表示 是团课，true表示是私课\n  \"unusedFlag\": true             //true表示未使用，false表示已使用\n  },\n  {\n  \"id\": \"94\",                    //私课订单详情id\n  \"course_order_id\": \"1386\",     //订单id\n  \"course_id\": \"43\",             //课种id\n  \"course_num\": \"10\",            //课量\n  \"course_length\": \"1000\",       //有效期/天\n  \"original_price\": \"12.00\",     //单价原价\n  \"sale_price\": null,            //单节售价\n  \"pos_price\": null,             //单击pos价\n  \"type\": \"1\",                   //订单类型：1私课2团课\n  \"category\": \"2\",               //课程类型：1多课程2单课程\n  \"product_name\": \"手机端\",      //产品名称\n  \"course_name\": \"app测试\",      //产品名称\n  \"class_length\": \"100\",         //时长\n  \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?\",图片\n  \"desc\": \"买课减费，多买东送，手机app测试\",  //介绍\n  \"aboutId\": \"788\",              //预约记录id\n  \"memberCardId\": \"12516\",       //会员卡id\n  \"classId\": \"94\",                //订单详情id\n  \"status\": \"1\",                  //预约状态状态\n  \"classType\": \"charge\",          //预约类型 。charge表示私课\n  \"create_at\": \"1498118418\",      //预约时间\n  \"seatId\": null,                 //座位id\n  \"coach_id\": \"135\",              //教练id\n  \"class_date\": \"2017-06-24\",     //上课日期\n  \"start\": \"00:00\",               //上课时间\n  \"end\": \"1498239600\",            //下课时间（时间戳）\n  \"cancel_time\": null,            //取消时间\n  \"memberId\": \"18112\",            //会员id\n  \"coachName\": \"lala私教\",        //教练姓名\n  \"chargeNum\": 5,                 //第几节课\n  \"courseFlag\": true,             //true表示是私课\n  \"unusedFlag\": true              //true表示未使用\n  },\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                       //失败标识\n  \"status\": \"error\",               //失败标识\n  \"message\": \"该会员最近没有课程\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberClass3"
  },
  {
    "type": "get",
    "url": "/v1/api-member/get-class-cancel-class",
    "title": "会员已取消课程",
    "version": "1.0.0",
    "name": "_______",
    "group": "memberClass4",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>请求分页</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/get-class-cancel-class\n{\n     \"memberId\":107            //会员id\n     \"requestType\":\"ios\"      //请求类型：ios是区别其他app请求的标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员已取消课程 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-class-cancel-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"endPage\": 1            // 1不是末页  2是末页\n   \"data\": [\n {\n     \"id\": \"17\",                     //团课课程id\n     \"start\": \"19:00\",               //上课时间\n     \"end\": \"1498910400\",            //下课时间\n     \"class_date\": \"2017-07-01\",     //上课日期\n     \"created_at\": \"1498897366\",     //创建时间\n     \"status\": \"1\",                  //团课状态 1正常2调课3旷课4请假\n     \"course_id\": \"12\",              //课种id\n     \"coach_id\": \"3\",                //教练id\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/20160803094909_6316.jpg?\",//课程图片\n     \"name\": \"团a\",                  //课种名称\n     \"aboutId\": \"18\",                //预约记录id\n     \"coachName\": \"花花虎\",         //教练姓名\n     \"classType\": \"group\",          //课程类型（group表示团课，charge表示私课）\n     \"type\": 2,                     //   2表示团课类型，1表示私课类型\n     \"courseFlag\": false,           //false表示团课，true表示私课\n     \"cancelFlag\": true             //true表示课程已取消，false表示未取消\n },\n{\n    \"id\": \"5\",                       //订单详情id\n    \"course_order_id\": \"5\",          //订单id\n    \"course_id\": \"11\",               //课种id\n    \"course_num\": null,              //课量\n    \"course_length\": \"1000\",         //有效期\n    \"original_price\": \"15.00\",       //单节原价\n    \"sale_price\": null,              //单节售价\n    \"pos_price\": null,               //单节pos售价\n    \"type\": \"1\",                     //订单类型：1私课2团课\n    \"category\": \"2\",                 //课程类型：1多课程2单课程\n    \"product_name\": \"month单节\",     //产品名称\n    \"course_name\": \"month\",          //课种名称\n    \"class_length\": \"100\",           //课种时长\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?=\", //图片\n    \"desc\": \"\",                      //描述\n    \"aboutId\": \"41\",                 //约课记录id\n    \"memberCardId\": \"34\",            //会员卡id\n    \"classId\": \"5\",                  //订单详情id\n    \"status\": \"3\",                   //订单状态 1.约课中，2取消，3上课中，4课程结束，5课程过期\n    \"classType\": \"charge\",           //课程类型：charge是私课，group是团课\n    \"create_at\": \"1498116444\",       //订单创建时间\n    \"seatId\": null,                  //座位id\n    \"coach_id\": \"5\",                 //教练id\n    \"class_date\": \"2017-06-22\",      //订单日期\n    \"start\": \"15:27\",                //开始时间\n    \"end\": \"1498116999\",             //结束时间\n    \"cancel_time\": null,             //取消时间\n    \"memberId\": \"107\",               //会员id\n    \"classStatus\": true,             //上课中,true表示上课中，false，表示下课\n    \"coachName\": \"小A\",              // 教练名称\n    \"chargeNum\": 0,                  //第几节课\n    \"courseFlag\": true,              //true表示是私课，false表示团课\n    \"unusedFlag\": false              //true表示待使用，false,表示已使用\n   }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                       //失败标识\n  \"status\": \"error\",               //失败标识\n  \"message\": \"该会员最近没有课程\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberClass4"
  },
  {
    "type": "get",
    "url": "/v1/api-private/get-class-package-detail",
    "title": "产品课程详情",
    "version": "1.0.0",
    "name": "______",
    "group": "memberClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/get-class-package-detail\n{\n     \"id\":107，               //订单id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>产品课程详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/get-class-package-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "  {\n  \"code\": 1,                                //成功标识\n  \"status\": \"success\",                      //成功状态 \n  \"message\": \"请求成功\",                    //成功信息\n  \"data\": {         \n    \"id\": \"8\",                              //订单id\n    \"create_at\": \"1497335694\",              //下单时间（买课时间）\n    \"product_name\": \"两节课\",               //产品名称\n    \"course_amount\": \"20\",                  //总节数\n    \"money_amount\": \"210\",                  //总价格\n    \"course_order_id\": \"8\",                 //订单id\n    \"course_id\": \"6\",                       //课种id\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/u=2=0.jpg?e=1497265234&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:YqgyPQ0_98D_ADiNJdKML4X-wXs=\", //产品图片\n    \"score\": 4,                             //产品级别\n    \"scoreImg\": {                           //星星图\n    \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n  },\n  \"packageClass\": [                        //课程数组\n  {\n  \"name\": \"塑形\",                          //课程名称\n  \"times\": 1,                              //第几节\n  \"class_length\": \"100\",                   //时长\n  \"sale_price\": \"11.00\",                   //价格\n  \"is_member\": \"1\",                        //是不是会员标识\n  \"status\": \"1\"                            //1表示已上过 2表示未上过\n  },\n...\n  {\n  \"name\": \"month\",\n  \"times\": 1,\n  \"class_length\": \"100\",\n  \"sale_price\": \"10.00\",\n  \"is_member\": \"1\",\n  \"status\": \"1\"\n  },\n  ...\n  ]\n  }\n  }",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败状态\n  \"message\": \"未获取到数据\"                   //失败原因\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "memberClass"
  },
  {
    "type": "get",
    "url": "/v1/api-private/get-detail",
    "title": "会员购买产品详情",
    "version": "1.0.0",
    "name": "________",
    "group": "memberClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/get-detail\n{\n     \"id\":10                 //订单id\n     \"memberId\":107，        //会员id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员购买产品详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/get-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\":1,               //成功标识\n \"status\": \"success\",    //请求状态\n \"message\": \"请求成功\"， //返回信息\n \"data\": [\n  \"id\": \"5\",                                   //订单id\n  \"create_at\": \"1497149134\",                   //买课时间\n  \"product_name\": \"month单节\",                 //产品名称\n  \"course_amount\": \"10\",                       //总节数\n   \"category\":\"1\",                             // 1:多课程 2：单课程\n  \"money_amount\": \"100\",                       //总价格\n  \"course_order_id\": \"5\",                      //订单id\n  \"course_id\": \"11\",                           //课种id\n  \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?e=1497070119&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:8LWhLhqOIVZ9lbdwOLBlvYppdZg=\", //产品图片\n  \"desc\": \"\",                                  //产品描述\n  \"venue_id\": \"29\",                            //场馆id\n  \"venueName\": \"一月\",                         //场馆名称\n  \"venueAddress\": \"dsfasdfddddddddddddd\",      //场馆地址\n   \"longitude\": \"113.675505\"                   // 精度\n    \"latitude\":\"60.23232\"                      // 维度\n  \"memberCourseOrderDetails\": [                //产品详情\n  {\n     \"id\": \"5\",                                //订单详情id\n     \"course_order_id\": \"5\",                   //订单id\n     \"course_id\": \"11\",                        //课种id\n     \"course_num\": \"10\",                       //课程基础课量\n     \"course_length\": \"1000\",                  //课程有效天数\n     \"original_price\": \"15.00\",                //单节原价\n     \"sale_price\": null,                       //单节售价\n     \"pos_price\": null,                        //pos售价\n     \"type\": \"1\",                              //订单类型：1私课2团课\n     \"category\": \"2\",                          //课程类型：1多课程2单课程\n     \"product_name\": \"month单节\",              //产品名称\n     \"course_name\": \"month\",                   //课程名称\n     \"class_length\": \"100\",                    //课程时长\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?e=1497070119&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:8LWhLhqOIVZ9lbdwOLBlvYppdZg=\", //图片\n     \"desc\": \"\"                                //描述\n     }\n     ],\n  \"score\": 4,                                    //产品级别\n  \"scoreImg\": {                                  //产品星星图\n    \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n  },\n  \"orderStatus\": true                           //订单状态，true可以预约，false，课程已用完\n   \"newMember\"：true                            // 是否是新会员 （true新会员 false老会员）\n  \"aboutNum\": 1                                 //1表示预约第1节，2表示预约第2节...0表示课程已用完\n  }\n]",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败状态\n  \"message\": \"未获取到数据\"                   //失败原因\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "memberClass"
  },
  {
    "type": "get",
    "url": "/v1/api-private/get",
    "title": "获取会员所有购买产品",
    "version": "1.0.0",
    "name": "__________",
    "group": "memberClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "course",
            "description": "<p>课种id(搜索时传)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/get\n{\n     \"memberId\":107，        //会员id\n     \"requestType\":\"ios\"     //请求类型是ios\n     \"course\":10             //课种id(搜索时传)\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取会员所有购买产品 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/16</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/get"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\":1,               //成功标识\n \"status\": \"success\",    //请求状态\n \"message\": \"请求成功\"， //返回信息\n \"data\": [\n{\n  \"id\": \"5\",                             //订单id\n  \"classCount\": \"10\",                    //总节数\n  \"totalPrice\": \"100\",                   //总价钱\n  \"overage_section\": \"8\",                //剩余接收\n  \"product_name\": \"month单节\",           //产品名称\n  \"course_order_id\": \"5\",                //订单id\n  \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?e=1497070119&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:8LWhLhqOIVZ9lbdwOLBlvYppdZg=\", //图片\n  \"category\": \"1\",                       //课程类型（1多课程 2单课程）\n  \"package\": 1,                          //套餐的数量（此字段数据只在多课程时出现）\n  \"memberCourseOrderDetails\": [          //课程数组\n  {\n    \"id\": \"5\",                           //订单详情id\n    \"course_order_id\": \"5\",              //订单id\n    \"course_id\": \"11\",                   //课种id\n    \"course_num\": \"10\",                  //课程基础课量\n    \"course_length\": \"1000\",             //课程有效天数\n    \"original_price\": \"15.00\",           //单节原价\n    \"sale_price\": null,                  //单节售价\n    \"pos_price\": null,                   //单节pos售价\n    \"type\": \"1\",                         //订单类型：1私课2团课\n    \"category\": \"2\",                     //课程类型：1多课程2单课程\n    \"product_name\": \"month单节\",         //产品名称\n    \"course_name\": \"month\",              //课程名称\n    \"class_length\": \"100\",               //课程时长\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/0.jpg?e=1497070119&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:8LWhLhqOIVZ9lbdwOLBlvYppdZg=\",//图片\n    \"desc\": \"\"                           //产品描述\n  }\n  ],\n  \"score\": {\n    \"score\": 4,                          //产品级别\n    \"scoreImg\": {                        //评论星图\n       \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n       \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n}\n},\n\"tag\": [                                 //产品特色\n \"减脂\",\n \"特色\"\n]\n},\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败状态\n  \"message\": \"未获取到数据\"                   //失败原因\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "memberClass"
  },
  {
    "type": "post",
    "url": "/v1/api-member/set-upload",
    "title": "会员上传头像",
    "version": "1.0.0",
    "name": "______",
    "group": "memberImg",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员预约记录id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "pic",
            "description": "<p>图片</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/set-upload\n{\n     \"memberId\":18112                                          //会员id\n     \"pic\":\"http://oo0oj2qmr.bkt.clouddn.com/5.jpg?=\",        //图片\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员上传头像 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/23</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/set-upload"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,              //失败标识\n \"status\": \"error\",      //失败标识\n \"message\":\"请求成功\"    //失败提示信息\n \"data\":\"报错信息\"       //具体报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberImg"
  },
  {
    "type": "get",
    "url": "/v1/api-member/gain-card-limit",
    "title": "获取会员卡的请假规则获取",
    "version": "1.0.0",
    "name": "_____",
    "group": "memberLeave",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardId",
            "description": "<p>会员卡id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v1/api-member/gain-card-limit  会员卡请假\n  {\n     \"cardId\"     :  71609    会员卡id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取会员卡的请假规则 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2018/01/06</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/gain-card-limit"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "        按照请假总次数限制(第一种情况)\n{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",         //成功状态\n  \"data\": [\n      {\n     leave_total_days => 20      // 请假总天数\n     leave_least_days => 3      // 每次最低请假天数\n     leave_days_times =>\n     invalid_time => 1519971568   // 卡失效时间\n     attributes => 1              // 1个人,2家庭,3公司\n     leave_long_limit =>\n      }\n  ]\n              按照请假类型限制(第二种情况)\n{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",         //成功状态\n  \"data\": [\n      {\n[leave_total_days] =>\n[leave_least_days] =>\n[leave_days_times] => Array\n(\n[0] => Array\n(\n[0] => 4      //请假次数:4次\n[1] => 4      // 每次请假天数:4天\n)\n[1] => Array\n(\n[0] => 5   // 请假次数 5次\n[1] => 5  // 每次请假 5天\n )\n[2] => Array\n(\n[0] => 6\n[1] => 6\n)\n)\n[invalid_time] => 1565763419\n[attributes] => 1\n\n      }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"您还没有请假天数！\",\n\"data\":\"\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberLeave"
  },
  {
    "type": "post",
    "url": "/v1/api-member/submit-leave",
    "title": "会员请假表单验证",
    "version": "1.0.0",
    "name": "________",
    "group": "memberLeave",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveArrayIndex",
            "description": "<p>按照请假类型请求时选择哪一个 将对应数组下标传过来</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveType",
            "description": "<p>传1代表正常请假 传2代表特殊请假</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leavePersonId",
            "description": "<p>请假人id（会员ID）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "leaveReason",
            "description": "<p>请假原因（原因）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "leaveStartTime",
            "description": "<p>请假开始时间 （2017-03-06）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "leaveEndTime",
            "description": "<p>请假结束时间 (2017-03-10）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveTotalDays",
            "description": "<p>*请假离开总天数</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveLimitStatus",
            "description": "<p>*请假限制识别（1代表按照总次数限制 2代表按照请假类型限制）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberCardId",
            "description": "<p>会员卡ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestSource",
            "description": "<p>请求来源   默认值 app</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "POST /check-card/leave-record\n{\n     “leaveArrayIndex”:0           //请假类型的数组 下标(只有按照请假各种类别限制的时候 才会传)\n     \"leaveType\"   : 1               // 请假类型  1是正常请假 2是特殊请假\n    \"leavePersonId\": 2,             // 请假会员ID\n    \"leaveReason\": \"不请了\",        // 请假原因\n    \"leaveStartTime\": 2017-06-06,   //请假开始时间\n    \"leaveEndTime\":2017-08-08,      // 请假结束时间\n    \"leaveTotalDays\" :30,           // 请假的总天数\n    \"leaveLimitStatus\" :1,          // 请假限制状态  1 代表 请假总天数限制  2 代表按照各种请假次数遍历\n    \"memberCardId\" :3,              // 会员卡id\n     “requestSource”：app        // 请求来源app\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员请假表单验证 <span><strong>作    者：</strong></span>侯凯新<br> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br> <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.uniwlan.com/v1/api-member/submit-leave"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>请假保存状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回请假状态数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{'status':'success','status'=>'success','data':请假保存数据状态}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{'status':'error','status'=>'error','data':请假保存数据状态}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "memberLeave"
  },
  {
    "type": "get",
    "url": "/v1/api-member/member-detail",
    "title": "会员信息",
    "version": "1.0.0",
    "name": "____",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型(ios)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/member-detail\n{\n     \"memberId\":107,       //会员id\n     \"requestType\":\"ios\"   //请求类型：ios是区别其他app请求的标识\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取会员信息 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/get-member-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回成功和失败</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": {\n     \"id\": \"24668\",      //会员id\n     \"username\": \"yyyy\", //用户名\n     \"pic\": null,        //头像\n     \"venueId\":1         //场馆id\n     \"name\": \"黄鹏举\",   //姓名\n     \"nickname\": \"测试\"  //昵称\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,             //失败标识\n \"status\": \"error\",     //失败标识\n \"message\":\"请求失败\"   //失败提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-class/get-seat-detail",
    "title": "团课座位详情",
    "version": "1.0.0",
    "name": "____",
    "group": "member",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardId",
            "description": "<p>会员卡id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "classId",
            "description": "<p>团课id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v3/api-class/get-seat-detail   团课座位详情\n{\n     \"memberId\"  :  1,\n     \"cardId\"    :  955,\n     \"classId\"   :  13957\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "description": "<p>所有场馆 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/get-seat-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"请求成功\",\n \"data\": {\n \"id\": \"2271\",\n \"start\": \"1517112000\",\n \"end\": \"1517115600\",\n \"class_date\": \"2018-01-28\",\n \"created_at\": \"1517016915\",\n \"status\": \"1\",\n \"course_id\": \"16\",\n \"coach_id\": \"64\",\n \"classroom_id\": \"40\",\n \"create_id\": \"304\",\n \"difficulty\": \"1\",\n \"desc\": null,\n \"pic\": null,\n \"class_limit_time\": null,      //开课前几分钟不能约课\n \"cancel_limit_time\": null,     //开课前几分钟不能取消约课\n \"least_people\": null,\n \"company_id\": \"1\",\n \"venue_id\": \"15\",\n \"seat_type_id\": \"42\",\n \"in_time\": \"0\",\n \"out_time\": \"0\",\n \"courseName\": \"空中瑜伽\",\n \"course_desrc\": \"又叫反重力瑜伽，利用空中瑜伽吊床，完成哈他瑜伽体式。练习者感受到身体体重，加深体式的伸展、阻力和正位能力，具有高效的放松、疗愈、瘦身效果，更具有趣味性和互动性。它可以塑型减脂，增强身体稳定性，改善肩颈问题，增强握力和核心控制力，改善腿型，轻松倒立，天然的美容课程。眩晕症，腕管综合征，刚刚做完面部整形，孕期，女性生理期，脊椎关节问题，术后未恢复，眼耳部疾病等身体问题不建议上大课，可在教练辅助下上一对一私教\",\n \"seat_type\": \"1\",\n \"seat_number\": \"4\",\n \"rows\": \"1\",\n \"columns\": \"1\",\n \"coachName\": \"王靖文\",\n \"seat\": [\n     {\n        \"id\": \"2271\",\n        \"classroom_id\": \"40\",\n        \"seat_type\": \"1\",\n        \"seat_number\": \"4\",\n        \"rows\": \"1\",\n        \"columns\": \"1\",\n        \"seat_type_id\": \"42\",\n        \"authority\": 1,      //是否有权限预约 ： 1 有 、     0  无\n        \"isToken\": 0         //座位是否被占用 ： 1 被占用 、 0  没占用\n      },\n    ]\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                         //失败标识\n  \"status\": \"error\",                 //失败标识\n  \"message\": \"\"         //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-counselor",
    "title": "会籍顾问",
    "version": "1.0.0",
    "name": "____",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/get-counselor  会籍顾问\n  {\n     \"venueId\"   :  2        //场馆id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员来源渠道 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/21</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-counselor"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"返回成功\",     //成功状态\n   \"data\": [\n       {\n       \"id\": \"12\",\n       \"value\": \"袁二婷\"\n       },\n       {\n       \"id\": \"30\",\n       \"value\": \"赵丹\"\n       }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                 //参数传入是否合法\n\"status\": \"error\",         //错误状态\n\"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/order-charge-class",
    "title": "预约私教课",
    "version": "1.0.0",
    "name": "_____",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "time",
            "description": "<p>约课时间</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "chargeId",
            "description": "<p>私教课id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "coachId",
            "description": "<p>教练id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/order-charge-class\n{\n   \"memberId\" :'100'          //会员id\n   \"time\"     : 1516673532    //预约时间：时间戳\n   \"chargeId\" : 41            //私教课程id\n   \"coachId\"  : 8             //教练id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号会员卡列表 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/order-charge-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"约课成功\"\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"教练这个时间已经被预约了\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v1/api-member/update-member-detail",
    "title": "修改会员信息",
    "version": "1.0.0",
    "name": "______",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>会员姓名</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/update-member-detail\n{\n     \"memberId\":107,       //会员id\n     \"name\":\"张三\"        //会员姓名\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>修改会员信息 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/update-member-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回成功和失败</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"修改成功\"    //成功提示信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,             //失败标识\n \"status\": \"error\",     //失败标识\n \"message\":\"修改失败\"   //失败提示信息\n \"data\":\"报错信息\"      //失败报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-deal",
    "title": "新会员入会协议",
    "version": "1.0.0",
    "name": "_______",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/get-deal  新会员入会协议\n  {\n     \"companyId\"   :  1        //公司id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员来源渠道 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/21</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-deal"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"返回成功\",     //成功状态\n   \"data\": \"新会员入会协议\",\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                 //参数传入是否合法\n\"status\": \"error\",         //错误状态\n\"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/wechat-login",
    "title": "微信公众号登陆",
    "version": "1.0.0",
    "name": "_______",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": "<p>微信openid</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "miniOpenid",
            "description": "<p>微信小程序openid</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post   /v3/api-member/wechat-login   微信公众号登陆\n  {\n     \"mobile\"       :  \"12345678912\"         手机号码\n     \"code\"         :  \"37803\"               验证码\n     \"openid\"       :  \"qwwrterwsfdfdgf\"     微信openid\n     \"miniOpenid\"   :  \"qwwrterwsfdfdgf\"     微信小程序openid\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号已约团课列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/22</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/wechat-login"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",         //成功状态\n  \"data\": [\n      {\n      }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"您还不是会员，请注册！\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/wechat-register",
    "title": "微信公众号注册",
    "version": "1.0.0",
    "name": "_______",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venue_id",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "company_id",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": "<p>微信openid</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_venue_id",
            "description": "<p>上次登录场馆</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "source",
            "description": "<p>会员来源 : 小程序注册 : &quot;微信小程序&quot; 、公众号注册 : &quot;微信公众号&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post   /v3/api-member/wechat-register   微信公众号注册\n  {\n     \"name\"    :  \"夏奇拉\"        //姓名\n     \"mobile\"  : \"18339232573\"   //手机\n     \"venueId\" : \"2\"             //场馆id\n     \"source\"  : \"微信小程序\"      //小程序注册 : \"微信小程序\" 、公众号注册 : \"微信公众号\"\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员来源渠道 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/21</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/wechat-register"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"返回成功\",     //成功状态\n   \"data\": {\n          \"username\": \"夏奇拉\",\n          \"password\": \"$2y$13$qniV3gL3xLvdMXho489DSuUclwvtl9dX5h59yX7L54NxKPQbwkUmm\",\n          \"mobile\": \"18339232573\",\n          \"register_time\": 1513839423,\n          \"status\": 1,\n          \"member_type\": 2,\n          \"venue_id\": \"2\",\n          \"company_id\": 1,\n          \"id\": \"92576\"\n      }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"注册失败\",\n}\n{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"此手机已经注册过了\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-class/course-order-list",
    "title": "微信已购私课列表",
    "version": "1.0.0",
    "name": "________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/course-order-list  微信已购私课列表\n  {\n     \"memberId\"  :  \"2\"               会员id\n     \"venueId\"   :  \"1\"               公司id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信已购私课列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/course-order-list"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/course-order-list"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": [\n {\n     \"id\": \"52051\",                //私教课订单id\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=\",\n     \"product_name\": \"PT游泳课\",    //私教课名称\n     \"course_amount\": \"10\",        //总节数\n     \"overage_section\": \"10\",      //剩余节数\n     \"money_amount\": \"3400.00\"     //总金额\n },\n {\n     \"id\": \"52052\",\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=\",\n     \"product_name\": \"PT游泳课\",\n     \"course_amount\": \"2\",\n     \"overage_section\": \"2\",\n     \"money_amount\": \"0.00\"\n },\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"您还没有购买私教课\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/wechat-relogin",
    "title": "微信公众号二次登陆",
    "version": "1.0.0",
    "name": "_________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venue_id",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "company_id",
            "description": "<p>公司id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post   /v3/api-member/wechat-relogin   微信公众号二次登陆\n  {\n     \"mobile\"     :  \"12345678912\"     手机号码\n     \"venue_id\"   :  \"2\"               场馆id\n     \"company_id\"  :  \"1\"               公司id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号二次登陆 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/22</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/wechat-relogin"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"您还不是会员，请注册！\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/confirm-the-info",
    "title": "确认信息",
    "version": "1.0.0",
    "name": "_________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nickname",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "source",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v3/api-member/confirm-the-info\n{\n   \"mobile\"      :'1369682389'   //手机\n   \"companyId\"   : 1             //公司id\n   \"venueId\"     : 2             //场馆id\n   \"lastVenueId\" : 12            //切换前场馆id\n   \"sex\"         : 1             //性别：男 1 ，女  2\n   \"name\"        : '小明'         //昵称\n   \"idCard\"      : '123456'      //身份证\n   \"openid\"      : 'zxcasdjk'    //openid\n   \"source\"      : \"微信小程序\"   //小程序注册 : \"微信小程序\" 、公众号注册 : \"微信公众号\"\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>确认信息 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/confirm-the-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"添加成功\",\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"添加失败\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-my-profile",
    "title": "个人信息",
    "version": "1.0.0",
    "name": "_________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/get-my-profile\n{\n   \"memberId\" :'100'          //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>个人信息 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-my-profile"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"成功\"\n \"data\": {\n      \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/6538301515897844.jpg?e=1515901444&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:QEem-paOqJy_h9wmA-72AvqMhNY=\",\n      \"nickname\": null,\n      \"id\": \"94193\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"没有数据\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/switch-the-venue",
    "title": "切换场馆",
    "version": "1.0.0",
    "name": "_________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v3/api-member/switch-the-venue\n{\n   \"mobile\"    :'1369682389'   //手机\n   \"venueId\"   : 2             //场馆id\n   \"openid\"    :'123456'       //openid\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>确认信息 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/switch-the-venue"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"切换成功\",\n  \"data\": [\n      {\n\n      }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"切换失败\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/take-day-off",
    "title": "会员请假",
    "version": "1.0.0",
    "name": "_________",
    "group": "member",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leavePersonId",
            "description": "<p>请假人id（会员ID）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "leaveReason",
            "description": "<p>请假原因（原因）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "leaveStartTime",
            "description": "<p>请假开始时间 （2017-03-06）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "leaveEndTime",
            "description": "<p>请假结束时间 (2017-03-10）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveTotalDays",
            "description": "<p>*请假离开总天数</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveLimitStatus",
            "description": "<p>*请假限制识别码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "leaveArrayIndex",
            "description": "<p>*请假识别下标</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberCardId",
            "description": "<p>会员卡ID</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request Example",
          "content": "POST /check-card/leave-record\n{\n    \"leavePersonId\": 2,             // 请假会员ID\n    \"leaveReason\": \"不请了\",        // 请假原因\n    \"leaveStartTime\": 2017-06-06,   //请假开始时间\n    \"leaveEndTime\":2017-08-08,      // 请假结束时间\n    \"leaveTotalDays\" :30,           // 请假总天数\n    \"leaveLimitStatus\" :1,          // 请假限制状态  1 按照请假总天数遍历 2 请假次数遍历 3 没有请假限制\n    \"leaveArrayIndex\" :1,           // 请假发送数组下标\n    \"memberCardId\" :3,              // 会员卡id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员请假表单验证 <span><strong>作    者：</strong></span>焦冰洋<br> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club<br> <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/take-day-off"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>请假保存状态</p>"
          },
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回请假状态数据</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功示例:",
          "content": "{'status':'success','status'=>'success','data':请假保存数据状态}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误示例:",
          "content": "{'status':'error','status'=>'error','data':请假保存数据状态}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/order-class-list",
    "title": "微信公众号已约课程列表",
    "version": "1.0.0",
    "name": "___________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/order-class-list   微信公众号已约课程列表\n  {\n     \"memberId\"  :  \"12345\"     //会员id\n     \"per-page\"  :   2          //每页显示数，默认2\n     \"page\"      :   2          //第几页\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号已约课程列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/22</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/order-class-list"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",         //成功状态\n  \"data\": [\n      {\n      \"id\": \"37803\",\n      \"type\" : \"1\"             // 1、私课 2、团课\n      \"start\": \"1515151200\",\n      \"end\"  :  \"1515154800\",\n      \"status\": \"1\",           //团课：1、待上课 2、取消 3、上课中 4、下课 5、过期  //私课：1、待审核 2、已取消 3、上课中 4、已下课 6、已爽约\n      \"is_print_receipt\": \"2\", //有无打小票：1、有  2、没有\n      \"name\": \"蹦床\",\n      \"coach_name\": \"赵娅乐\",\n      \"pic\": \"\",\n      \"member_type\": \"2\",      //会员类型：1、普通会员  2、潜在会员\n      },\n      {\n      \"id\": \"37801\",\n      \"start\": \"1513994400\",\n      \"status\": \"2\",\n      \"name\": \"拉丁\",\n      \"coach_name\": \"王惠娴\",\n      \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/拉丁.jpg?e=1494055663&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:_Z8ASG5BnDwmQAKcIw2jgYlMAv4=\"\n      }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-my-cards",
    "title": "我的会员卡",
    "version": "1.0.0",
    "name": "___________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/get-my-cards\n{\n   \"memberId\" :'100'           //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>个人信息 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-my-cards"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"成功\",\n \"data\": [\n   {\n      \"card_name\": \"12MMD\",            //卡名称\n      \"card_number\": \"09600155\",       //卡编号\n      \"status\": \"1\",                   //卡状态：1、正常  2、异常  3、冻结  4、未激活\n      \"create_at\": \"2017-12-17\",       //办卡时间\n      \"invalid_time\": \"2018-01-31\",    //时效时间\n      \"duration\": {\n             \"day\": 30                 //有效期\n      }\n   }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"没有数据\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/update-my-profile",
    "title": "修改个人信息",
    "version": "1.0.0",
    "name": "_____________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nickname",
            "description": "<p>昵称</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v3/api-member/update-my-profile\n{\n   \"memberId\" :   1         //会员id\n   \"nickname\" : '小华'       //昵称\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>修改个人信息 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/update-my-profile"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"修改成功\"\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"修改信息失败\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-my-venues",
    "title": "我拥有的场馆",
    "version": "1.0.0",
    "name": "_____________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/get-my-venues\n{\n   \"mobile\" :'1369682389'           //手机\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>我拥有的场馆 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-my-venues"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"成功\",\n \"data\": [\n    {\n       \"id\": \"2\",\n       \"name\": \"大上海瑜伽健身馆\"\n    }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"没有数据\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-source",
    "title": "会员来源渠道",
    "version": "1.0.0",
    "name": "______________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/get-source  会员来源渠道\n  {\n     \"venueId\"   :  2        //场馆id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员来源渠道 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/21</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-source"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"返回成功\",     //成功状态\n   \"data\": [\n       {\n       \"id\": \"29\",\n       \"value\": \"户外广告\"\n       },\n       {\n       \"id\": \"30\",\n       \"value\": \"网络（美团，大众点评，百度糯米，支付宝口碑）\"\n       },\n       {\n       \"id\": \"32\",\n       \"value\": \"推荐\"\n       },\n    ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                 //参数传入是否合法\n\"status\": \"error\",         //错误状态\n\"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-other-venues",
    "title": "我不拥有的场馆",
    "version": "1.0.0",
    "name": "_______________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/get-other-venues\n{\n   \"mobile\" :'1369682389'           //手机\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>我不拥有的场馆 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-other-venues"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"成功\",\n \"data\": [\n    {\n       \"id\": \"2\",\n       \"name\": \"大上海瑜伽健身馆\"\n       \"pic\": \"\"\n    }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"没有数据\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-access-venues",
    "title": "查看能否通店场馆",
    "version": "1.0.0",
    "name": "_________________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companyId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/get-access-venues\n{\n   \"memberId\"   :'1'        //会员id\n   \"companyId\"  : 2         //公司id\n   \"type\"       :'yes'      //查看类型：yes 可以通店的场馆 ；no 不可以通店的场馆\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>查看能否通店场馆 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-access-venues"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"切换成功\",\n  \"data\": [\n     {\n       \"id\": \"2\",\n       \"name\": \"大上海瑜伽健身馆\"\n     },\n     {\n       \"id\": \"10\",\n       \"name\": \"大学路舞蹈健身馆\"\n     }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"没有数据\",\n \"data\" : ''\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-class/course-order-info",
    "title": "微信已购私课详情",
    "version": "1.0.0",
    "name": "_________________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>私教课订单id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/course-order-info  微信已购私课详情\n  {\n     \"id\"   :  \"1\"               私教课订单id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信已购私课详情 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-class/course-order-info"
      },
      {
        "url": "http://qa.aixingfu.net/v3/api-class/course-order-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"     //成功提示信息\n \"data\": {\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=\",\n     \"product_name\": \"PT游泳课\",             //私教课名称\n     \"describe\": \"经常进行高，低冲击有氧操锻炼，有助于提高人体的心肺功能，耐力水平。能有效的燃烧体内多余的脂肪。达到塑身纤体的效果。\",\n     \"course_duration\": null,               //课程时长\n     \"unit_price\": 340                      //课时费\n     \"price\": [\n      {\n          \"id\": \"4\",\n          \"charge_class_id\": \"13\",\n          \"course_package_detail_id\": \"9\",\n          \"intervalStart\": \"1\",             //最少节数\n          \"intervalEnd\": \"12\",              //最多节数\n          \"unitPrice\": \"340\",               //优惠单价\n          \"posPrice\": \"340\",                //pos单价\n          \"create_time\": \"1499939403\"\n      }\n  ]\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                             //参数传入是否合法\n \"status\": \"error\",                     //错误状态\n \"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiClassController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v3/api-member/check-the-course",
    "title": "判断是否可以约私课",
    "version": "1.0.0",
    "name": "___________________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "chargeId",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v3/api-member/check-the-course\n{\n   \"memberId\" :  1        //会员id\n   \"chargeId\" :  2        //私教id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>查看能否通店场馆 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/check-the-course"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,             //成功状态码\n \"status\": \"success\",   //可以约\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,            //错误状态码\n \"status\": \"error\",    //不可以约\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/get-access-cards",
    "title": "查看可以通店的会员卡",
    "version": "1.0.0",
    "name": "_____________________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v3/api-member/get-access-cards\n{\n   \"memberId\" :'1'        //会员id\n   \"venueId\"  : 2         //场馆id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>查看可以通店的会员卡 <br/> <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2018/1/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/get-access-cards"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",\n \"message\": \"切换成功\",\n \"data\": [\n   {\n      \"memberCardId\": \"72064\",\n      \"cardNumber\": \"051516868888\",\n      \"cardName\": \"Y12MMD\",\n      \"cardStatus\": \"4\",\n      \"active_time\": \"未激活\",\n      \"invalid_time\": \"2018/02/24\"\n   },\n   {\n      \"memberCardId\": \"72063\",\n      \"cardNumber\": \"091516867451\",\n      \"cardName\": \"BC60MD\",\n      \"cardStatus\": \"4\",\n      \"active_time\": \"未激活\",\n      \"invalid_time\": \"2023/01/24\"\n   }\n ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",\n \"message\": \"没有数据\",\n \"data\" : ''\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "get",
    "url": "/v3/api-member/order-class-info",
    "title": "微信公众号已约团课详情",
    "version": "1.0.0",
    "name": "_______________________",
    "group": "member",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>预约课程id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v3/api-member/order-class-info   微信公众号已约团课详情\n{\n     \"aboutId\"   :  \"37803\"        预约课程id\n     \"memberId\"  :  \"12345\"        会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>微信公众号已约团课列表 <span><strong>作    者：</strong></span>焦冰洋<br/> <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club <span><strong>创建时间：</strong></span>2017/12/22</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v3/api-member/order-class-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",          //成功状态\n  \"data\": [\n      {\n      \"aboutId\": \"37803\",         //预约课程id\n      \"type\" : \"1\"                // 1、私课 2、团课\n      \"member_id\": \"93457\",       //会员id\n      \"member_type\": \"2\",         //会员类型：1、普通会员  2、潜在会员\n      \"status\": \"1\",              //团课：1、待上课 2、取消 3、上课中 4、下课 5、过期  //私课：1、待审核 2、已取消 3、上课中 4、已下课 6、已爽约\n      \"start\": \"1514010600\",      //上课时间\n      \"end\": \"1515154800\",        //下课时间\n      \"is_print_receipt\": \"2\",    //有无打小票：1、有  2、没有\n      \"course_name\": \"蹦床\",       //课程名字\n      \"course_duration\": \"60\",    //课程时长：分钟\n      \"coach_name\": \"赵娅乐\",      //教练名字\n      \"create_at\": \"1513943798\"   //下单时间\n      \"cancel_time\": \"1513944654\",//取消预约时间\n      \"cancel_limit_time\": null   //开课前多少分钟不能取消约课\n      \"entry_count\": \"0\"          //会员进馆记录\n      }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"没有数据\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v3/controllers/ApiMemberController.php",
    "groupTitle": "member"
  },
  {
    "type": "post",
    "url": "/v1/api-member/set-bink-member",
    "title": "绑定用户",
    "version": "1.0.0",
    "name": "____",
    "group": "partyLanding",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>第三方服务商类型</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "openId",
            "description": "<p>唯一ID</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司ID</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆Id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companySign",
            "description": "<p>公司标识</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "scenario",
            "description": "<p>场景</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>场景</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post /v1/api-member/set-bink-member\n{\n   \"type\"      :'qq'                            //第三方服务商类型\n   \"openId\"    :'skahdausjhd'                    //唯一ID\n   \"mobile\"    :'13556565656'                 //手机号\n   \"companyId\" :'1'                          //公司ID\n   \"venueId\"   :'2'                          //场馆Id\n   \"password\"  :'asas'                          //密码\n   \"scenario\"  :'bink'                       //场景\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员卡列表 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/set-bink-member"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              // 1.已经绑定 2.未绑定\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": {\n     \"mobile\": \"15713716632\",            //会员手机号\n     \"username\": \"15713716632\",          //会员临时姓名\n     \"password\": \"$2y$13$ZJjDeZIXOhI.\",  //加密过的密码\n     \"register_time\": 1498548933,        //注册时间（时间戳）\n     \"status\": 1,                        //状态 1：普通会员\n     \"id\": \"212\"                         //会员id\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //失败提示信息\n \"data\":\"数据格式不正确\"    //具体报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "partyLanding"
  },
  {
    "type": "post",
    "url": "/v1/api-member/set-party-landing",
    "title": "第三方登录",
    "version": "1.0.0",
    "name": "_____",
    "group": "partyLanding",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>第三方服务商类型</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "openId",
            "description": "<p>唯一ID</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companySign",
            "description": "<p>公司标识</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "scenario",
            "description": "<p>场景</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member/set-party-landing\n{\n   \"type\" :'100'                            //第三方服务商类型\n   \"openId\" :'100'                          //唯一ID\n   \"scenario\":'login'                       //场景\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>会员卡列表 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/set-party-landing"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              // 1.已经绑定 2.未绑定\n \"status\": \"success\",    //成功标识\n \"message\":\"请求成功\"    //成功提示信息\n \"data\": {\n     \"mobile\": \"15713716632\",            //会员手机号\n     \"username\": \"15713716632\",          //会员临时姓名\n     \"password\": \"$2y$13$ZJjDeZIXOhI.\",  //加密过的密码\n     \"register_time\": 1498548933,        //注册时间（时间戳）\n     \"status\": 1,                        //状态 1：普通会员\n     \"id\": \"212\"                         //会员id\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,                   //失败标识\n \"message\":\"请求失败\"         //失败提示信息\n \"data\":\"数据格式不正确\"    //具体报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "partyLanding"
  },
  {
    "type": "get",
    "url": "/v1/message",
    "title": "消息列表",
    "name": "1____",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fields",
            "description": "<p>可选,选择显示字段(例:fields=id,type_name,name,create_name,create_at)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>页码（可选，默认1）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "per-page",
            "description": "<p>每页显示数（可选，默认20）</p>"
          }
        ]
      }
    },
    "description": "<p>消息列表 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/31</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/message"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": " {\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"items\": [\n            {\n                \"id\": \"100795\", //预约消息ID\n                \"status\": 8,//8待预约，9预约失败\n                \"type\": \"3\",//3小团体课程，4小团体服务\n                \"coach\": \"高陈静\",//教练\n                \"start\": \"1517454000\",//开课时间\n                \"is_read\": 0,//0未读 1已读\n                \"create_at\":\"1517454000\",//排课时间\n                \"had_about_num\":\"3\",//已预约人数\n                \"class_info\": {//小团体课详情\n                    \"id\": \"4\",\n                    \"class_number\": \"01311507318918\",\n                    \"sell_number\": \"3\",\n                    \"surplus\": \"0\",\n                    \"total_class_num\": \"6\",\n                    \"attend_class_num\": 6,\n                    \"valid_time\": null,\n                    \"sale_num\": \"80\",\n                    \"surplus_sale_num\": \"80\",\n                    \"venue_address\": \"东太康路大上海城3区6楼\",\n                    \"people_least\": 2,\n                    \"people_most\": 3,\n                    \"least_number\": 2,\n                    \"charge_class_type\": 2,\n                    \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=\",\n                    \"charge_class_name\": \"多人课程\",\n                    \"charge_class_describe\": \"如何\",\n                    \"course_package\": [\n                        {\n                            \"id\": \"556\",\n                            \"course_num\": null,\n                            \"course_length\": \"55\",\n                            \"original_price\": \"100.00\",\n                            \"course_name\": \"PT常规课\"\n                        }\n                    ],\n                    \"price\": \"1800.00\",\n                    \"had_buy\": 0\n                }\n            }\n        ],\n        \"_links\": {\n            \"self\": {\n                \"href\": \"http://127.0.0.2/v1/message/index?memberId=95337&page=1\"\n            }\n        },\n        \"_meta\": {\n            \"totalCount\": 1,\n            \"pageCount\": 1,\n            \"currentPage\": 1,\n            \"perPage\": 20\n        }\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/MessageController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/about-class",
    "title": "预约列表",
    "name": "1____",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fields",
            "description": "<p>可选,选择显示字段(例:fields=id,type_name,name,create_name,create_at)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>页码（可选，默认1）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "per-page",
            "description": "<p>每页显示数（可选，默认20）</p>"
          }
        ]
      }
    },
    "description": "<p>消息列表 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/02/02</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/about-class"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": " {\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"items\": [\n            {\n                \"id\": \"100795\", //预约消息ID\n                \"status\": 8,//8待预约，9预约失败\n                \"type\": \"3\",//3小团体课程，4小团体服务\n                \"coach\": \"高陈静\",//教练\n                \"start\": \"1517454000\",//开课时间\n                \"is_read\": 0,//0未读 1已读\n                \"create_at\":\"1517454000\",//排课时间\n                \"had_about_num\":\"3\",//已预约人数\n                \"class_info\": {//小团体课详情\n                    \"id\": \"4\",\n                    \"class_number\": \"01311507318918\",\n                    \"sell_number\": \"3\",\n                    \"surplus\": \"0\",\n                    \"total_class_num\": \"6\",\n                    \"attend_class_num\": 6,\n                    \"valid_time\": null,\n                    \"sale_num\": \"80\",\n                    \"surplus_sale_num\": \"80\",\n                    \"venue_address\": \"东太康路大上海城3区6楼\",\n                    \"people_least\": 2,\n                    \"people_most\": 3,\n                    \"least_number\": 2,\n                    \"charge_class_type\": 2,\n                    \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=\",\n                    \"charge_class_name\": \"多人课程\",\n                    \"charge_class_describe\": \"如何\",\n                    \"course_package\": [\n                        {\n                            \"id\": \"556\",\n                            \"course_num\": null,\n                            \"course_length\": \"55\",\n                            \"original_price\": \"100.00\",\n                            \"course_name\": \"PT常规课\"\n                        }\n                    ],\n                    \"price\": \"1800.00\",\n                    \"had_buy\": 0\n                }\n            },\n{  私教课\n    \"id\": \"67360\",\n    \"status\": 1,\n    \"type\": \"1\",\n    \"coach\": \"唐成\",\n    \"start\": \"1517569200\",\n    \"end\": \"1517571600\",\n    \"is_read\": 0,\n    \"create_at\": \"1517553294\",\n    \"cancel_time\": null,\n    \"class_info\": {\n    \"type\": \"charge\",\n    \"productName\": \"PT游泳课\",\n    \"courseName\": \"PT游泳课\",\n    \"classLength\": \"40\",\n    \"category\": \"2\",\n    \"courseNum\": \"3\",\n    \"courseAmount\": \"3\",\n    \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=\",\n    \"originalPrice\": \"360.00\",\n    \"totalPrice\": \"暂无数据\",\n    \"venue_id\": \"76\",\n    \"venue_name\": \"艾搏尊爵汇馆\",\n    \"venue_address\": \"郑州市二七万达广场\",\n    \"chargeNum\": 1,\n    \"score\": 4,\n    \"scoreImg\": {\n    \"one\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"two\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"three\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"four\": \"http://oo0oj2qmr.bkt.clouddn.com/x1.png?e=1497241578&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:-mWeOtqLBC56lg63U-1EZN17xhI=\",\n    \"five\": \"http://oo0oj2qmr.bkt.clouddn.com/x2.png?e=1497241610&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:dh27FM6Djr3vNdMcJ-DXSkxBnp4=\"\n    },\n    \"packageClass\": [\n    {\n    \"coachName\": \"唐成\",\n    \"name\": \"PT游泳课\",\n    \"times\": 1,\n    \"course_length\": \"40\",\n    \"sale_price\": \"暂无数据\",\n    \"is_member\": \"1\",\n    \"status\": \"1\"\n    },\n    {\n    \"name\": \"PT游泳课\",\n    \"times\": 2,\n    \"course_length\": \"40\",\n    \"sale_price\": \"暂无数据\",\n    \"is_member\": \"1\",\n    \"status\": \"2\"\n    },\n    {\n    \"name\": \"PT游泳课\",\n    \"times\": 3,\n    \"course_length\": \"40\",\n    \"sale_price\": \"暂无数据\",\n    \"is_member\": \"1\",\n    \"status\": \"2\"\n    }\n    ],\n    \"courseFlag\": true,\n    \"limit\": false\n    }\n},\n{    团教课\n    \"id\": \"67359\",\n    \"status\": 1,\n    \"type\": \"2\",\n    \"coach\": \"王小璐\",\n    \"start\": \"1517720400\",\n    \"end\": \"1517724000\",\n    \"is_read\": 0,\n    \"create_at\": \"1517546584\",\n    \"cancel_time\": null,\n    \"class_info\": {\n    \"id\": \"12739\",\n    \"course_pic\": \"\",\n    \"course_name\": \"基础瑜伽\",\n    \"venue_id\": \"76\",\n    \"venue_name\": \"艾搏尊爵汇馆\",\n    \"venue_address\": \"郑州市二七万达广场\"\n    },\n    \"class_room\": \"1号厅\",\n    \"seat_number\": \"28\"\n}\n        ],\n        \"_links\": {\n            \"self\": {\n                \"href\": \"http://127.0.0.2/v1/message/index?memberId=95337&page=1\"\n            }\n        },\n        \"_meta\": {\n            \"totalCount\": 1,\n            \"pageCount\": 1,\n            \"currentPage\": 1,\n            \"perPage\": 20\n        }\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/AboutClassController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/charge-class-number",
    "title": "小团体课列表",
    "name": "1______",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆ID(小团体课列表)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员ID（已购买的小团体课列表)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fields",
            "description": "<p>可选,选择显示字段(例:fields=id,type_name,name,create_name,create_at)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>页码（可选，默认1）</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "per-page",
            "description": "<p>每页显示数（可选，默认20）</p>"
          }
        ]
      }
    },
    "description": "<p>小团体课列表 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/24</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/charge-class-number"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n  \"message\": \"\",\n  \"code\": 1,\n  \"status\": 200,\n  \"data\": {\n    \"items\": [\n      {\n        \"id\": \"10\",\n        \"class_number\": \"01241357127583\",\n        \"sell_number\": \"5\",\n        \"surplus\": \"5\",\n        \"total_class_num\": \"50\",\n        \"attend_class_num\": 50,\n        \"valid_time\": null,\n        \"sale_num\": \"55\",\n        \"surplus_sale_num\": \"55\",\n        \"people_least\": 3,\n        \"people_most\": 5,\n        \"least_number\": 3,\n        \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/6635741516773433.jpg?e=1516777035&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:VHB8lthcdEMRzpuxGkusGxhV5dU=\",\n        \"charge_class_name\": \"kecheng\",\n      },\n      {\n        \"id\": \"9\",\n        \"class_number\": \"01241355308540\",\n        \"sell_number\": \"5\",\n        \"surplus\": \"5\",\n        \"total_class_num\": \"11\",\n        \"attend_class_num\": 11,\n        \"valid_time\": \"60\",\n        \"sale_num\": \"2\",\n        \"surplus_sale_num\": \"2\",\n        \"people_least\": 3,\n        \"people_most\": 5,\n        \"least_number\": 3,\n        \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/1562201516773333.jpg?e=1516776933&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:kPs_QnyW9Nf1W88o9-9IyYEfZpI=\",\n        \"charge_class_name\": \"ddd\",\n      },\n     ],\n    \"_links\": {\n      \"self\": {\n        \"href\": \"http://127.0.0.2/v1/charge-class-number/index?venueId=76&page=1\"\n      }\n    },\n    \"_meta\": {\n      \"totalCount\": 5,\n      \"pageCount\": 1,\n      \"currentPage\": 1,\n      \"perPage\": 20\n    }\n  }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/ChargeClassNumberController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/message/view",
    "title": "消息详情",
    "name": "2____",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>预约消息ID</p>"
          }
        ]
      }
    },
    "description": "<p>消息详情 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/31</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/message/view"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"id\": \"100795\", //预约消息ID\n        \"status\": 8,//8待预约，1已预约\n        \"type\": \"3\",//3小团体课程，4小团体服务\n        \"coach\": \"高陈静\",//教练\n        \"start\": \"1517454000\",//开课时间\n        \"is_read\": 0,//0未读 1已读\n        \"class_info\": {//小团体课详情\n            \"id\": \"4\",\n            \"class_number\": \"01311507318918\",\n            \"sell_number\": \"3\",\n            \"surplus\": \"0\",\n            \"total_class_num\": \"6\",\n            \"attend_class_num\": 6,\n            \"valid_time\": null,\n            \"sale_num\": \"80\",\n            \"surplus_sale_num\": \"80\",\n            \"venue_address\": \"东太康路大上海城3区6楼\",\n            \"people_least\": 2,\n            \"people_most\": 3,\n            \"least_number\": 2,\n            \"charge_class_type\": 2,\n            \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=\",\n            \"charge_class_name\": \"多人课程\",\n            \"charge_class_describe\": \"如何\",\n            \"course_package\": [\n                {\n                    \"id\": \"556\",\n                    \"course_num\": null,\n                    \"course_length\": \"55\",\n                    \"original_price\": \"100.00\",\n                    \"course_name\": \"PT常规课\"\n                }\n            ],\n            \"price\": \"1800.00\",\n            \"had_buy\": 0\n        }\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/MessageController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/message/view",
    "title": "消息详情",
    "name": "2____",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>预约消息ID</p>"
          }
        ]
      }
    },
    "description": "<p>消息详情 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/31</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/message/view"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"id\": \"100795\", //预约消息ID\n        \"status\": 8,//8待预约，1已预约\n        \"type\": \"3\",//3小团体课程，4小团体服务\n        \"coach\": \"高陈静\",//教练\n        \"start\": \"1517454000\",//开课时间\n        \"is_read\": 0,//0未读 1已读\n        \"class_info\": {//小团体课详情\n            \"id\": \"4\",\n            \"class_number\": \"01311507318918\",\n            \"sell_number\": \"3\",\n            \"surplus\": \"0\",\n            \"total_class_num\": \"6\",\n            \"attend_class_num\": 6,\n            \"valid_time\": null,\n            \"sale_num\": \"80\",\n            \"surplus_sale_num\": \"80\",\n            \"venue_address\": \"东太康路大上海城3区6楼\",\n            \"people_least\": 2,\n            \"people_most\": 3,\n            \"least_number\": 2,\n            \"charge_class_type\": 2,\n            \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=\",\n            \"charge_class_name\": \"多人课程\",\n            \"charge_class_describe\": \"如何\",\n            \"course_package\": [\n                {\n                    \"id\": \"556\",\n                    \"course_num\": null,\n                    \"course_length\": \"55\",\n                    \"original_price\": \"100.00\",\n                    \"course_name\": \"PT常规课\"\n                }\n            ],\n            \"price\": \"1800.00\",\n            \"had_buy\": 0\n        }\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/AboutClassController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/charge-class-number/view",
    "title": "小团体课详情",
    "name": "2______",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>小团体课ID</p>"
          }
        ]
      }
    },
    "description": "<p>小团体课列表 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/25</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/charge-class-number/view"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"id\": \"10\",\n        \"class_number\": \"01241357127583\",//编号\n        \"sell_number\": \"5\",//售卖数量\n        \"surplus\": \"5\",//剩余数量\n        \"total_class_num\": \"50\",//总节数\n        \"attend_class_num\": 50,//剩余节数\n        \"valid_time\": null,//产品有效期(天)\n        \"sale_num\": \"55\",//售卖课程套数\n        \"surplus_sale_num\": \"55\",//\t售卖课程剩余套数\n        \"people_least\": 3,//最少人数\n        \"people_most\": 5,//最多人数\n        \"least_number\": 3,//最低开课人数\n        \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/6635741516773433.jpg?e=1516777035&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:VHB8lthcdEMRzpuxGkusGxhV5dU=\",//图片\n        \"charge_class_name\": \"kecheng\",//名称\n        \"charge_class_describe\": \"dsfffff\",//介绍\n        \"course_package\": [\n            {\n                \"id\": \"560\",\n                \"course_num\": null,//课量\n                \"course_length\": \"50\",//时长\n                \"original_price\": \"50.00\",//单节原价\n                \"course_name\": \"PT常规课\"//课程名称\n            }\n        ],\n        \"price\":\"0.01\",//价格\n        \"had_buy\":0,//0未购买1已购买\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/ChargeClassNumberController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/message/about",
    "title": "预约小团体课",
    "name": "3______",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>预约消息ID</p>"
          }
        ]
      }
    },
    "description": "<p>预约小团体课 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/31</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/message/about"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"id\": \"100795\", //预约消息ID\n        \"status\": 8,//8待预约，1已预约\n        \"type\": \"3\",//3小团体课程，4小团体服务\n        \"coach\": \"高陈静\",//教练\n        \"start\": \"1517454000\",//开课时间\n        \"is_read\": 0,//0未读 1已读\n        \"class_info\": {//小团体课详情\n            \"id\": \"4\",\n            \"class_number\": \"01311507318918\",\n            \"sell_number\": \"3\",\n            \"surplus\": \"0\",\n            \"total_class_num\": \"6\",\n            \"attend_class_num\": 6,\n            \"valid_time\": null,\n            \"sale_num\": \"80\",\n            \"surplus_sale_num\": \"80\",\n            \"venue_address\": \"东太康路大上海城3区6楼\",\n            \"people_least\": 2,\n            \"people_most\": 3,\n            \"least_number\": 2,\n            \"charge_class_type\": 2,\n            \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=\",\n            \"charge_class_name\": \"多人课程\",\n            \"charge_class_describe\": \"如何\",\n            \"course_package\": [\n                {\n                    \"id\": \"556\",\n                    \"course_num\": null,\n                    \"course_length\": \"55\",\n                    \"original_price\": \"100.00\",\n                    \"course_name\": \"PT常规课\"\n                }\n            ],\n            \"price\": \"1800.00\",\n            \"had_buy\": 0\n        }\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/AboutClassController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/message/about",
    "title": "预约小团体课",
    "name": "3______",
    "group": "private_group",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>预约消息ID</p>"
          }
        ]
      }
    },
    "description": "<p>预约小团体课 <br/> <span><strong>作    者：</strong></span>张晓兵<br/> <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club <span><strong>创建时间：</strong></span>2018/01/31</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/message/about"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 1,\n    \"status\": 200,\n    \"data\": {\n        \"id\": \"100795\", //预约消息ID\n        \"status\": 8,//8待预约，1已预约\n        \"type\": \"3\",//3小团体课程，4小团体服务\n        \"coach\": \"高陈静\",//教练\n        \"start\": \"1517454000\",//开课时间\n        \"is_read\": 0,//0未读 1已读\n        \"class_info\": {//小团体课详情\n            \"id\": \"4\",\n            \"class_number\": \"01311507318918\",\n            \"sell_number\": \"3\",\n            \"surplus\": \"0\",\n            \"total_class_num\": \"6\",\n            \"attend_class_num\": 6,\n            \"valid_time\": null,\n            \"sale_num\": \"80\",\n            \"surplus_sale_num\": \"80\",\n            \"venue_address\": \"东太康路大上海城3区6楼\",\n            \"people_least\": 2,\n            \"people_most\": 3,\n            \"least_number\": 2,\n            \"charge_class_type\": 2,\n            \"charge_class_pic\": \"http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=\",\n            \"charge_class_name\": \"多人课程\",\n            \"charge_class_describe\": \"如何\",\n            \"course_package\": [\n                {\n                    \"id\": \"556\",\n                    \"course_num\": null,\n                    \"course_length\": \"55\",\n                    \"original_price\": \"100.00\",\n                    \"course_name\": \"PT常规课\"\n                }\n            ],\n            \"price\": \"1800.00\",\n            \"had_buy\": 0\n        }\n    }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n    \"message\": \"\",\n    \"code\": 0,\n    \"status\": 422,\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "backend/modules/v1/controllers/MessageController.php",
    "groupTitle": "private_group"
  },
  {
    "type": "get",
    "url": "/v1/api-qr-code/qr-code",
    "title": "设置二维码",
    "version": "1.0.0",
    "name": "_____",
    "group": "qrCode",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-qr-code/qr-code\n{\n     \"memberId\":1,           // 会员id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>设置二维码 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-qr-code/qr-code"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\": 1,                  //成功标识\n \"status\": \"success\",        //成功状态\n \"message\": \"请求成功\",      //成功信息\n \"data\": {\n   \"id\": \"107\",              //会员id\n   \"username\": \"zhangsan\",   //会员姓名\n   \"pic\": null,              //会员图片\n   \"img\": \"<img src=\\\"http://qa.uniwlan.com/v1/api-qr-code/render-html?memberId=107\\\" style=\\\"display:block;width: 100%;margin: 0 auto;\\\">\" //二维码\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiQrCodeController.php",
    "groupTitle": "qrCode"
  },
  {
    "type": "post",
    "url": "/v1/api-member/sign-up",
    "title": "注册",
    "version": "1.0.0",
    "name": "__",
    "group": "register",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/sign-up\n{\n     \"companyId\":1            //公司id\n     \"venueId\":2             //场馆id\n     \"mobile\":15011122233   //手机号\n     \"password\":******      //密码\n     \"code\":123456         //验证码\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户注册 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/sign-up"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回注册成功和失败信息</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"注册成功\"    //成功提示信息\n \"data\": {\n     \"mobile\": \"15713716632\",            //会员手机号\n     \"username\": \"15713716632\",          //会员临时姓名\n     \"password\": \"$2y$13$ZJjDeZIXOhI.\",  //加密过的密码\n     \"register_time\": 1498548933,        //注册时间（时间戳）\n     \"status\": 1,                        //状态 1：普通会员\n     \"id\": \"212\"                         //会员id\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,             //失败标识\n \"status\": \"error\",     //失败标识\n \"message\":\"注册失败\"   //失败提示信息\n \"data\": {\n     \"code\": \"验证码错误\",            //会员手机号\n }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "register"
  },
  {
    "type": "post",
    "url": "/v1/api-member/reset-password",
    "title": "重置密码",
    "version": "1.0.0",
    "name": "____",
    "group": "resetPassword",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>新密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "oldPassword",
            "description": "<p>旧密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueMemberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/reset-password\n{\n     \"mobile\":15011122233   //手机号\n     \"password\":******      //新密码\n     \"oldPassword\":******   //旧密码\n     \"code\":123456         //验证码\n     \"venueMemberId\":256  // 会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>重置密码 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/reset-password"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回成功和失败</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"修改成功\"    //成功提示信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,             //失败标识\n \"status\": \"error\",     //失败标识\n \"message\":\"修改失败\"   //失败提示信息\n \"data\":\"报错信息\"      //失败报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "resetPassword"
  },
  {
    "type": "post",
    "url": "/v1/api-member/retrieve-password",
    "title": "找回密码",
    "version": "1.0.0",
    "name": "____",
    "group": "retrievePassword",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companySign",
            "description": "<p>公司标识</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "theVenueId",
            "description": "<p>场馆id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member/sign-up\n{\n     \"mobile\":15011122233   //手机号\n     \"password\":******      //密码\n     \"code\":123456         //验证码\n     \"companySign\":wayd    // mb 表示 迈步公司  wayd 表示我爱运动公司\n      \"theVenueId\":12      // 场馆id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>找回密码 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/retrieve-password"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>返回成功和失败</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\":\"修改成功\"    //成功提示信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,             //失败标识\n \"status\": \"error\",     //失败标识\n \"message\":\"修改失败\"   //失败提示信息\n \"data\":\"报错信息\"      //失败报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "retrievePassword"
  },
  {
    "type": "get",
    "url": "/v1/api-member/message-contrast",
    "title": "闸机验卡",
    "version": "1.0.0",
    "name": "____",
    "group": "scanCode",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get  /v1/api-member/message-contrast\n{\n   \"memberId\"      : 12313     //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>//会员id <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/7/28</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/message-contrast"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",    //成功标识\n \"message\":\"刷卡成功\"    //成功提示信息\n \"data\": true          // 录入成功的信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"刷卡失败\"     //失败返回信息\n \"data\": \"刷卡失败信息\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "scanCode"
  },
  {
    "type": "get",
    "url": "/v1/api-member/machine-save-message",
    "title": "机器信息存储",
    "version": "1.0.0",
    "name": "______",
    "group": "scanCode",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "machineModel",
            "description": "<p>机器型号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "ip",
            "description": "<p>机器ip</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "machineType",
            "description": "<p>机器类型</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "machineStatus",
            "description": "<p>机器状态 1:正常 2：不正常</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "companyId",
            "description": "<p>公司id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get   /v1/api-member/machine-save-message\n{\n   \"machineModel\"  :  机器型号\n   \"ip\"            :  机器ip\n   \"machineType\"   : 机器类型\n   \"machineStatus\" : 机器型号\n    \"venueId\"      : 场馆id\n    \"companyId\"    : 公司id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>机器信息存储 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/7/29</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/machine-save-message"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",        //成功标识\n \"message\":\"数据录入成功\"    //数据录入成功\n \"data\": true                // 录入成功的信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"录入失败信息\"     //失败返回信息\n \"data\": 报错信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "scanCode"
  },
  {
    "type": "get",
    "url": "/v1/api-member/insert-scan-code",
    "title": "二维码扫描记录",
    "version": "1.0.0",
    "name": "_______",
    "group": "scanCode",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>前台发送的二维码信息</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get /v1/api-member/insert-scan-code\n{\n   \"data\"      : 12456@15555127518@412644      //前台发送的二维码信息(会员id@时间戳@会员卡id)\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>// 前台发送的二维码信息(会员id@时间戳) <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/7/28</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/insert-scan-code"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",    //成功标识\n \"message\":\"刷卡成功\"    //成功提示信息\n \"data\": true          // 录入成功的信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"刷卡失败\"     //失败返回信息\n \"data\": \"报错信息\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "scanCode"
  },
  {
    "type": "get",
    "url": "/v1/api-member/is-can-code",
    "title": "是否可以生成二维码",
    "version": "1.0.0",
    "name": "_________",
    "group": "scanCode",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companyName",
            "description": "<p>公司名称</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get    /v1/api-member/is-can-code\n{\n   \"memberId\"      :  会员id\n   \"companyName\"   :  公司名称  //$companyName=\"maibu\"  迈步运动健身   $companyName = 'wayd'  “我爱运动瑜伽健身”\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>是否可以生成二维码 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/11/20</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/is-can-code"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",        //成功标识\n \"message\":\"数据录入成功\"    //数据录入成功\n \"data\": true                // 录入成功的信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"录入失败信息\"     //失败返回信息\n \"data\": false 或者 true\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "scanCode"
  },
  {
    "type": "post",
    "url": "/v1/api-member/save-member-message",
    "title": "是否可以保存会员信息",
    "version": "1.0.0",
    "name": "__________",
    "group": "scanCode",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>会员id      会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>会员性别 \t性别1:男2：女</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>会员姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "idCard",
            "description": "<p>身份证号</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post    v1/api-member/save-member-message\n  {\n     \"id\"     : 2    // 会员id\n     \"sex\"   :  1    //性别1:男2：女\n     \"name\"  :  王金林 // 会员姓名\n     \"idCard\":  4107821993202125   // 身份证号\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>是否可以保存会员信息 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/11/27</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/save-member-message"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,\n \"status\": \"success\",        //成功标识\n \"message\":\"数据录入成功\"    //数据录入成功\n \"data\": true                // 录入成功的信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"录入失败信息\"     //失败返回信息\n \"data\": false 或者 true\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "scanCode"
  },
  {
    "type": "GET",
    "url": "/v1/api-member-card/search-member-message",
    "title": "搜索会员信息",
    "version": "1.0.0",
    "name": "______",
    "group": "searchMember",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "memberId",
            "description": "<p>//会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET  /v1/api-member-card/search-member-message\n{\n     \"memberId\":12             //会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>搜索会员信息 <br/> <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/11/29</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/search-member-message"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n\"code\": 1,\n\"status\": \"success\",\n\"message\": \"请求成功\",\n\"data\": {\n\"name\": \"崔鹏\",\n\"sex\": \"1\",\n\"id_card\": \"410104198703050017\"\n}\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n     \" code\": 0,             //购买失败\n     \"status\": \"error\",      //失败标识\n     \"message\": \"购买失败\",  //失败信息\n     \"data\": []              //保存失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "searchMember"
  },
  {
    "type": "get",
    "url": "/v1/api-member-card/get-card-type",
    "title": "卡种类型",
    "version": "1.0.0",
    "name": "____",
    "group": "sellCardType",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member-card/get-card-type",
          "type": "json"
        }
      ]
    },
    "description": "<p>卡种详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/7</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/get-card-type"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n\"code\": 1,                               //成功标识\n\"status\": \"success\",                     //成功标识\n\"message\": \"请求成功\",                   //成功信息\n\"data\": [\n     {\n         \"id\": \"3\",                       //卡种类型id\n         \"type_name\": \"充值卡\"            //卡种类型名称\n     },\n     {\n         \"id\": \"1\",                        //卡种类型id\n          \"type_name\": \"时间卡\"            //卡种类型名称\n     },\n     {\n         \"id\": \"2\",                         //卡种类型id\n          \"type_name\": \"次卡\"               //卡种类型名称\n     },\n     {\n          \"id\": \"4\",                        //卡种类型id\n          \"type_name\": \"混合卡\"             //卡种类型名称\n     }\n     ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                                   //失败标识\n  \"status\": \"error\",                           //失败标识\n  \"message\": \"没有卡种类型\",                   //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "sellCardType"
  },
  {
    "type": "POST",
    "url": "/v1/api-member-card/set-member-card-info",
    "title": "购卡",
    "version": "1.0.0",
    "name": "__",
    "group": "sellCard",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "examples": [
        {
          "title": "请求参数",
          "content": "POST /v1/api-member-card/set-member-card-info\n{\n     \"memberId \":107             //卡种id\n     \"cardCategoryId\":2         //卡种id\n     \"amountMoney\":2000         //总金额\n     \"payMethod\":2              //1现金；2支付宝；3微信；4pos刷卡；\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>购卡 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/9</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/set-member-card-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n     \"code\": 1,              //成功标识\n     \"status\": \"success\",    //成功标识\n     \"data\": \"提交成功\"      //成功信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n     \" code\": 0,             //购买失败\n     \"status\": \"error\",      //失败标识\n     \"message\": \"购买失败\",  //失败信息\n     \"data\": []              //保存失败原因\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "sellCard"
  },
  {
    "type": "get",
    "url": "/v1/api-member-card/get-card-category",
    "title": "购卡列表",
    "version": "1.0.0",
    "name": "____",
    "group": "sellCard",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardTypeId",
            "description": "<p>卡种类型id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member-card/get-card-category\n{\n     \"venueId\":107               //场馆id\n     \"cardTypeId\":107            //卡种类型id\n      \"memberId\":1088            // 会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>购卡列表 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/6</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/get-card-category"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n\"code\": 1,                           //成功标识\n\"status\": \"success\",                 //成功状态\n\"message\": \"请求成功\",               //成功提示信息\n\"data\": [\n     {\n         \"id\": \"97\",                 //卡种id\n         \"card_name\": \"有效期3\",     //卡名称\n         \"type_name\": \"时间卡\",      //卡类型\n         \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/pic.png?e\",  //图片\n         \"price\": \"2498.00\",         //卡价格\n         \"validPeriod\": 250          //有效期（单位/天）\n     },\n     {\n         \"id\": \"98\",                 //卡种id\n         \"card_name\": \"混合卡\",      //卡名称\n         \"type_name\": \"混合卡\",      //卡类型\n         \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/pic.png?e\",  //图片\n         \"price\": \"1200.00\",         //卡价格\n         \"validPeriod\": 1100         //有效期（单位/天）\n     }\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                         //失败标识\n  \"status\": \"error\",                 //失败标识\n  \"message\": \"暂时没有可以售卖的卡\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "sellCard"
  },
  {
    "type": "get",
    "url": "/v1/api-member-card/get-class-package",
    "title": "套餐",
    "version": "1.0.0",
    "name": "__",
    "group": "sellCards",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardCategoryId",
            "description": "<p>卡种id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>套餐类型（class表示课程套餐，server表示服务套餐）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member-card/get-class-package\n{\n     \"cardCategoryId \":107             //卡种id\n     \"type\":\"class\"                    //class表示课程套餐，server表示服务套餐\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>卡种详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/6</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/get-class-package"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n\"code\": 1,                       //成功标识\n\"status\": \"success\",             //成功标识\n\"message\": \"请求成功\",           //成功信息\n\"data\": [\n  {\n     \"id\": \"19\",                 //卡种绑定表id\n     \"polymorphic_id\": \"11\",     //多态id(课种id或者服务id)\n     \"number\": \"-1\",             //-1表示每天课程每日节数不限 或者服务次数不限\n     \"courseId\": \"11\",           //课种表id\n     \"name\": \"团A\"               //课程名称\n  },\n  {\n     \"id\": \"20\",                 //卡种绑定表id\n     \"polymorphic_id\": \"13\",     //多态id(课种或者服务id)\n     \"number\": \"22\",             //课程：每日的节数（服务：每日次数）\n     \"courseId\": \"13\",           //课种id\n     \"name\": \"团B\"               //课种名称\n  }\n]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                         //失败标识\n  \"status\": \"error\",                 //失败标识\n  \"message\": \"获取信息失败\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "sellCards"
  },
  {
    "type": "get",
    "url": "/v1/api-member-card/get-card-category-detail",
    "title": "卡种详情",
    "version": "1.0.0",
    "name": "____",
    "group": "sellCards",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "cardCategoryId",
            "description": "<p>卡种id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-member-card/get-card-category-detail\n{\n     \"cardCategoryId \":107             //卡种id\n     \"memberId\"      :90040            // 会员id\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>卡种详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/6</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member-card/get-card-category-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n \"code\": 1,                              //成功标识\n \"status\": \"success\",                    //成功标识\n \"message\": \"请求成功\",                  //成功信息\n \"data\": {\n     \"id\": \"3\",                          //卡种id\n     \"card_name\": \"测试卡种专属\",        //卡种名称\n     \"attributes\": \"家庭\",               //卡种属性\n     \"transfer_number\": 10,              //转让次数\n     \"transfer_price\": 100,              //转让金额\n     \"type_name\": \"时间卡\",              //卡种类型\n     \"validPeriod\": 100,                 //有效天数\n     \"price\": \"1000.00\",                 //金额\n     \"totalDay\": 100,                    //请假总天数\n     \"leastDay\": 10,                     //最少请假天数\n     \"shopVenue\": \"大上海馆/大卫城馆/大学路馆\"   //通店场馆\n }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "｛\n  \"code\": 0,                         //失败标识\n  \"status\": \"error\",                 //失败标识\n  \"message\": \"获取详细信息失败\", //失败原因\n｝",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberCardController.php",
    "groupTitle": "sellCards"
  },
  {
    "type": "get",
    "url": "/v1/api-private/set-member-class-info",
    "title": "买课",
    "version": "1.0.0",
    "name": "__",
    "group": "sellClass",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "chargeId",
            "description": "<p>产品id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "amountMoney",
            "description": "<p>金额</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "nodeNumber",
            "description": "<p>课程节数（或者套餐数量）</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "payMethod",
            "description": "<p>//1现金；2支付宝；3微信；4pos刷卡；</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-private/set-member-class-info\n{\n     \"memberId\":10            //会员id\n     \"chargeId\":10            //产品id\n     \"amountMoney\":10         //金额\n     \"nodeNumber\":10          //课程节数（或者套餐数量）\n     \"payMethod\":2           ////1现金；2支付宝；3微信；4pos刷卡；\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>买课 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/7/11</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-private/set-member-class-info"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": "{\n \"code\": 1,              //成功标识\n \"status\": \"success\",    //成功标识\n \"message\": \"购买成功\"   //成功信息\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,             //失败标识\n  \"status\": \"error\",     //失败标识\n  \"message\": \"购买失败\", //失败信息\n  \"data\": []             //空数组表示，失败原因不是save()报的错\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiPrivateController.php",
    "groupTitle": "sellClass"
  },
  {
    "type": "post",
    "url": "/v1/api-member/user-statics",
    "title": "用户活跃统计",
    "version": "1.0.0",
    "name": "______",
    "group": "userStatics",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "deviceNumber",
            "description": "<p>设备编号</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "theRequestPage",
            "description": "<p>求页面类型 0:下载安装 1:团课列表 2:私教列表 3:团课详情 4:私课详情</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "deviceType",
            "description": "<p>设备类型</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "venueId",
            "description": "<p>场馆id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "companySign",
            "description": "<p>公司标识    mb：迈步  wayd：我爱运动</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "memberId",
            "description": "<p>会员id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "post   /v1/api-member/user-statics   用户活跃统计\n  {\n     \"deviceNumber\"  :    62837t128         设备编号\n     \"theRequestPage\"   : 1                 求页面类型 0:下载安装 1:团课列表 2:私教列表 3:团课详情 4:私课详情\n     \"deviceType\"    : 1                 1:安卓 2:ios\n     \"venueId\"      :  1                 场馆id\n     \"companySign\"  : mb                 公司标识\n     \"memberId\": 2235                     会员id\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>用户活跃统计 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>侯凯新@itsprts.club <span><strong>创建时间：</strong></span>2017/01/03</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/user-statics"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n   \"code\": 1,                 //参数传入是否合法\n   \"status\": \"success\",       //成功状态\n   \"message\": \"成功\",         //成功状态\n  \"data\": [\n      {\n      }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n\"code\": 0,                             //参数传入是否合法\n\"status\": \"error\",                     //错误状态\n\"message\": \"您还不是会员，请注册！\",\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "userStatics"
  },
  {
    "type": "get",
    "url": "/v1/api-venue/get-venue-detail",
    "title": "场馆详情",
    "version": "1.0.0",
    "name": "____",
    "group": "venue",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>场馆id或者公司id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型（ios）</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "GET /v1/api-venue/get-venue-detail\n{\n     \"id\":1,                 // 场馆id或者公司id\n     \"requestType\":\"ios\"     //请求类型是ios\n}",
          "type": "json"
        }
      ]
    },
    "description": "<p>获取场馆详情 <br/> <span><strong>作    者：</strong></span>黄鹏举<br/> <span><strong>邮    箱：</strong></span>huangpengju@itsprts.club <span><strong>创建时间：</strong></span>2017/6/17</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-venue/get-venue-detail"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情（成功）",
          "content": " {\n   \"code\": 1,                        //成功标识（ios需要的zi）\n   \"status\": \"success\",              //成共状态\n   \"message\": \"请求成功\",            //成功信息\n   \"data\": {\n     \"id\": \"2\",                      //场馆id\n     \"pid\": \"1\",                     //父id(公司id)\n     \"name\": \"大上海\",               //场馆名称\n     \"style\": \"2\",                   //1.公司，2.场馆，3.部门\n     \"area\": \"2000\",                 //场馆面积\n     \"establish_time\":'147554754110',//场馆成立时间，时间戳格式\n     \"address\": \"12\",                //场馆地址\n     \"venueAddress\": \"12\",           //场馆地址(和address一样，只是字段名为了和其他接口保持一致)\n     \"phone\": \"121212\",              //场馆电话\n     \"describe\": \"zhe shasdf asd \",  //场馆描述\n     \"pic\": \"http://oo0oj2qmr.bkt.clouddn.com/5.jpg?\", //场馆图片\n     \"businessHours\": \"8:00 - 21:30\", //场馆营业时间\n     \"longitude\": \"113.676957\",      // 场馆精度\n     \"latitude\":\"113.676957\"         // 场馆维度\n     \"score\": 4                       //场馆级别\n   }\n}",
          "type": "json"
        },
        {
          "title": "返回值详情（失败）",
          "content": "{\n  \"code\": 0,                             //失败标识\n  \"status\": \"error\",                     //失败标识\n  \"message\": \"获取场馆详细信息失败\"      //提示信息\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiVenueController.php",
    "groupTitle": "venue"
  },
  {
    "type": "get",
    "url": "/v1/api-member/send",
    "title": "app版本是否更新",
    "version": "1.0.0",
    "name": "app______",
    "group": "version",
    "permission": [
      {
        "name": "管理员"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "versionCode",
            "description": "<p>版本号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "requestType",
            "description": "<p>请求类型  安卓:android  苹果 ios</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "venueName",
            "description": "<p>WAYD  代表我爱运动  其它 迈步</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "请求参数",
          "content": "get    /v1/api-member/send\n  {\n     \"versionCode\"     : 2           // 版本号\n     \"requestType\"     :  android    //性别  android：代表安卓  ios 代表ios\n     \"venueName\"       : WAYD        // 场馆名称  WAYD：我爱运动  MB:迈步\n  }",
          "type": "json"
        }
      ]
    },
    "description": "<p>app版本是否更新 <span><strong>作    者：</strong></span>侯凯新<br/> <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club <span><strong>创建时间：</strong></span>2017/11/30</p>",
    "sampleRequest": [
      {
        "url": "http://qa.aixingfu.net/v1/api-member/send"
      }
    ],
    "success": {
      "fields": {
        "返回值": [
          {
            "group": "返回值",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "返回值详情(成功时)",
          "content": "{\n\"code\": 1,\n\"status\": \"success\",\n\"message\": \"app必须更新\",\n\"url\": \"/opt/lampp/htdocs/cloudsports/backend\\\\web\\\\ios\\\\I Love Sportsandroid.apk\",\n\"update\": true,\n\"isMustUpdate\": true\n\"file\":true  // true文件存在  false:文件不存在\n}",
          "type": "json"
        },
        {
          "title": "返回值详情(失败时)",
          "content": "{\n \"code\": 0,\n \"status\": \"error\",      //失败标识\n \"message\":\"录入失败信息\"     //失败返回信息\n \"data\": false 或者 true\n}",
          "type": "json"
        }
      ]
    },
    "filename": "backend/modules/v1/controllers/ApiMemberController.php",
    "groupTitle": "version"
  }
] });
