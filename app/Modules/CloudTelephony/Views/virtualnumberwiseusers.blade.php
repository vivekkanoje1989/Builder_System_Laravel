<style>
    .alert.alert-info{
        width: auto;
        margin-right: 5px;
    }
    .accordion.panel-group .panel .collapse {
        background-color: transparent !important;
    }
    .close {
        opacity: 1 !important;
    }

    .close:focus, .close:hover {
        color: #000;
        opacity: 1; 
    }
</style>
<div class="row" ng-controller="cloudtelephonyController" ng-init="showvirtualnumusers()">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Virtual Number Wise Users</h5>
        </div>
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="widget">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <label>Employees</label>
                        <div class="form-group">
                            <span class="input-icon icon-right" ng-controller="employeesCtrl">
                                <select ng-model="registrationData.emp_id" name="emp_id" id="emp_id" class="form-control" ng-change="filterVNumbers(registrationData.emp_id)">
                                    <option value="">Select employee to filter numbers</option>
                                    <option ng-repeat="emp in employeeList track by $index" value="{{ emp.id }}">{{ emp.first_name }} {{ emp.last_name }}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="widget-body no-padding">
                    <div class="widget-main">
                        <div class="panel-group accordion" id="accordion">
                            <div class="panel panel-default" ng-repeat="(key,value) in virtualnumList">
                                <div class="panel-heading ">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed {{ key | split:' ':0}}" data-toggle="collapse" data-parent="#accordion" target="_self" href="#{{ key | split:' ':0}}">
                                           <i class="fa fa-caret-right themeprimary"></i> {{ key | split:'_':1}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="{{ key | split:' ':0}}" class="panel-collapse collapse" >
                                    <div class="panel-body border-red">
                                        <div  class="col-md-12 col-xs-12">
                                            <ul class="acc-bord" style="list-style-type: none;" >
                                                <li ng-if='value != ""' ng-repeat="(key1,value1) in value" class="accordion-toggle secondlevel {{ key | split:' ':0}}">
                                                    <div ng-repeat="(key2,value2) in value1">
                                                        <label data-toggle="collapse" data-target="#{{key | split:' ':0}}_{{key1}}_{{key2 | split:'_':1 | underscore:' '}}">
                                                            <span class="text"> &nbsp;&nbsp;&nbsp; {{ key2 | split:'_':1}}</span>
                                                        </label>
                                                        <div class="accordian-body collapse row" id="{{key | split:' ':0}}_{{key1}}_{{key2 | split:'_':1 | underscore:' '}}">                                                         
                                                            <div class="col-sm-1 alert alert-info fade in" ng-repeat="(key3, value3) in value2">
                                                                <div ng-if="empId != ''">
                                                                    <a href class="close" ng-click="removeEmpID({{ key | split:'_':0}},{{key3}},'','defaultEmp')" data-dismiss="alert" ng-if="(key2 == '_Employees' || key2 == '_Default Employee') && checkLength(value2) > 1 && empId == key3"> × </a>
                                                                    <a href class="close" ng-click="removeEmpID({{ key | split:'_':0}},{{key3}},'{{ key2 | split:'_':0}}','extension')" data-dismiss="alert" ng-if="(key2 != '_Employees' && key2 != '_Default Employee') && (key3 | split:'_':0) != 'extDefault' && checkLength(value2) > 1 && empId == key3"> × </a>
                                                                </div>
                                                                <div ng-if="empId == ''">
                                                                <a href class="close" ng-click="removeEmpID({{ key | split:'_':0}},{{key3}},'','defaultEmp')" data-dismiss="alert" ng-if="(key2 == '_Employees' || key2 == '_Default Employee') && checkLength(value2) > 1"> × </a>
                                                                <a href class="close" ng-click="removeEmpID({{ key | split:'_':0}},{{key3}},'{{ key2 | split:'_':0}}','extension')" data-dismiss="alert" ng-if="(key2 != '_Employees' && key2 != '_Default Employee') && (key3 | split:'_':0) != 'extDefault' && checkLength(value2) > 1"> × </a>
                                                                </div>
                                                                <strong class="ng-binding ng-scope">{{value3 | split:'_':0}}</strong><br/>
                                                                <div style="font-size: 10px;text-align: center;">{{ value3 | split:'_':1 }}</div>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
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