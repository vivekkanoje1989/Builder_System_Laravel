<div class="row" ng-controller="hrController">
    <div class="widget flat radius-bordered ">
        <form name="RoleForm" novalidate ng-submit="RoleForm.$valid && createRole(RoleData)">
            <input type="hidden" ng-model="RoleForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="RoleForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
            <input type="hidden" name="id" id="id" ng-model="RoleData.id">
            
            <div id="registration-form">
                <div class="">
                    <div class="col-sm-4 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for=""> Define  Role Name <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="RoleData.role_name" name="role_name"  maxlength="20" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" class="form-control" required>
                                <div ng-show="sbt" ng-messages="RoleForm.role_name.$error" class="help-block">
                                    <div ng-message="required" class="sp-err">Please enter define role name. </div>
                                </div>

                            </span>                                
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="col-lg-12 col-sm-6 col-xs-12">
                        <div class="widget">
                            <div class="widget-body no-padding">
                                <div class="widget-main ">
                                    <div class="panel-group accordion" id="accordion" ng-init="userPermissions('roles','0')">
                                        <div class="panel panel-default" ng-repeat="parent in menuItems">
                                            <div class="panel-heading ">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" target="_self" href="#{{ parent.slug}}">
                                                        <i class="fa fa-caret-right themeprimary"></i> {{ parent.name}}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="{{ parent.slug}}" class="panel-collapse collapse" ng-class="parent.slug == 'dashboard' ? 'in' : ''" >
                                                <div class="panel-body border-red">
                                                    <div  class="col-md-12 col-xs-12">
                                                        <ul class="acc-bord" style="list-style-type: none;" >
                                                            <li ng-if='parent.total_submenu == 1' ng-repeat="child1 in parent.submenu">
                                                                <label>
                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="addRolePermissions('roles', 'child1_{{child1.id}}', [],[{{child1.id}}])">
                                                                    <span class="text"> &nbsp;&nbsp;&nbsp; {{ child1.name}}</span>
                                                                </label>
                                                            </li>
                                                            <li ng-if='parent.total_submenu !== 1' ng-repeat="child1 in parent.submenu">
                                                                <label>
                                                                    <input class="checkbox-slider slider-icon" type="checkbox" ng-if='child1.total_submenu == 1' data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="addRolePermissions('roles', 'child1_{{child1.id}}', [],[{{child1.id}}])">
                                                                    <input class="checkbox-slider slider-icon" type="checkbox" ng-if='child1.total_submenu != 1' data-level="first" id="child1_{{child1.id}}" ng-checked="{{child1.checked}}" ng-click="addRolePermissions('roles', 'child1_{{child1.id}}',[{{child1.id}}],[{{ child1.submenu_ids}}])">
                                                                    <span class="text"> &nbsp;&nbsp;&nbsp; {{ child1.name}}</span>
                                                                </label>
                                                                <ul class="acc-bord" style="list-style-type: none;" ng-if='child1.total_submenu == 1'>
                                                                    <li ng-repeat="child2 in child1.submenu">
                                                                        <label>
                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" id="child2_{{child2.id}}" ng-checked="{{child2.checked}}" ng-click="addRolePermissions('roles', 'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}])">
                                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ child2.name}} {{child2.id}}</span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                                <ul class="acc-bord" style="list-style-type: none;" ng-if='child1.total_submenu !== 1'>    
                                                                    <li ng-repeat="child2 in child1.submenu">
                                                                        <label>
                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" ng-if='child2.total_submenu == 1' id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="addRolePermissions('roles', 'child2_{{child2.id}}',[{{child1.id}}],[{{child2.id}}])">
                                                                            <input class="checkbox-slider slider-icon" type="checkbox" data-level="second" ng-if='child2.total_submenu != 1' id="child2_{{child2.id}}" data-level="second" ng-checked="{{child2.checked}}" ng-click="addRolePermissions('roles', 'child2_{{child2.id}}',[{{child1.id}},{{child2.id}}],[{{ child2.submenu_ids}}])">
                                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ child2.name}}</span>
                                                                        </label>
                                                                        <ul class="acc-bord" style="list-style-type: none;" ng-if='child2.total_submenu == 1'>    
                                                                            <li ng-repeat="child3 in child2.submenu">
                                                                                <label>
                                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" id="child3_{{child3.id}}" ng-checked="{{child3.checked}}" data-level="third" ng-click="addRolePermissions('roles', 'child2_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}])">
                                                                                    <span class="text"> &nbsp;&nbsp;&nbsp; {{ child3.name}}</span>
                                                                                </label>
                                                                            </li>
                                                                        </ul>
                                                                        <ul class="acc-bord" style="list-style-type: none;" ng-if='child2.total_submenu !== 1'> 
                                                                            <li ng-repeat="child3 in child2.submenu">
                                                                                <label>
                                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" ng-if='child3.total_submenu == 1' id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="addRolePermissions('roles', 'child3_{{child3.id}}',[{{child1.id}},{{child2.id}}],[{{child3.id}}])">
                                                                                    <input class="checkbox-slider slider-icon" type="checkbox" data-level="third" ng-if='child3.total_submenu != 1' id="child3_{{child3.id}}" data-level="third" ng-checked="{{child3.checked}}" ng-click="addRolePermissions('roles', 'child3_{{child3.id}}',[{{child1.id}},{{child2.id}},{{child3.id}}],[{{ child3.submenu_ids}}])">
                                                                                    <span class="text"> &nbsp;&nbsp;&nbsp; {{ child3.name}}</span>
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
                <div class="col-md-12 col-xs-12" style="margin-bottom: 50px;">
                    <button type="submit" class="btn btn-primary" ng-click="sbt = true">Submit</button>
                </div>
            </div>
        </form>
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