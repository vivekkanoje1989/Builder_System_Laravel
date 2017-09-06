<style>
    .select2-container-multi .select2-choices {
        position: relative;
        min-height: 32px !important;
    }
    .ui-select-multiple input.ui-select-search {
        width: 100% !important;
        position: absolute;
    }
</style>
<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <tabset justified="true">
                            <tab heading="Enquiry Filters">
                                <form name="frmccFilter" role="form" ng-submit="ccfilter(filter, 1, [[ config('global.recordsPerPage') ]])">
                                    <div class="row" ng-controller="employeesWiseTeamCtrl">
                                            <div class="col-sm-6 col-sx-12" ng-if="type == 1 && employeesData.length > 0">
                                                <div class="form-group">
                                                    <label for="">Select Owners Name</label>
                                                    <span class="input-icon icon-right">
                                                        <ui-select multiple ng-model="filter.employee_id" name="employee_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                            <ui-select-match placeholder='Select Employee'>{{$item.first_name}} {{$item.last_name}}</ui-select-match>
                                                            <ui-select-choices repeat="list in employeesData | filter:$select.search" ng-hide="!$select.open">
                                                                <span>
                                                                    {{ list.first_name}} {{ list.last_name}}
                                                                </span>
                                                            </ui-select-choices>
                                                        </ui-select>
                                                        <i class="fa fa-sort-desc"></i>
                                                    </span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">From Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filter.fromDate" name="fromDate" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">To Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filter.toDate" min-date="filterData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="row" ng-controller="ccpresalesStatusCtrl">
                                        
                                        <div class="col-sm-6 col-xs-12" ng-if="listType==1 || listType==2 || listType==4">
                                            <div class="form-group" >
                                                <label for="">Followup Status</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="filter.cc_presales_status_id" name="cc_presales_status_id" ng-change="onccpreSalesStatusChange(filter.cc_presales_status_id)" class="form-control" >
                                                        <option value="">Select Followup Status</option>
                                                        <option ng-repeat="list in ccpresalesstatus track by $index" ng-if="list.id !=2"   value="{{list.id}}_{{list.cc_presales_status}}">
                                                             {{list.cc_presales_status}}
                                                        </option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12" ng-if="listType==3">
                                            <div class="form-group" >
                                                <label for="">Followup Status</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="filter.cc_presales_status_id" name="cc_presales_status_id" ng-change="onccpreSalesStatusChange(filter.cc_presales_status_id)" class="form-control" >
                                                        <option value="">Select Followup Status</option>
                                                        <option ng-repeat="list in ccpresalesstatus track by $index" ng-if="listType==3"   value="{{list.id}}_{{list.cc_presales_status}}">
                                                                {{list.cc_presales_status}}
                                                        </option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>


                                            

                                        
                                       <div class="col-sm-6 col-xs-12" >
                                            <div class="form-group">
                                                <div ng-if="listType==5">
                                                    <span ng-init="onccpreSalesStatusChange(2)"></span>
                                                </div>
                                                <label for="">Followup Sub Status</label>                                                
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filter.cc_presales_substatus_id" name="cc_presales_substatus_id" theme="select2"  style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Status' style="width:100% !important;">{{$item.cc_presales_substatus}}</ui-select-match>
                                                        <ui-select-choices repeat="list in ccpresalessubStatusList | filter:$select.search">
                                                            {{ list.cc_presales_substatus}}
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" ng-controller="ccpresalesCategoryCtrl" ng-if="listType!=5">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Followup Category</label>
                                                <span class="input-icon icon-right">
                                                    <select class="form-control" ng-model="filter.cc_presales_category_id" name="cc_presales_category_id" id="cc_presales_category_id" ng-change="onccpresalesCategoryChange(filter.cc_presales_category_id)">
                                                        <option value="">Select Category</option>
                                                        <option ng-repeat="list in ccpresalescategory" value="{{list.id}}_{{list.cc_presales_category}}">{{list.cc_presales_category}}</option>          
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" >
                                            <div class="form-group">
                                                <label for="">Followup Sub Category</label>                                                
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filter.cc_presales_subcategory_id" name="cc_presales_subcategory_id" theme="select2"  style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Category' style="width:100% !important;">{{$item.cc_presales_subcategory}}</ui-select-match>
                                                        <ui-select-choices repeat="list in ccpresalesSubCategoriesList | filter:$select.search">
                                                            {{ list.cc_presales_subcategory}}
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row" ng-controller="enquirySourceCtrl">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Enquiry Source</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="filter.source_id" name="source_id" id="source_id" class="form-control" ng-change="onEnquirySourcefilterChange(filter.source_id)">
                                                        <option value="">Select Source</option>
                                                        <option ng-repeat="source in sourceList track by $index" value="{{source.id}}_{{source.sales_source_name}}">{{source.sales_source_name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Enquiry Sub Source</label>
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filter.subsource_id" name="subsource_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Source'>{{$item.enquiry_subsource}}</ui-select-match>
                                                        <ui-select-choices repeat="list in subSourceList | filter:$select.search">
                                                            {{list.enquiry_subsource}} 
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group" ng-controller="vehiclemodelCtrl">
                                                <label for="">Model Name</label>
                                                <span class="input-icon icon-right">                                                   
                                                    <select ng-model="filter.model_id" name="model_id" class="form-control">
                                                        <option value="">Select Model</option>
                                                        <option ng-repeat="model in vehiclemodels track by $index" value="{{model.id}}_{{model.model_name}}">{{model.model_name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>                                        
                                        </div>                                        
                                        <div class="col-sm-6 col-xs-12" ng-controller="testdriveStatusCtrl">
                                            <label>Test Drive Status </label>
                                                <span class="input-icon icon-right">
                                                <select ng-model="filter.test_drive_given" name="test_drive_given" class="form-control">
                                                    <option value="">Select Test Drive Status</option>
                                                    <option ng-repeat="tdstatus in testdrivestatus track by $index" value="{{tdstatus.id}}_{{tdstatus.status}}">{{tdstatus.status}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                </span>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary">Search</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </tab>
                            <tab heading="Customer Filters">
                                <form name="enquiryFilter" role="form" ng-submit="ccfilter(filter, 1, [[ config('global.recordsPerPage')]])">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">First Name </label>
                                                <input type="text" ng-model="filter.fname" name="fname" capitalization class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Last Name </label>
                                                <input type="text" ng-model="filter.lname" name="lname"  capitalization class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Mobile Number </label>
                                                <input type="text" ng-model="filter.mobileNumber" name="mobileNumber" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" minlength="10" maxlength="10">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Email Id </label>
                                                <input type="email" ng-model="filter.emailId" name="emailId" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" ng-model="filter.verifiedMobNo" name="verifiedMobNo">
                                                    <span class="text">Verified Mobile Number</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" ng-model="filter.verifiedEmailId" name="verifiedEmailId">
                                                    <span class="text">Verified Email Id </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary">Search</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>                                
                            </tab>
                        </tabset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
