<style>
    .select2-container-multi .select2-choices {
        position: relative;
        min-height: 32px !important;
    }
    .ui-select-multiple input.ui-select-search {
        width: 100% !important;
        position: absolute;
    }
    #slideout {
        height : 100% !important
    }
</style>
  <!-- listType
        1   --- todays folloups
        2  ---pending followups
        3 ---previous followups                                        
        4 ------- total enquiry
        5 ----- booked enquiry                                        
        6 ----- reassign enquiry 
        7 ----- lost enquiries
        -->    
<script src="/js/filterSlider.js"></script>
<div class="wrap-filter-form show-widget" id="slideout">
    <strong align="center">Filters</strong>
    <button type="button" class="close toggleForm" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <!--<span aria-hidden="true"  ng-if="!filterData">&times;</span>-->
        <!--<span ng-if="filterData" aria-hidden="true" ng-click="getFilteredData(filterData,1, 30);">&times;</span>-->
    </button>
    <hr style="margin-bottom: 0px !important;">
    <div class="row" ng-controller="AccordionDemoCtrl">        
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <accordion close-others="oneAtATime">
            <accordion-group is-open="status.open" >
                <accordion-heading>
                    <span>Enquiry</span>
                </accordion-heading>
                <form name="enquiryFilter" role="form" ng-submit="getFilteredData(filterData,1, 30)">
                    <div class="row" ng-controller="employeesWiseTeamCtrl">
                        <div class="col-sm-6 col-sx-12" ng-if="type == 1 && employeesData.length > 0">
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
                    <div class="row">
                        <div class="col-sm-6 col-sx-12" ng-controller="DatepickerDemoCtrl">
                            <div class="form-group">
                                <label for="">From Date</label>
                                <span class="input-icon icon-right">
                                    <p class="input-group">
                                        <input type="text" ng-model="filterData.fromDate" name="fromDate" id="fromDate" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12" ng-controller="DatepickerDemoCtrl">
                            <div class="form-group">
                                <label for="">To Date</label>
                                <span class="input-icon icon-right">
                                    <p class="input-group">
                                        <input type="text" ng-model="filterData.toDate" min-date="filterData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-if="listType == 5">
                        <div class="col-sm-6 col-sx-12" ng-controller="DatepickerDemoCtrl">
                            <div class="form-group">
                                <label for="">Booking From Date</label>
                                <span class="input-icon icon-right">
                                    <p class="input-group">
                                        <input type="text" ng-model="filterData.bookingFromDate" name="bookingFromDate" id="bookingFromDate" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12" ng-controller="DatepickerDemoCtrl">
                            <div class="form-group">
                                <label for="">Booking To Date</label>
                                <span class="input-icon icon-right">
                                    <p class="input-group">
                                        <input type="text" ng-model="filterData.bookingToDate" min-date="filterData.bookingFromDate" name="bookingToDate" id="bookingToDate" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                    </p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-controller="salesEnqCategoryCtrl">
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group">
                                <label for="">Enquiry Category</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.category_id" name="category_id" class="form-control" ng-change="getFilterSubCategory(filterData.category_id)">
                                        <option value="">Select category</option>
                                        <option ng-repeat="list in salesEnqCategoryList track by $index" value="{{list.id}}_{{list.enquiry_category}}">{{list.enquiry_category}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12">
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
                    <div class="row" ng-if="listType == 7" ng-controller="salesLostReasonCtrl">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Lost Reason</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.lostReason_id" name="lostReason_id" class="form-control" id="sales_lost_reason_id" ng-change="getlostsubreason(filterData.lostReason_id)">
                                        <option value="">Select Reason</option>
                                        <option ng-repeat="list in saleslostreasons track by $index"  value="{{list.id}}_{{list.reason}}">{{list.reason}}</option>
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
                     <div class="row"  ng-controller="salesEnqStatusCtrl">
                        <div class="col-sm-6 col-xs-12"  ng-if="listType == 1 || listType == 2 || listType == 3 || listType == 4 || listType == 6">
                            <div class="form-group" >
                                <label for="">Enquiry Status</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.status_id" name="status_id" class="form-control" ng-change="getFilterSubStatus(filterData.status_id)">
                                        <option value="">Select status</option>
                                        <option ng-repeat="list in salesEnqStatusList track by $index"  ng-if="list.id != 3 && list.id != 4" value="{{list.id}}_{{list.sales_status}}">{{list.sales_status}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12"  ng-if="listType == 1 || listType == 2 || listType == 3 || listType == 4 || listType == 6">
                            <div class="form-group">
                                <label for="">Enquiry Sub Status</label>                                                
                                <span class="input-icon icon-right">
                                    <ui-select multiple ng-model="filterData.substatus_id" name="substatus_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                        <ui-select-match placeholder='Select Sub Status' style="width:100% !important;">{{$item.enquiry_sales_substatus}}</ui-select-match>
                                        <ui-select-choices repeat="list in salesEnqSubStatusList | filter:$select.search">
                                            {{ list.enquiry_sales_substatus}}
                                        </ui-select-choices>
                                    </ui-select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div> 
                    <div class="row" ng-controller="enquirySourceCtrl">
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group">
                                <label for="">Enquiry Source</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.source_id" name="source_id" class="form-control" ng-change="onEnquiryFilterSourceChange(filterData.source_id)">
                                        <option value="">Select Source</option>
                                        <option ng-repeat="source in sourceList track by $index" value="{{source.id}}_{{source.sales_source_name}}">{{source.sales_source_name}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group">
                                <label for="">Enquiry Sub Source</label>
                                <span class="input-icon icon-right">
                                    <ui-select multiple ng-model="filterData.subsource_id" name="subsource_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                        <ui-select-match placeholder='Select Sub Source'>{{$item.sub_source}}</ui-select-match>
                                        <ui-select-choices repeat="list in subSourceList | filter:$select.search">
                                            {{list.sub_source}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group" ng-controller="projectCtrl">
                                <label for="">Project Name</label>
                                <span class="input-icon icon-right">
                                    <ui-select multiple ng-model="filterData.project_id" name="project_id" theme="select2" ng-disabled="disabled" style="width:100%;">
                                        <ui-select-match placeholder='Select Project'>{{$item.project_name}}</ui-select-match>
                                        <ui-select-choices repeat="plist in projectList | filter:$select.search">
                                            {{plist.project_name}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12">
                             <div class="form-group" >
                                <label for="max budget">Max Budget</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="filterData.max_budget" name="max_budget" maxlength="8" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group">
                                <label for="">Parking Required</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.parking_required" name="parking_required" class="form-control">
                                        <option value="">Parking Required</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group">
                                <label for="">Loan Required</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.loan_required" name="loan_required" class="form-control">
                                        <option value="">Loan Required</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group">
                                <label for="">Site Visited</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.site_visited" name="site_visited" class="form-control">
                                        <option value="">Site Visited</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-12">
                            <div class="form-group" ng-controller="channelCtrl">
                                <label for="">Channel</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="filterData.channel_id" name="channel_id" class="form-control">
                                        <option value="">Select Channel</option>
                                        <option ng-repeat="list in channelList track by $index" value="{{list.id}}_{{list.channel_name}}">{{list.channel_name}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group" ng-controller="enquiryCityCtrl">
                            <label for="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Preferred Location</label>
                            <span class="input-icon icon-right">
                                <div class="col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <span class="input-icon icon-right">
                                            <select class="form-control" ng-model="filterData.city_id" name="city_id" ng-change="changeLocations(filterData.city_id)">
                                                <option value="">Select Preferred city</option>     
                                                <option ng-repeat="list in cityList" value="{{list.city_id}}_{{ list.get_city_name.name}}">{{ list.get_city_name.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group multi-sel-div">
                                        <span class="input-icon icon-right">
                                            <ui-select multiple ng-model="filterData.enquiry_locations" name="enquiry_locations" theme="select2" ng-disabled="disabled" style="width:100%;">
                                                <ui-select-match placeholder='Select Locations'>{{$item.location}}</ui-select-match>
                                                <ui-select-choices repeat="list in locations | filter:$select.search">
                                                    {{list.location}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>    
                            </span>
                        </div>                               
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-sx-12" align="right">
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>            
            </accordion-group>
            <accordion-group is-open="status.close" class="collapsed">
                <accordion-heading>
                    <span>Customer</span>
                </accordion-heading>
           
            <!--<h4 class="">Customer</h4>-->
            <div class="accordion-content" heading="Customer Filters">
                <form name="enquiryFilter" role="form" ng-submit="getFilteredData(filterData,1, 30)">
                    <div class="row">
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label for="">First Name </label>
                                <input type="text" ng-model="filterData.fname" name="fname" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label for="">Last Name </label>
                                <input type="text" ng-model="filterData.lname" name="lname" class="form-control" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label for="">Mobile Number </label>
                                <input type="text" ng-model="filterData.mobileNumber" name="mobileNumber" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" minlength="10" maxlength="10">
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label for="">Email Id </label>
                                <input type="email" ng-model="filterData.emailId" name="emailId" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" ng-model="filterData.verifiedMobNo" name="verifiedMobNo">
                                    <span class="text">Verified Mobile Number</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" ng-model="filterData.verifiedEmailId" name="verifiedEmailId">
                                    <span class="text">Verified Email Id </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-sx-12" align="right">
                            <div class="form-group">
                                <span class="input-icon icon-right">
                                    <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                                    <!--<button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>-->
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </accordion-group>
            </accordion>
        </div>       
    </div>
</div>