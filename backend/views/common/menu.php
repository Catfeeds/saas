<!--左侧导航开始-->

    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <i class="fa fa-area-chart"></i>
                                        <strong class="font-bold">云运动</strong>
                                    </span>
                                </span>
                    </a>
                </div>
                <div class="logo-element">云运动
                </div>
            </li>
            <li class="hidden-folded padder m-t m-b-sm text-muted text-xs" style="margin-left: 8px;">
                <span class="ng-scope">我爱运动</span>
            </li>
            <li class="hidden-folded padder m-t m-b-sm text-muted text-xs " style="margin-left: 0;" ng-repeat="menuItem in menuItems">
                <a href="#">
                    <i class="glyphicon glyphicon-home"></i>
                    <span class="nav-label" style="font-size: 12px">{{menuItem.name}}</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse in" aria-expanded="true">
                        <li class="" ng-repeat="module in menuItem.module">
                            <a href="{{module.url}}">
                                <i class="glyphicon glyphicon-cog"></i>
                                <span class="nav-label">{{module.name}}</span>
                            </a>
                        </li>
                </ul>
            </li>
            <li class="lines dk"></li>
        </ul>
    </div>