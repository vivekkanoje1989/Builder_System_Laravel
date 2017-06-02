<!-- Enquiry History Modal -->
<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
<!--            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <tabset justified="true">
                            <tab heading="Enquiry Filters">
                                <div class="row" ng-controller="DatepickerDemoCtrl">
                                    <div class="col-sm-6 col-sx-12">
                                        <div class="form-group">
                                            <label for="">From Date</label>
                                            <span class="input-icon icon-right">
                                                <p class="input-group">
                                                    <input type="text" ng-model="filterData.fromDate" name="fromDate" id="fromDate" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                </p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-sx-12">
                                        <div class="form-group">
                                            <label for="">To Date</label>
                                            <span class="input-icon icon-right">
                                                <p class="input-group">
                                                    <input type="text" ng-model="filterData.toDate" name="toDate" id="toDate" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
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
                                                <select ng-model="filterData.category_id" name="category_id" class="form-control">
                                                    <option value="">Select category</option>
                                                    <option ng-repeat="list in salesEnqCategoryList track by $index" value="{{list.id}}">{{list.enquiry_category}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-sx-12">
                                        <div class="form-group">
                                            <label for="">Enquiry Sub Catergory</label>
                                            <span class="input-icon icon-right">
                                                <ui-select multiple ng-model="filterData.subcategory_id" name="subcategory_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                                                    <ui-select-match>{{$item.department_name}}</ui-select-match>
                                                    <ui-select-choices repeat="list in subCategoryList | filter:$select.search">
                                                        {{list.department_name}} 
                                                    </ui-select-choices>
                                                </ui-select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" ng-controller="enquirySourceCtrl">
                                    <div class="col-sm-6 col-sx-12">
                                        <div class="form-group">
                                            <label for="">Enquiry Source</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="filterData.source_id" name="source_id" class="form-control">
                                                    <option value="">Select Source</option>
                                                    <option ng-repeat="source in sourceList track by $index" value="{{source.id}}">{{source.sales_source_name}}</option>
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
                                                    <ui-select-match>{{$item.sub_source}}</ui-select-match>
                                                    <ui-select-choices repeat="list in subSourceList | filter:$select.search">
                                                        {{list.sub_source}} 
                                                    </ui-select-choices>
                                                </ui-select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-sx-12">
                                        <div class="form-group" ng-controller="projectCtrl">
                                            <label for="">Project Name</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="filterData.project_id" name="project_id" class="form-control">
                                                    <option value="">Select Project</option>
                                                    <option ng-repeat="plist in projectList track by $index" value="{{plist.id}}">{{plist.project_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-sx-12">
                                        <div class="form-group">
                                            <label for="">Preferred Location</label>
                                            <span class="input-icon icon-right">
                                                <div class="col-sm-6 col-md-6 col-xs-12">
                                                    <div class="form-group" ng-controller="enquiryCityCtrl">
                                                        <span class="input-icon icon-right">
                                                            <select class="form-control" ng-model="filterData.city_id" name="city_id" ng-change="changeLocations(enquiryData.city_id)">
                                                                <option value="">Select Preferred city</option>     
                                                                <option ng-repeat="list in cityList" value="{{list.city_id}}">{{ list.get_city_name.name}}</option>
                                                            </select>
                                                            <i class="fa fa-sort-desc"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-xs-12">
                                                    <div class="form-group multi-sel-div">
                                                        <ui-select multiple ng-model="filterData.enquiry_locations" name="enquiry_locations" theme="select2" ng-disabled="disabled">
                                                            <ui-select-match placeholder='Select Locations'>{{$item.location}}</ui-select-match>
                                                            <ui-select-choices repeat="list in locations | filter:$select.search">
                                                                {{list.location}} 
                                                            </ui-select-choices>
                                                        </ui-select>         
                                                        <div ng-show="step" ng-messages="enquiryForm.enquiry_locations.$error" class="help-block step">
                                                            <div ng-message="required">Please select location</div>
                                                        </div>
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
                                        <div class="form-group">
                                            <label for="">Channel</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="filterData.channel_id" ng-controller="titleCtrl" name="channel_id" class="form-control">
                                                    <option value="">Select Channel</option>
                                                    <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == userData.title_id}}">{{t.title}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" ng-controller="rzCtrl">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
                                        <div class="col-sm-6 col-sx-6">
                                            <div class="form-group">
                                                <label for="">Budget Min Value </label>
                                                <input type="text" ng-model="min" class="form-control" maxlength="8" ng-change="rangeValidateMin(min)" ng-model-options="{ updateOn: 'blur' }">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-sx-6">
                                            <div class="form-group">
                                                <label for="">Budget Max Value </label>
                                                <input type="text" ng-model="max" class="form-control" maxlength="8" ng-change="rangeValidateMax(max)" ng-model-options="{ updateOn: 'blur' }">
                                            </div>
                                        </div>
                                        <rzslider rz-slider-model="min" rz-slider-high="max" rz-slider-options="visSlider.options"></rzslider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-sx-12" align="right">
                                        <div class="form-group">
                                            <span class="input-icon icon-right">
                                                <button type="button" name="sbtbtn" value="Search" class="btn btn-primary">Search</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </tab>
                            <tab heading="Customer Filters">
                                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
                            </tab>
                        </tabset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
