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
<script src="/js/filterSlider.js"></script>
<div class="wrap-filter-form show-widget" id="slideout">
    <strong>Filter</strong>   
    <button type="button" class="close toggleForm" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button><hr>

    
    
    <div class="row" ng-controller="AccordionDemoCtrl">
        
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <accordion close-others="oneAtATime">
            <accordion-group is-open="status.open">
                <accordion-heading>
                    <h5>Enquiry</h5>
                </accordion-heading>
            <!--<h4 class="accordion-toggle">Enquiry</h4>-->
            <!--<tabset justified="true">-->
            <div heading="Enquiry Filters">
                <form name="enquiryFilter" role="form" ng-submit="getFilteredData(filterData, min, max, 1, 30)">
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
                            <div class="form-group" ng-controller="enquiryCityCtrl">
                                <label for="">Preferred Location</label>
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
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label for="">Budget Min Value </label>
                                <input type="text" ng-model="min" name="min" class="form-control" maxlength="8" ng-change="rangeValidateMin(min)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="col-sm-6 col-sx-6">
                            <div class="form-group">
                                <label for="">Budget Max Value </label>
                                <input type="text" ng-model="max" name="max" class="form-control" maxlength="8" ng-change="rangeValidateMax(max)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                            </div>
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
            </div>
            
            </accordion-group>
            <accordion-group is-open="status.close">
                <accordion-heading>
                    <h5>Customer</h5>
                </accordion-heading>
           
            <!--<h4 class="">Customer</h4>-->
            <div class="accordion-content" heading="Customer Filters">
                <form name="enquiryFilter" role="form" ng-submit="getFilteredData(filterData, min, max, 1, 30)">
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