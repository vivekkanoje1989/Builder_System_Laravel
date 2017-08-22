<div class="row" ng-controller="extensionemployeeController" ng-init="manageExtEmpLists('', 'index')">
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Employees Extensions</span>
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="search" name="search" class="form-control">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a href data-toggle="modal" data-target="#addExtensionModal" ng-click="initExtensionModal(ct_employee_extlist)" class="btn btn-primary btn-right">Add New Extension</a>
                            </span>
                        </div>
                    </div>
                </div><hr>
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
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;"><a href="javascript:void(0)" data-toggle="modal"  data-target="#addExtensionModal" ng-click="editExtensionModal(ct_employee_extlist, listNumber)"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;</div>
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
                            <form novalidate role="form" name="extensionForm" ng-submit="extensionForm.$valid && createExtension(extensionData)">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <div class="">
                                            <div class="col-sm-5">
                                                <div class="form-group" >
                                                    <label for="">Employee<span class="sp-err">*</span></label>   
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
                                                    <label for="">Extension Number<span class="sp-err">*</span></label>
                                                    <select class="form-control"  ng-model="extensionData.extension_no" name="extension_no" id="extension_no" required="">
                                                        <option value="">Select Extension</option>
                                                        <option ng-repeat="item in ext_number" value="{{item}}" ng-selected="{{ item == extensionData.extension_no}}">Extension&nbsp;{{item}}</option>
                                                    </select>
                                                    <div ng-show="sbtBtn" ng-messages="extensionForm.extension_no.$error" class="help-block errMsg">
                                                        <div style="color: red" ng-message="required">This field is required</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2" >
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <span class="input-icon icon-right">
                                                        <button type="submit" ng-click="sbtBtn = true" ng-disabled="btnSubmit" class="btn btn-primary custom-btn">{{btnlable}}</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
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


