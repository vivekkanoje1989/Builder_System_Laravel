<style>
    .close {
        color:black;
    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        /* background: rgba(173, 181, 185, 0.81); */
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
        width: 110%;
    }
</style>
<div class="row" ng-controller="countryCtrl" ng-init="manageCountry([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">  
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Country</span>                
            </div>
            <div class="widget-body table-responsive">
               <div class="row">
                    <div class="col-sm-2 ">
                        <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-change="manageCountry([[$loggedInUserId]],{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary ng-click-active" style="float: right;margin-left: 10px;" data-toggle="modal" data-target="#showFilterModal" ng-click="procName('proc_manage_country', 0)">
                            <i class="btn-label fa fa-filter"></i>Show Filter</button>
                    </div>
                    <div class="col-sm-6  dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                        <span ng-if="countryRowLength != 0" >&nbsp; &nbsp; &nbsp; Showing {{countryRow.length}} Logs Out Of Total {{countryRowLength}} Logs&nbsp;</span>
                        <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'manageCountry', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12"></div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a href="" data-toggle="modal" data-target="#countryModal" ng-click="initialModal(0, '', '', '', '', '')" class="btn btn-info">Add Country</a>
                            </span>
                        </div>
                    </div>
                </div>
                 <!-- filter data--> 
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'empId'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                    <strong ng-if="key === 'name'" data-toggle="tooltip" title="Country Name"><strong> Country Name : </strong> {{ value}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">Sr. No.</th>                       
                            <th style="width:35%">Country</th>
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in countryRow| filter:search | itemsPerPage:itemsPerPage "  total-items="{{ countryRowLength}}">
                             <td>{{ itemsPerPage * (pageNumber - 1) + $index + 1}}</td>      
                            <td>{{list.name}}</td>     
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" data-toggle="modal" data-target="#countryModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{list.name}}',{{ itemsPerPage}},{{$index}},{{list.phonecode}},'{{list.sortname}}')"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'manageCountry', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
                <div data-ng-include="'/ManageCountry/showFilter'"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="countryModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="countryForm.$valid && doCountryAction()" name="countryForm" id='countryForm'>
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!countryForm.name.$dirty && countryForm.name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <label>Country<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="name" name="name"  ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="countryForm.name.$error">
                                    <div ng-message="required">Country name is required</div>
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!countryForm.phonecode.$dirty && countryForm.phonecode.$invalid)}">

                            <label>Phone code<span class="sp-err">*</span></label> 
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="phonecode" name="phonecode"  ng-pattern="/^[0-9]/"  required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="countryForm.phonecode.$error">
                                    <div ng-message="required">Phone code is required</div>
                                    <div ng-message="pattern" class="err">Phone code must be numerical</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!countryForm.sortname.$dirty && countryForm.sortname.$invalid)}">

                            <label>Sort name<span class="sp-err">*</span></label> 
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="sortname" name="sortname"   required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="countryForm.sortname.$error">
                                    <div ng-message="required">Sort name is required</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn=true">{{action}}</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
</div>

