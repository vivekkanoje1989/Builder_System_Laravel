<div class="row" ng-controller="hrController" ng-init="roleType([[$empId]])">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>User Permissions</h5>
        </div>                  
        <div class="">
            <div class="col-lg-12 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-sm-6 col-lg-2">
                        <div class="form-group">
                            <span>
                                <label>Role type</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="control-group">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio"  ng-model="roleData.roleType" name="roleType" value="0" class="colored-blue">
                                                    <span class="text">Custom </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio"  ng-model="roleData.roleType" name="roleType" value="1" class="colored-blue" >
                                                <span class="text">Role wise</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div ng-show='roleData.roleType == 1' class="col-sm-6 col-lg-2">
                        <div class="form-group">
                            <label>Role</label>
                            <span class="input-icon icon-right">                                
                                <select class="form-control" ng-model="roleData.roleId" name="roleId" ng-init="manageRoles()" ng-change="updatePermissions([[ $empId ]],roleData.roleId)">
                                    <option value="">Select Role</option>
                                    <option ng-repeat="list in roleList track by $index" value="{{list.id}}">{{list.role_name}}</option>  
                                </select>
                                <i class="fa fa-sort-desc"></i>                 
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-2" align="right"><div class="form-group"><span class="input-icon icon-right">Total Permissions: {{totalPermissions}}</span></div></div>
                </div>
                <div class="widget">
                    <div class="widget-body no-padding">
                        <div class="widget-main ">
                            <div class="panel-group accordion" id="accordion" ng-init="userPermissions('employee',[[ $empId ]])">
                                <div class="panel panel-default" ng-repeat="parent in menuItems track by $index">
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
                                                    <li ng-if='parent.total_submenu == 1' ng-repeat="child1 in parent.submenu">
                                                        <label>
                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child1_{{child1.id}}',[],[{{child1.id}}],[{{ child1.submenu_ids}}], [])">
                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ child1.name }}</span>
                                                        </label>
                                                    </li>
                                                    <li ng-if='parent.total_submenu != 1' ng-repeat="child1 in parent.submenu">
                                                        <label>
                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child1_{{child1.id}}',[],[{{child1.id}}],[{{ child1.submenu_ids}}], [])">
<!--                                                            <input class="checkbox-slider slider-icon" type="checkbox" ng-if='child1.total_submenu == 1' data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child1_{{child1.id}}',[],[{{child1.id}}])">
                                                            <input class="checkbox-slider slider-icon" type="checkbox" ng-if='child1.total_submenu != 1' data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child1_{{child1.id}}',[{{child1.id}}],[{{ child1.submenu_ids }}])">-->
                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ child1.name }}</span>
                                                        </label>
                                                        <ul class="acc-bord" style="list-style-type: none;" ng-if='child1.total_submenu == 1'>
                                                            <li ng-repeat="child2 in child1.submenu">
                                                                <label>
                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" id="child2_{{child2.id}}" ng-checked="{{child2.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}],[{{ child1.submenu_ids}}], [])">
                                                                    <span class="text"> &nbsp;&nbsp;&nbsp; {{ child2.name }}</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        <ul class="acc-bord" style="list-style-type: none;" ng-if='child1.total_submenu != 1'>    
                                                            <li ng-repeat="child2 in child1.submenu">
                                                                <label>
                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}],[{{ child1.submenu_ids}}], [])">
<!--                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" ng-if='child2.total_submenu == 1' id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}])">
                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" ng-if='child2.total_submenu != 1' id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child2_{{child2.id}}',[{{child1.id}},{{child2.id}}],[{{ child2.submenu_ids }}])">-->
                                                                    <span class="text"> &nbsp;&nbsp;&nbsp; {{ child2.name }}</span>
                                                                </label>
                                                                <ul class="acc-bord" style="list-style-type: none;" ng-if='child2.total_submenu == 1'>    
                                                                    <li ng-repeat="child3 in child2.submenu">
                                                                        <label>
                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" id="child3_{{child3.id}}" ng-checked="{{child3.checked}}" data-level="third" ng-click="accessControl('employee',[[ $empId ]],'child2_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}],[{{ child1.submenu_ids}}],[{{ child2.submenu_ids}}])">
                                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ child3.name }}</span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                                <ul class="acc-bord" style="list-style-type: none;" ng-if='child2.total_submenu != 1'> 
                                                                    <li ng-repeat="child3 in child2.submenu">
                                                                        <label>
                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child3_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}],[{{ child1.submenu_ids}}],[{{ child2.submenu_ids}}])">
<!--                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" ng-if='child3.total_submenu == 1' id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child3_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}])">
                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" ng-if='child3.total_submenu != 1' id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="accessControl('employee',[[ $empId ]],'child3_{{child3.id}}',[{{child1.id}},{{child2.id}},{{child3.id}}],[{{ child3.submenu_ids }}])">-->
                                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ child3.name }}</span>
                                                                        </label>
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