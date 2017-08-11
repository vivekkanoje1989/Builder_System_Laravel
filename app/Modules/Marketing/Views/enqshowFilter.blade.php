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
<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false">
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
                                <form name="enquiryFilter" role="form" ng-submit="getCustomerFilteredData(filterData)">
                                    <div class="row" ng-controller="employeesWiseTeamCtrl">
                                        <div class="col-sm-6 col-sx-12" ng-if="type==1 && employeesData.length > 0">
                                            <div class="form-group">
                                                <label for="">Select Owners Name</label>
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filterData.employee_id" name="employee_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                        <ui-select-match placeholder='Select Employee'>{{$item.first_name}} {{$item.last_name}}</ui-select-match>
                                                        <!--<ui-select-choices repeat="list in employees1 | filter: {id : '!1'} | filter:$select.search" >-->
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
                                    <div class="row"  ng-controller="salesStatusCtrl">
                                                           
                                        <div class="col-sm-6 col-xs-12" >
                                            <div class="form-group" >
                                                <label for="">Enquiry Status</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="filterData.status_id" name="status_id" class="form-control" ng-change="onsalesStatusChange(filterData.status_id)">
                                                        <option value="">Select status</option>
                                                        <option ng-repeat="list in salesstatus track by $index"   value="{{list.id}}">{{list.sales_status}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group" ng-if="listType == 5">
                                                <label for="">Enquiry Sub Status</label>                                                
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filterData.substatus_id" name="substatus_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Status' style="width:100% !important;">{{$item.enquiry_sales_substatus}}</ui-select-match>
                                                        <ui-select-choices repeat="list in subsalesStatusList | filter:$select.search">
                                                            {{ list.enquiry_sales_substatus}}
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12"  ng-if="listType == 5" ng-controller="lostSubStatusListCtrl">
                                            <div class="form-group">
                                                <label for=""> Sub Status</label>                                                
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filterData.substatus_id" name="substatus_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Status' style="width:100% !important;">{{$item.enquiry_sales_substatus}}</ui-select-match>
                                                        <ui-select-choices repeat="list in subStatusList | filter:$select.search">
                                                            {{list.enquiry_sales_substatus}}
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="row" ng-if="listType == 5" ng-controller="salesLostReasonCtrl">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Lost Reason</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="filterData.lostReason_id" name="lostReason_id" class="form-control" id="sales_lost_reason_id" ng-change="getlostsubreason(filterData.lostReason_id)">
                                                        <option value="">Select Reason</option>
                                                        <option ng-repeat="list in saleslostreasons track by $index"  value="{{list.id}}">{{list.enquiry_lost_reason}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Lost Sub Reason</label>
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filterData.subreason_id" name="subreason_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Reason'>{{$item.sub_reason}}</ui-select-match>
                                                        <ui-select-choices repeat="list in salessublostreasons | filter:$select.search">
                                                            {{list.sub_reason}}
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" ng-if="listType == 5" ng-controller="salesLostReasonCtrl">
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">Lost From Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filterData.lfromDate" name="lfromDate" id="lfromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">Lost To Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filterData.ltoDate" min-date="filterData.lfromDate" name="ltoDate" id="ltoDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">Enquiry From Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filterData.fromDate" name="fromDate" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">Enquiry To Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filterData.toDate" min-date="filterData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="row" ng-controller="salesEnqCategoryCtrl">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Enquiry Category</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="filterData.category_id" name="category_id" class="form-control" ng-change="getSubCategory(filterData.category_id)">
                                                        <option value="">Select category</option>
                                                        <option ng-repeat="list in salesEnqCategoryList track by $index" value="{{list.id}}">{{list.enquiry_category}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Enquiry Sub Category</label>
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filterData.subcategory_id" name="subcategory_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                        <ui-select-match placeholder='Select Sub Category'>{{$item.enquiry_sales_subcategory}}</ui-select-match>
                                                        <ui-select-choices repeat="list in salesEnqSubCategoryList | filter:$select.search">
                                                            {{list.enquiry_sales_subcategory}}
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
                                                    <select ng-model="filterData.source_id" name="source_id" id="source_id" class="form-control" ng-change="onEnquirySourcefilterChange(filterData.source_id)">
                                                        <option value="">Select Source</option>
                                                        <option ng-repeat="source in sourceList" value="{{source.id}}">{{source.sales_source_name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="">Enquiry Sub Source</label>
                                                <span class="input-icon icon-right">
                                                    <ui-select multiple ng-model="filterData.subsource_id" name="subsource_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
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
                                                    <select ng-model="filterData.model_id" name="model_id" class="form-control">
                                                        <option value="">Select Source</option>
                                                        <option ng-repeat="model in vehiclemodels track by $index" value="{{model.id}}">{{model.model_name}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>                                        
                                        </div>
                                        <div class="col-sm-6 col-xs-12" ng-controller="testdriveStatusCtrl">
                                            <label>Test Drive Status </label>
                                                <span class="input-icon icon-right">
                                                <select ng-model="filterData.test_drive_given" name="test_drive_given" class="form-control">
                                                    <option value="">Select Test Drive Status</option>
                                                    <option ng-repeat="tdstatus in testdrivestatus track by $index" value="{{tdstatus.id}}">{{tdstatus.status}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                </span>
<!--                                            <div class="radio">
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="filterData.test_drive_given" value="1" class="colored-success">
                                                    <span class="text">Yes </span>
                                                </label>
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="filterData.test_drive_given" value="0" class="colored-red" ng-selected="true">
                                                    <span class="text">No </span>
                                                </label>
                                            </div>-->
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
                                <form name="enquiryFilter" role="form" ng-submit="getCustomerFilteredData(filterData)">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">First Name </label>
                                                <input type="text" ng-model="filterData.fname" name="fname" capitalization class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Last Name </label>
                                                <input type="text" ng-model="filterData.lname" name="lname"  capitalization class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Mobile Number </label>
                                                <input type="text" ng-model="filterData.mobileNumber" name="mobileNumber" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" minlength="10" maxlength="10">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Email Id </label>
                                                <input type="email" ng-model="filterData.emailId" name="emailId" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Company Name </label>
                                                <input type="text" ng-model="filterData.company_name" name="company_name"  capitalization class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" ng-model="filterData.verifiedMobNo" name="verifiedMobNo">
                                                    <span class="text">Verified Mobile Number</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" ng-model="filterData.verifiedEmailId" name="verifiedEmailId">
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
