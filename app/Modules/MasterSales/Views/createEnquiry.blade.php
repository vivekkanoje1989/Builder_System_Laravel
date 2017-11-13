<form name="enquiryForm" role="form" novalidate ng-submit=" projectsDetails.length > 0 && enquiryForm.$valid && saveEnquiryData(enquiryData)">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <input type="hidden" ng-model="enquiryData.csrfToken" name="csrftoken" id="csrftoken" ng-init="enquiryData.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
            <input type="hidden" ng-model="enquiryData.id" name="id" value="{{enquiryData.id}}">
            <!--
            enqType ==  1 -> Quick Enquiry
            enqType ==  0 -> detailed enquiry
            -->
            <div class="row" ng-if="enqType == 1">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.title_id.$dirty && enquiryForm.title_id.$invalid)}">
                            <label for="">Title <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-model="enquiryData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required="required">
                                    <option value="">Select Title</option>
                                    <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == enquiryData.title_id}}">{{t.title}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>                               
                            </span>
                            <div ng-show="enqFormBtn" ng-messages="enquiryForm.title_id.$error" class="help-block enqFormBtn">
                                <div ng-message="required">This field is required.</div>
                            </div>
                        </div>                        
                    </div>                    
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.first_name.$dirty && enquiryForm.first_name.$invalid)}">
                            <label for="">First Name <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" maxlength="15" capitalizeFirst ng-model="enquiryData.first_name" name="first_name" required>
                                <i class="fa fa-user"></i>
                            </span>
                            <div ng-show="enqFormBtn" ng-messages="enquiryForm.first_name.$error" class="help-block enqFormBtn">
                                <div ng-message="required">This field is required.</div>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.last_name.$dirty && enquiryForm.last_name.$invalid)}">
                            <label for="">Last Name <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" maxlength="15" capitalizeFirst ng-model="enquiryData.last_name" name="last_name" required>
                                <i class="fa fa-user"></i>
                            </span>
                            <div ng-show="enqFormBtn" ng-messages="enquiryForm.last_name.$error" class="help-block enqFormBtn">
                                <div ng-message="required">This field is required.</div>
                            </div>
                        </div>                      
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12"  ng-controller="enquirySourceCtrl">
                        <div class="form-group">
                            <label for="">Source<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-change="onEnquirySourceChange(enquiryData.source_id)" class="form-control" ng-model="enquiryData.source_id" name="source_id"  id="source_id" required>
                                    <option value="">Select Source</option>
                                    <option ng-repeat="source in sourceList" value="{{source.id}}" ng-selected="{{source.id == enquiryData.source_id}}">{{source.sales_source_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="enquiryForm.source_id.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="source_id" class="errMsg source_id">{{source_id}}</div>
                            </span>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.sales_enquiry_date.$dirty && enquiryForm.sales_enquiry_date.$invalid)}">
                        <label for="">Date of enquiry <span class="sp-err">*</span></label>
                        <div ng-controller="DatepickerDemoCtrl" class="form-group">
                            <p class="input-group">
                                <input type="text" ng-model="enquiryData.sales_enquiry_date" name="sales_enquiry_date" id="sales_enquiry_date" class="form-control" datepicker-popup="dd-M-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.sales_enquiry_date.$error" class="help-block">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="sales_enquiry_date" class="sp-err blog_title">{{sales_enquiry_date}}</div>
                            </p>
                        </div>
                        </div>                        
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.sales_category_id.$dirty && enquiryForm.sales_category_id.$invalid)}">
                            <label for="">Enquiry Category <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="salesEnqCategoryCtrl" ng-model="enquiryData.sales_category_id" name="sales_category_id" required>
                                    <option value="">Please Select Category</option>                                       
                                    <option ng-repeat="list in salesEnqCategoryList" value="{{list.id}}" ng-selected="{{ list.id == enquiryData.sales_category_id}}">{{list.enquiry_category}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.sales_category_id.$error" class="help-block enqFormBtn">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="sales_category_id" class="sp-err blog_title">{{sales_category_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" ng-if="enqType != 1">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.max_budget.$dirty && enquiryForm.max_budget.$invalid)}">
                            <label for="">Max Budget <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" minlength="4" maxlength="7" ng-pattern="/^[1-9]+[0-9]*$/" ng-model="enquiryData.max_budget" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="max_budget" required>
                                <i class="fa fa-money"></i>
                            </span>
                            <div ng-show="enqFormBtn" ng-messages="enquiryForm.max_budget.$error" class="help-block enqFormBtn">
                                <div ng-message="required">This field is required.</div>
                                <span ng-show="enquiryForm.max_budget.$error.pattern">Please enter valid max budget</span>
                            </div>
                        </div>
                    </div>  
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.remarks.$dirty && enquiryForm.remarks.$invalid)}">
                            <label for="">Remark <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <textarea class="form-control capitalize" ng-model="enquiryData.remarks" name="remarks"  ng-disabled="disableDataOnEnqUpdate" required></textarea>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.remarks.$error" class="help-block enqFormBtn">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="remarks" class="sp-err remarks">{{remarks}}</div>
                            </span>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="col-sm-3 col-xs-6" ng-if="enqType != 0">
                        <div class="form-group">
                            <label for="">Reassign To <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="getEmployeesCtrl" ng-model="enquiryData.followup_by_employee_id" name="followup_by_employee_id">
                                    <!--<option value="">Select Employee</option>-->
                                    <option ng-repeat="list in employeeList" value="{{list.id}}" ng-selected="list.id == [[ Auth::guard('admin')->user()->id ]]">{{list.first_name}} {{list.last_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>                                                                
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" ng-if="enqType == 0">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.followup_by_employee_id.$dirty && enquiryForm.followup_by_employee_id.$invalid)}">
                            <label for="">Reassign To <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="getEmployeesCtrl" ng-model="enquiryData.followup_by_employee_id" name="followup_by_employee_id" required>
                                    <option value="">Select Employee</option>
                                    <option ng-repeat="list in employeeList" value="{{list.id}}" ng-selected="list.id == enquiryData.followup_by_employee_id">{{list.first_name}} {{list.last_name}}</option>                                              
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.followup_by_employee_id.$error" class="help-block enqFormBtn">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="followup_by_employee_id" class="sp-err blog_title">{{followup_by_employee_id}}</div>
                            </span>
                        </div>
                    </div>   
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.next_followup_date.$dirty && enquiryForm.next_followup_date.$invalid)}">
                            <label for="">Next Followup Date & Time<span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="enquiryData.next_followup_date" name="next_followup_date"  id="next_followup_date" class="form-control" datepicker-popup="dd-M-yyyy" is-open="opened" ng-change="todayremarkTimeChange(enquiryData.next_followup_date)"  min-date=enquiryData.sales_enquiry_date  datepicker-options="dateOptions" close-text="Close" readonly required />
                                    <span class="input-group-btn" >
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.next_followup_date.$error" class="help-block">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="next_followup_date" class="sp-err blog_title">{{next_followup_date}}</div>
                                </p>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.next_followup_time.$dirty && enquiryForm.next_followup_time.$invalid)}">
                            <label for="">Time<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-model="enquiryData.next_followup_time" name="next_followup_time" id="next_followup_time" class="form-control" required="required">
                                    <option value=""> Select Time </option>
                                    <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="time.value == enquiryData.next_followup_time">{{time.label}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="enqFormBtn"  ng-messages="enquiryForm.next_followup_time.$error" class="help-block enqFormBtn">
                                    <div ng-message="required" >This field is required.</div>
                                </div>
                                <div ng-if="next_followup_time" class="sp-err blog_title">{{next_followup_time}}</div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" ng-if="enqType != 1">
                <div class="col-lg-12 col-sm-12 col-xs-12">  
                    <div class="form-title">Requirement Details</div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.parking_required.$dirty && enquiryForm.parking_required.$invalid)}">
                            <label for="">Parking Required <span class="sp-err">*</span></label>
                            <div class="control-group">
                                <div class="radio">
                                    <label>
                                        <input name="parking_required" type="radio" ng-model="enquiryData.parking_required" value="1" class="colored-success" required>
                                        <span class="text">Yes </span>
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input name="parking_required" type="radio" ng-model="enquiryData.parking_required" value="0" class="colored-danger" required>
                                        <span class="text"> No </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--if common parking then 2 wheelar and 4 wheelar parking numbers wants to enter-->
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.parking_required == 1">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.parking_type.$dirty && enquiryForm.parking_type.$invalid)}">
                            <label for="">Parking Type<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="enquiryData.parking_type" name="parking_type" required>
                                    <option value="1">Common Parking</option>                                       
                                    <option value="2">Private Parking</option>                                       
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.parking_type.$error" class="help-block">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="parking_type" class="sp-err blog_title">{{parking_type}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.parking_type == 1 && enquiryData.parking_required == 1">
                        <div class="form-group">
                            <label for="">Number of 2 wheeler parkings required </label>{{two_wheeler_parkings_required}}
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" ng-init="enquiryData.two_wheeler_parkings_required == '0' ? '01-01-1990' : enquiryData.two_wheeler_parkings_required " ng-model="enquiryData.two_wheeler_parkings_required" maxlength="5" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="two_wheeler_parkings_required">
                                <i class="fa fa-motorcycle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.parking_type == 1 && enquiryData.parking_required == 1">
                        <div class="form-group">
                            <label for="">Number of 4 wheeler parkings required</label>
                            <span class="input-icon icon-right" ng-init="enquiryData.four_wheeler_parkings_required > 0 ? enquiryData.four_wheeler_parkings_required : '' ">
                                <input class="form-control" type="text" ng-model="enquiryData.four_wheeler_parkings_required" maxlength="5" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="four_wheeler_parkings_required">
                                <i class="fa fa-car"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" ng-if="enqType != 1">
                <div class="col-lg-12 col-sm-12 col-xs-12">  
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.finance_required.$dirty && enquiryForm.finance_required.$invalid)}">
                            <label for="">Finance Required <span class="sp-err">*</span></label>                                
                            <div class="control-group">
                                <div class="radio">
                                    <label>
                                        <input name="finance_required" type="radio" ng-model="enquiryData.finance_required" value="1" class="colored-success">
                                        <span class="text">Yes </span>
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input name="finance_required" type="radio" ng-model="enquiryData.finance_required" value="0" class="colored-danger">
                                        <span class="text"> No </span>
                                    </label>
                                </div>
                            </div>
                            <div ng-show="enqFormBtn" ng-messages="enquiryForm.finance_required.$error" class="help-block">
                                <div ng-message="required">This field is required.</div>
                            </div>                                
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.finance_required == 1">
                        <div class="form-group">
                            <label for="">Finance will be taken care by</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="enquiryData.finance_required_from" name="finance_required_from">
                                    <option value="1">In house finance department</option>                                       
                                    <option value="2">Finance tieup agency</option>                                       
                                    <option value="3">Customer himself</option>                                       
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>                         
                    <!--
                    if Finance will be taken care by = 1 then show label = Select finance department colleague (foreign key of employee id)
                    if Finance will be taken care by = 2 then show label = Select finance tie up agency (foreign key of enquiry_finance_tieup)
                    if Finance will be taken care by = 3 then hide this field
                    -->
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.finance_required_from == 1 && enquiryData.finance_required == 1">
                        <div class="form-group">
                            <label for="">Finance department colleague</label>
                            <span class="input-icon icon-right">
                                <select ng-controller="financeEmployees" ng-model="enquiryData.finance_employee_id" name="finance_employee_id" class="form-control">
                                    <option value="">Select Employee</option>
                                    <option ng-repeat="list in financeEmpList" value="{{list.id}}" ng-selected="{{ list.id == enquiryData.finance_employee_id}}">{{list.first_name}} {{list.last_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div> 
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.finance_required_from == 2">
                        <div class="form-group">
                            <label for="">Finance tie up agency</label>
                            <span class="input-icon icon-right">
                                <select ng-controller="agencyTieupCtrl" ng-model="enquiryData.finance_tieup_id" name="finance_tieup_id" class="form-control">
                                    <option value="">Select Finance Agency</option>
                                    <option ng-repeat="list in agencyTieupList" value="{{list.id}}" ng-selected="{{ list.id == enquiryData.finance_tieup_id}}">{{list.first_name}} {{list.last_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-lg-12 col-sm-12 col-xs-12"  ng-controller="enquiryCityCtrl">
                    <div class="form-title">Preferences</div>
                    <div class="row col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.city_id.$dirty && enquiryForm.city_id.$invalid)}">
                            <label for="">Preferred City <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="enquiryData.city_id" name="city_id" ng-change="changeLocations(enquiryData.city_id)" required>
                                    <option value=''>Select Preferred city</option>     
                                    <option ng-repeat="list in cityList" value="{{list.city_id}}" ng-selected="{{ list.city_id == enquiryData.city_id}}">{{ list.get_city_name.name}}</option>                                                                                                                
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="enqFormBtn" ng-messages="enquiryForm.city_id.$error" class="help-block enqFormBtn">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="city_id" class="sp-err blog_title">{{city_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group multi-sel-div" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.enquiry_locations.$dirty && enquiryForm.enquiry_locations.$invalid)}">
                            <label for="">Preferred Area's<span class="sp-err">*</span></label>
                            <ui-select multiple ng-model="enquiryData.enquiry_locations" name="enquiry_locations" theme="select2" ng-disabled="disabled" required>
                                <ui-select-match placeholder='Select Locations'>{{$item.location}}</ui-select-match>
                                <ui-select-choices repeat="list in locations | filter:$select.search">
                                    {{list.location}} 
                                </ui-select-choices>
                            </ui-select>         
                            <div ng-show="enqFormBtn" ng-messages="enquiryForm.enquiry_locations.$valid" class="help-block enqFormBtn">
                                <div ng-message="required">This field is required.</div>
                            </div>
                            <div ng-if="enquiry_locations" class="sp-err blog_title">{{enquiry_locations}}</div>
                        </div>
                    </div>                    
                    <div class="col-sm-3 col-xs-6" ng-if="enqType != 1">
                        <div class="form-group">
                            <label for="">Interested In</label>
                            <div class="radio" style="margin-top: 0px;">
                                <label>
                                    <input type="radio" class="" ng-model="enquiryData.property_possession_type" name="property_possession_type" value="1">
                                    <span class="text">Ready Possession </span>
                                </label>&nbsp;&nbsp;
                                <label>
                                    <input type="radio" class="" ng-model="enquiryData.property_possession_type" name="property_possession_type" value="0">
                                    <span class="text">Under Construction</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" ng-if="enquiryData.property_possession_type == 0 && enqType != 1">
                        <div class="form-group">
                            <label for="">Tentative Possession Date</label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="enquiryData.property_possession_date" name="property_possession_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>                                    
                                </p>
                            </div>                               
                        </div> 
                    </div>                        
                </div>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="form-title">Interested Projects</div>
            <div ng-controller="blockTypeCtrl">
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group" ng-class="{ 'has-error' : enqFormBtn && (!enquiryForm.project_id.$dirty && enquiryForm.project_id.$invalid)}">
                        <label for="">Project</label>
                        <span class="input-icon icon-right">
                            <select ng-controller="projectCtrl" ng-model="enquiryData.project_id" name="project_id"  id ="project_id" class="form-control" ng-change="getBlockTypes(enquiryData.project_id)">
                                <option value="">Select Project</option>
                                <option ng-repeat="plist in projectList" value="{{plist.id}}_{{plist.project_name}}">{{plist.project_name}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                            <div ng-show="enqFormBtn" class="help-block enqFormBtn">
                                <div ng-if="projectsDetails.length == 0">This field is required.</div>
                            </div>
                            <div ng-if="project_id" class="sp-err blog_title">{{project_id}}</div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group multi-sel-div" ng-class="{ 'has-error' : addProBtn && (!enquiryForm.block_id.$dirty && enquiryForm.block_id.$invalid)}">
                        <label for="">Blocks</label>{{ addProBtn}}	
                        <span class="input-icon icon-right">
                        <ui-select ng-change="checkBlockLength(enquiryData.block_id)" multiple ng-model="enquiryData.block_id"  name="block_id" theme="select2" ng-disabled="disabled" required="required">
                            <ui-select-match placeholder='Select blocks'>{{$item.block_name}}</ui-select-match>
                            <ui-select-choices repeat="list in blockTypeList | filter:$select.search">
                                {{list.block_name}} 
                            </ui-select-choices>
                        </ui-select>
                        <div ng-show="enqFormBtn" class="help-block enqFormBtn">
                            <div ng-if="projectsDetails.length == 0">This field is required.</div>
                        </div>
                        <div ng-show="addProBtn" ng-messages="enquiryForm.block_id.$valid" class="help-block addProBtn">
                            <div ng-message="required">This field is required.</div>
                        </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group multi-sel-div">
                        <label for="">Sub Blocks</label>	
                        <ui-select multiple ng-model="enquiryData.sub_block_id" name="sub_block_id" theme="select2" ng-disabled="disabled" ng-change="checkSubBlockLength()" >
                            <ui-select-match placeholder='Select sub blocks'>{{ $item.block_sub_type}}</ui-select-match>
                            <ui-select-choices repeat="list1 in subBlockList | filter:$select.search">
                                {{list1.block_sub_type}} 
                            </ui-select-choices>
                        </ui-select>
                        <div ng-show="enqFormBtn" class="help-block enqFormBtn">
                            <div ng-if="projectsDetails.length == 0">This field is required.</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="form-group"><label for=""></label>
                        <span class="input-icon icon-right">
                            <button type="button" class="btn btn-primary" ng-click="addProBtn = true && addProjectRow({{enquiryData.project_id}})" style="padding: 7px 5px;">Add Project</button>
                        </span> 
                    </div>
                </div>                   
            </div>
            <div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="widget">
                        <div class="widget-header">
                            <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Project List <span id="errContactDetails" class="errMsg"></span></span>
                        </div>
                        <div class="widget-body table-responsive">
                            <table class="table table-hover table-striped table-bordered" at-config="config">
                                <thead class="bord-bot">
                                    <tr>
                                        <th style="width: 5%;">Sr. No.</th>
                                        <th style="width: 20%;">Project</th>
                                        <th style="width: 20%;">Blocks</th>
                                        <th style="width: 35%;">Sub Blocks</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>{{ projectsDetails}}
                                    <tr ng-repeat="list in projectsDetails| unique:'project_id'">
                                        <td>{{ $index + 1}}</td>                                    
                                        <td>{{ list.project_name}}</td>
                                        <td>{{ list.blocks}}</td>
                                        <td>{{ list.subblocks}}</td>                                               
                                        <td>
                                            <div class="fa-hover" style="display: block;">
                                                <a href   ng-click="removeRow('{{ $index}}','{{ list.id}}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a> &nbsp;&nbsp;
                                                <!--<a href tooltip-html-unsafe="Edit Project" ng-click="editproject_details('{{list}}')"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;-->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr ng-if="projectsDetails.length == 0">
                                        <td colspan="5"><center>No Records Found</center></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12" align="center">
                    <button type="submit" class="btn btn-primary btn-nxt3" ng-click="enqFormBtn = true" ng-disabled="disableFinishButton">{{btnLabelE}}</button>
                    <button class="btn btn-primary" ng-show="backBtn" ng-click="backToListing('{{searchData.searchWithMobile}}','{{searchData.searchWithEmail}}')">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>
