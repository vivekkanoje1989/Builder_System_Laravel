<div class="row" ng-controller="extensionemployeeController" ng-init="manageExtEmpLists('', 'index')">

    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Extension Employees</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" style="width:25%;" class="form-control">
                    </div>
                    <div>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#addExtensionModal" ng-click="initExtensionModal(ct_employee_extlist)"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Add New Extension</a>
                    </div>
                </div><br>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>
                            <th style="width:7%">Employee Name</th>
                            <th style="width:7%">Extension Number</th>
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="listNumber in ct_employee_extlist | filter:search | itemsPerPage:itemsPerPage">
                            <td>{{ $index + 1}}</td>
                            <td>{{ listNumber.first_name}}&nbsp;{{ listNumber.last_name}} ( {{listNumber.designation}} )</td>
                            <td>Extension &nbsp;{{listNumber.extension_no}}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="javascript:void(0)" data-toggle="modal"  data-target="#addExtensionModal" ng-click="editExtensionModal(ct_employee_extlist,listNumber)"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"  ng-show="(listNumbers|filter:search).length == 0" align="center">Record Not Found</td>   
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to {{ itemsPerPage}} of {{ listNumbersLength}} entries</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>

                <!-- Model -->
                <div class="modal fade" id="addExtensionModal" role="dialog" tabindex='-1'>
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header navbar-inner">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center">Add Extension</h4>
                            </div>
                                <form novalidate style="margin-left: 10%;" role="form" name="extensionForm" ng-submit="extensionForm.$valid && createExtension(extensionData)">
                                <div class="row">
                                        <div class="col-sm-5">
<!--                                            <div class="form-group" >
                                                <label for="">Select Employee</label>                            
                                                <ui-select  ng-model="extensionData.ext_employee" name="ext_employee" theme="bootstrap">
                                                        <ui-select-match placeholder="Select Employee">{{extensionData.ext_employee.first_name}}</ui-select-match>
                                                        <ui-select-choices repeat="item in ext_employee | filter: $select.search">
                                                            <div ng-bind-html="item.first_name | highlight: $select.search"></div>
                                                        </ui-select-choices>
                                                    </ui-select>
                                            
                                            
                                            </div>-->
                                                
                                                <div class="form-group" >
                                                    <label for="">Select Employee</label>   
                                                    <select class="form-control"  ng-model="extensionData.employee_id" name="employee_id" id="employee_id" required="">
                                                            <option value="">Select Employee</option>
                                                            <option ng-repeat="item in ext_employee" value="{{item.id}}" ng-selected="{{ item.id == extensionData.employee_id}}" >{{item.first_name}}&nbsp;({{item.designation}})</option>
                                                        </select>
                                                    <div ng-show="sbtBtn" ng-messages="extensionForm.employee_id.$error" class="help-block errMsg">
                                                        <div style="color: red" ng-message="required">This field is required</div>
                                                        </div>
                                                </div>
                                            
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="">Extension Number</label>
                                                <select multiple="" class="form-control"  ng-model="extensionData.extension_no" name="extension_no" id="extension_no" required="">
                                                        <option value="">Select Extension</option>
                                                        <option ng-repeat="item in ext_number" value="{{item}}" ng-selected="{{ item == extensionData.extension_no}}">Extension&nbsp;{{item}}</option>
                                                    </select>
                                                <div ng-show="sbtBtn" ng-messages="extensionForm.extension_no.$error" class="help-block errMsg">
                                                            <div style="color: red" ng-message="required">This field is required</div>
                                                        </div>
                                            </div>
                                        </div>
                                    <div  class="col-sm-5" >
                                        <button style="margin-left: 95%;"type="submit" ng-click="sbtBtn = true" ng-disabled="btnSubmit" class="btn btn-primary custom-btn">{{btnlable}}</button>
                                        </div>
                                    </div>
                                    <div class="modal-footer" align="center">
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Model -->
                </div>
            </div>
        </div>
    </div>


