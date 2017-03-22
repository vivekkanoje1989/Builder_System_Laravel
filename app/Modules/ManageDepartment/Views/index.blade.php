<div class="row" ng-controller="manageDepartmentCtrl" ng-init="manageDepartment()">  
<div>
          <flash-message duration="5000"></flash-message>
</div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Department</span>
                <a href="" data-toggle="modal" data-target="#departmentModal" ng-click="initialModal(0,'','')" class="btn btn-info">Create New Department</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">                
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <tr>
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='id'; reverseSort = !reverseSort">SR No.
                              <span ng-show="orderByField == 'id'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th>                       
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'department_name'; reverseSort = !reverseSort">Department
                                <span ng-show="orderByField == 'department_name'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th>                            
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="list in departmentRow| filter:search |orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{$index + 1}}</td>
                            <td>{{ list.department_name}}</td>                          
                             <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit department" style="display: block;" data-toggle="modal" data-target="#departmentModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{list.department_name}}',$index)"><i class="fa fa-pencil"></i></a></div>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="departmentModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="departmentForm.$valid && dodepartmentAction()" name="departmentForm">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!departmentForm.department_name.$dirty && departmentForm.department_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="department_name" name="department_name" placeholder="Department" ng-change="errorMsg = null" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="departmentForm.department_name.$error">
                                    <div ng-message="required">Department is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
</div>

