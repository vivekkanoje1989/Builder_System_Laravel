<style>
    .alert.alert-info{
        width: auto;
        margin-right: 5px;
    }
    .accordion.panel-group .panel .collapse {
        background-color: transparent !important;
    }
    .close {
        text-shadow: none; 
        opacity: 1; 
        color: #000;
    }
    .close:focus, .close:hover {
        color: #000;
        opacity: 1; 
    }
</style>
<div class="row" ng-controller="hrController" ng-init="showPermissions()">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Permission Wise Users</h5>
        </div>
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="widget">
                <div class="widget-body no-padding">
                    <div class="widget-main ">
                        <div class="panel-group accordion" id="accordion">
                            <div class="panel panel-default" ng-repeat="parent in menuItems">
                                <div class="panel-heading ">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" target="_self" href="#{{ parent.slug }}">
                                           <i class="fa fa-caret-right themeprimary"></i> {{ parent.name }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="{{ parent.slug }}" class="panel-collapse collapse" ng-class="parent.slug == 'dashboard' ? 'in' : ''" >
                                    <div class="panel-body border-red">
                                        <div  class="col-md-12 col-xs-12">
                                            <ul class="acc-bord" style="list-style-type: none;" >
                                                <li ng-if='parent.total_submenu == 1' ng-repeat="child1 in parent.submenu" class="accordion-toggle">
                                                    <label data-toggle="collapse" data-target="#{{child1.id}}">
                                                        <span class="text"> &nbsp;&nbsp;&nbsp; {{ child1.name }}</span>
                                                    </label>
                                                    <div class="accordian-body collapse row" id="{{child1.id}}">                                                         
                                                        <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key, value) in child1.emp"> 
                                                            <a href class="close" ng-click="removeEmpID(key,[],[{{child1.id}}],[{{ child1.submenu_ids}}],[]);" data-dismiss="alert"> ×</a>
                                                            <strong class="ng-binding ng-scope">{{value | split:'-':0}}</strong><br/>
                                                            <div style="font-size: 10px;text-align: center;">({{ value | split:'-':1 }})</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li ng-if='parent.total_submenu !== 1' ng-repeat="child1 in parent.submenu" class="accordion-toggle">
                                                    <label data-toggle="collapse" data-target="#{{child1.id}}">
                                                        <span class="text"> &nbsp;&nbsp;&nbsp; {{ child1.name }}</span>
                                                    </label>
                                                    <div class="accordian-body collapse row" id="{{child1.id}}" ng-if='child1.total_submenu == 1 && !child1.has_submenu'>                                                         
                                                        <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key, value) in child1.emp"> 
                                                            <a href class="close" ng-if='child1.total_submenu == 1' ng-click="removeEmpID(key,[],[{{child1.id}}],[{{ child1.submenu_ids}}],[]);" data-dismiss="alert"> ×</a>
                                                            <strong class="ng-binding ng-scope">{{value | split:'-':0}}</strong><br/>
                                                            <div style="font-size: 10px;text-align: center;">({{ value | split:'-':1 }})</div>
                                                        </div>
                                                    </div>
                                                    <ul class="acc-bord" style="list-style-type: none;" ng-if='child1.total_submenu == 1'>
                                                        <li ng-repeat="child2 in child1.submenu" class="accordion-toggle">
                                                            <label data-toggle="collapse" data-target="#{{child2.id}}">
                                                                <span class="text"> &nbsp;&nbsp;&nbsp; {{ child2.name }}</span>
                                                            </label>
                                                            <div class="accordian-body collapse row" id="{{child2.id}}">                                                         
                                                                <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key, value) in child2.emp"> 
                                                                    <a href class="close" ng-click="removeEmpID(key,[{{child1.id}}],[{{child2.id}}],[{{ child1.submenu_ids}}],[]);" data-dismiss="alert"> ×</a>
                                                                    <strong class="ng-binding ng-scope">{{value | split:'-':0}}</strong><br/>
                                                                    <div style="font-size: 10px;text-align: center;">({{ value | split:'-':1 }})</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <ul class="acc-bord" style="list-style-type: none;" ng-if='child1.total_submenu !== 1'>    
                                                        <li ng-repeat="child2 in child1.submenu" class="accordion-toggle">
                                                            <label data-toggle="collapse" data-target="#{{child2.id}}">
                                                                <span class="text"> &nbsp;&nbsp;&nbsp; {{ child2.name }}</span>
                                                            </label>
                                                            <div class="accordian-body collapse row" id="{{child2.id}}" ng-if='child2.total_submenu == 1 && !child2.has_submenu'>                                                         
                                                                <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key, value) in child2.emp"> 
                                                                    <a href class="close" ng-if='child2.total_submenu == 1' ng-click="removeEmpID(key,[{{child1.id}}],[{{child2.id}}],[{{ child1.submenu_ids}}],[]);" data-dismiss="alert"> ×</a>
                                                                    <strong class="ng-binding ng-scope">{{value | split:'-':0}}</strong><br/>
                                                                    <div style="font-size: 10px;text-align: center;">({{ value | split:'-':1 }})</div>
                                                                </div>
                                                            </div>
                                                            <ul class="acc-bord" style="list-style-type: none;" ng-if='child2.total_submenu == 1'>    
                                                                <li ng-repeat="child3 in child2.submenu" class="accordion-toggle">
                                                                    <label data-toggle="collapse" data-target="#{{child3.id}}">
                                                                        <span class="text"> &nbsp;&nbsp;&nbsp; {{ child3.name }}</span>
                                                                    </label>
                                                                    <div class="accordian-body collapse row" id="{{child3.id}}" ng-if='child3.total_submenu == 1 && !child3.has_submenu'>
                                                                        <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key, value) in child3.emp"> 
                                                                            <a href class="close" ng-click="removeEmpID(key,[{{child1.id}},{{child2.id}}],[{{child3.id}}],[{{ child1.submenu_ids}}],[{{ child2.submenu_ids}}]);" data-dismiss="alert"> ×</a>
                                                                            <strong class="ng-binding ng-scope">{{value | split:'-':0}}</strong><br/>
                                                                            <div style="font-size: 10px;text-align: center;">({{ value | split:'-':1 }})</div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <ul class="acc-bord" style="list-style-type: none;" ng-if='child2.total_submenu !== 1'> 
                                                                <li ng-repeat="child3 in child2.submenu" class="accordion-toggle">
                                                                    <label data-toggle="collapse" data-target="#{{child3.id}}">
                                                                        <span class="text"> &nbsp;&nbsp;&nbsp; {{ child3.name }}</span>
                                                                    </label>
                                                                    <div class="accordian-body collapse row" id="{{child3.id}}">                                                         
                                                                        <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key, value) in child3.emp"> 
                                                                            <a href class="close" ng-if='child3.total_submenu == 1' ng-click="removeEmpID(key,[{{child1.id}},{{child2.id}}],[{{child3.id}}],[{{ child1.submenu_ids}}],[{{ child2.submenu_ids}}]);" data-dismiss="alert"> ×</a>
                                                                            <strong class="ng-binding ng-scope">{{value | split:'-':0}}</strong><br/>
                                                                            <div style="font-size: 10px;text-align: center;">({{ value | split:'-':1 }})</div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .acc-bord{
        border-left: 1px dotted #999;
    }   
    .acc-bord label {
        line-height: 40px;    
    }
    .text{cursor: pointer;}
    input[type=checkbox], input[type=radio]{
        cursor: default !important;
    }
</style>