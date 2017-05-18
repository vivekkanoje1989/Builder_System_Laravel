<div id="enquiry-form" ng-controller="enquiryController">
    <form name="enquiryForm" role="form"  novalidate ng-submit="enquiryForm.$valid && saveEnquiryData(enquiryData, 0)">
        <div class="row col-lg-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="form-title">Enquiry Details</div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Date of enquiry <span class="sp-err">*</span></label>
                            <div class="form-group" ng-controller="DatepickerDemoCtrl">
                                <p class="input-group">
                                    <input type="text"  ng-model="sales_enquiry_date" name="sales_enquiry_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="step" ng-messages="enquiryForm.sales_enquiry_date.$error" class="help-block step">
                                    <div ng-message="required">Please select enquiry date</div>
                                </div>
                                </p>
                            </div>{{ sales_enquiry_date }} rrrrr
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step && (!enquiryForm.enquiry_category_id.$dirty && enquiryForm.enquiry_category_id.$invalid)}">
                            <label for="">Enquiry Category <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="salesEnqCategoryCtrl" ng-model="enquiryData.enquiry_category_id" name="enquiry_category_id" required>
                                    <option value="">Please Select Category</option>                                       
                                    <option ng-repeat="list in salesEnqCategoryList" value="{{list.id}}">{{list.enquiry_category}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="step" ng-messages="enquiryForm.enquiry_category_id.$error" class="help-block step">
                                    <div ng-message="required">Please select enquiry category</div>
                                </div>
                            </span>
                        </div>
                    </div>                                                
<!--                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step && (!enquiryForm.followup_by_employee_id.$dirty && enquiryForm.followup_by_employee_id.$invalid)}">
                            <label for="">Followup By Employee <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="getEmployeesCtrl" ng-model="enquiryData.followup_by_employee_id"  name="followup_by_employee_id" required>
                                    <option value="0">Select Employee</option>
                                    <option ng-repeat="list in employeeList" value="{{list.id}}">{{list.first_name}} {{list.last_name}}</option>                                              
                                </select>
                                <i class="fa fa-sort-desc"></i>                                 
                            </span>
                            <div ng-show="step" ng-messages="enquiryForm.followup_by_employee_id.$error" class="help-block step">
                                <div ng-message="required">Please select Employee</div>
                            </div>
                        </div>{{ enquiryData.followup_by_employee_id }} 00000
                    </div>-->
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group"  ng-class="{ 'has-error' : step && (!enquiryForm.followup_by_employee_id.$dirty && enquiryForm.followup_by_employee_id.$invalid)}">
                            <label for="">Followup By Employee <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="getEmployeesCtrl" ng-model="enquiryData.followup_by_employee_id" name="followup_by_employee_id" required>
                                    <option ng-repeat="l in employeeList" value="{{l.id}}" ng-selected="{{l.id == enquiryData.followup_by_employee_id }}">{{l.first_name}} {{l.last_name}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                            <div ng-show="step" ng-messages="enquiryForm.followup_by_employee_id.$error" class="help-block step">
                                <div ng-message="required">Please Enter Budget</div>
                            </div>
                        </div>{{  enquiryData.followup_by_employee_id }}
                    </div> 
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group"  ng-class="{ 'has-error' : step && (!enquiryForm.max_budget.$dirty && enquiryForm.max_budget.$invalid)}">
                            <label for="">Max Budget<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" maxlength="7" ng-model="enquiryData.max_budget"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="max_budget" required>
                                <i class="fa fa-motorcycle"></i>
                            </span>
                            <div ng-show="step" ng-messages="enquiryForm.max_budget.$error" class="help-block step">
                                <div ng-message="required">Please Enter Budget</div>
                            </div>
                        </div>
                    </div> 
                </div>    
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step && (!enquiryForm.next_followup_date.$dirty && enquiryForm.next_followup_date.$invalid)}">
                            <label for="">Next Followup Date <span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="enquiryData.next_followup_date" name="next_followup_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="step" ng-messages="enquiryForm.next_followup_date.$error" class="help-block step">
                                    <div ng-message="required">Please select followup date</div>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">                          
                        <div ng-controller="TimepickerDemoCtrl">
                            <label for="">Next Followup Time <span class="sp-err">*</span></label>
                            <timepicker ng-model="enquiryData.next_followup_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="true"></timepicker>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step && (!enquiryForm.remarks.$dirty && enquiryForm.remarks.$invalid)}"> 
                            <label for="">Remarks<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <textarea class="form-control" ng-model="enquiryData.remarks" name="remarks" required></textarea>
                                <i class="fa fa-bullseye"></i>
                            </span>
                            <div ng-show="step" ng-messages="enquiryForm.remarks.$error" class="help-block step">
                                <div ng-message="required">Please enter remarks</div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Parking Required <span class="sp-err">*</span></label>
                            <div class="control-group">
                                <div class="radio">
                                    <label>
                                        <input name="parking_required" type="radio" ng-model="enquiryData.parking_required" value="1" class="colored-success">
                                        <span class="text">Yes </span>
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input name="parking_required" type="radio" ng-model="enquiryData.parking_required" value="0" class="colored-danger"  ng-checked="true">
                                        <span class="text"> No </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.parking_required == 1">
                        <div class="form-group" ng-class="{ 'has-error' : step && (!enquiryForm.parking_type.$dirty && enquiryForm.parking_type.$invalid)}">
                            <label for="">Parking Type <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="enquiryData.parking_type" name="parking_type">
                                    <option value="1">Common Parking</option>                                       
                                    <option value="2">Private Parking</option>                                       
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="step" ng-messages="enquiryForm.parking_type.$error" class="help-block step">
                                    <div ng-message="required">Please select parking type</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.parking_required == 1">
                        <div class="form-group">
                            <label for="">Number of 2 wheeler parkings required</label>
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" ng-model="enquiryData.two_wheeler_parkings_required"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="two_wheeler_parkings_required">
                                <i class="fa fa-motorcycle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.parking_required == 1">
                        <div class="form-group">
                            <label for="">Number of 4 wheeler parkings required</label>
                            <span class="input-icon icon-right">
                                <input class="form-control" type="text" ng-model="enquiryData.four_wheeler_parkings_required" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="four_wheeler_parkings_required">
                                <i class="fa fa-motorcycle"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step && (!enquiryForm.finance_required.$dirty && enquiryForm.finance_required.$invalid)}">
                            <label for="">Finance Required <span class="sp-err">*</span></label>                                
                            <div class="control-group">
                                <div class="radio">
                                    <label>
                                        <input name="finance_required" type="radio" ng-model="enquiryData.finance_required" value="1" class="colored-success">
                                        <span class="text">Yes </span>
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input name="finance_required" type="radio" ng-model="enquiryData.finance_required" value="0" class="colored-danger"  ng-checked="true">
                                        <span class="text"> No </span>
                                    </label>
                                </div>
                            </div>
                            <div ng-show="step" ng-messages="enquiryForm.finance_required.$error" class="help-block step">
                                <div ng-message="required">Please select finance required</div>
                            </div>                                
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.finance_required == 1">
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
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.finance_required_from == 1">
                        <div class="form-group">
                            <label for="">Select finance department colleague</label>
                            <span class="input-icon icon-right">
                                <select ng-controller="financeEmployees" ng-model="enquiryData.finance_employee_id" name="finance_employee_id" class="form-control" required>
                                    <option value="">Select Employee</option>
                                    <option ng-repeat="list in financeEmpList" value="{{list.id}}">{{list.first_name}} {{list.last_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div> 
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.finance_required_from == 2">
                        <div class="form-group">
                            <label for="">Select finance tie up agency</label>
                            <span class="input-icon icon-right">
                                <select ng-controller="agencyTieupCtrl" ng-model="enquiryData.finance_tieup_id" name="finance_tieup_id" class="form-control" required>
                                    <option value="">Select Finance Agency</option>
                                    <option ng-repeat="list in agencyTieupList" value="{{list.id}}">{{list.first_name}} {{list.last_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>

                </div>
                <div classs="row">
                    <div class="form-title">Preferences</div>
                    <div class="row col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-controller="enquiryCityCtrl" ng-class="{ 'has-error' : step && (!enquiryForm.city_id.$dirty && enquiryForm.city_id.$invalid)}">
                            <label for="">Preferred City <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="enquiryData.city_id" name="city_id" ng-change="changeLocations(enquiryData.city_id)">
                                    <option>Select Preferred city</option>     
                                    <option ng-repeat="list in cityList" value="{{list.city_id}}">{{ list.get_city_name.name}}</option>                                                                                                                
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group multi-sel-div" ng-class="{ 'has-error' : step && (!enquiryForm.enquiry_locations.$dirty && enquiryForm.enquiry_locations.$invalid)}">
                            <label for="">Preferred Area's<span class="sp-err">*</span></label>
                            <ui-select multiple ng-model="enquiryData.enquiry_locations"  name="enquiry_locations" theme="select2" ng-disabled="disabled">
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
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Interested In</label>
                            <div class="radio" style="margin-top: 0px;">
                                <label>
                                    <input type="radio" class="inverted" ng-model="enquiryData.property_possession_type" name="property_possession_type" value="1" ng-checked="true">
                                    <span class="text">Ready Possession </span>
                                </label>&nbsp;&nbsp;
                                <label>
                                    <input type="radio" class="inverted" checked="checked" ng-model="enquiryData.property_possession_type" name="property_possession_type" value="0">
                                    <span class="text">Under Construction</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12" ng-if="enquiryData.property_possession_type == 0">
                        <div class="form-group"  ng-class="{ 'has-error' : step && (!enquiryForm.property_possession_date.$dirty && enquiryForm.property_possession_date.$invalid)}">
                            <label for="">Tentative Possession Date</label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="enquiryData.property_possession_date" name="property_possession_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required >
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="step" ng-messages="enquiryForm.property_possession_date.$error" class="help-block step">
                                    <div ng-message="required">Please select tentative possession date</div>
                                </div>
                                </p>
                            </div>                               
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="form-title">Interested Projects</div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Project <span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-controller="projectCtrl" ng-model="enquiryData.project_id" name="project_id" class="form-control" ng-required="{{ projectsDetails.length > 0}}">
                                    <option value="">Select type</option>
                                    <option ng-repeat="plist in projectList" value="{{plist.id}}_{{plist.project_name}}">{{plist.project_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="step" ng-messages="enquiryForm.project_id.$error" class="help-block step">
                                    <div ng-message="required">Please select Project</div>
                                </div>
                            </span>
                        </div>                                                   
                    </div>                                                
                    <div ng-controller="blockTypeCtrl">
                        <div class="col-sm-3 col-md-3 col-xs-12">
                            <div class="form-group multi-sel-div">
                                <label for="">Select Blocks <span class="sp-err">*</span></label>	
                                <ui-select ng-change="checkBlockLength()" multiple ng-model="enquiryData.block_id"  name="block_id" theme="select2" ng-disabled="disabled">
                                    <ui-select-match placeholder='Select blocks'>{{$item.block_name}}</ui-select-match>
                                    <ui-select-choices repeat="list in blockTypeList | filter:$select.search">
                                        {{list.block_name}} 
                                    </ui-select-choices>
                                </ui-select>                                    
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-xs-12">
                            <div class="form-group multi-sel-div">
                                <label for="">Select Sub Blocks <span class="sp-err">*</span></label>	
                                <ui-select multiple ng-model="enquiryData.sub_block_id" name="sub_block_id" theme="select2" ng-disabled="disabled" ng-required="true" ng-change="checkSubBlockLength()">
                                    <ui-select-match placeholder='Select sub blocks'>{{ $item.block_sub_type}}</ui-select-match>
                                    <ui-select-choices repeat="list1 in subBlockList | filter:$select.search">
                                        {{list1.block_sub_type}} 
                                    </ui-select-choices>
                                </ui-select>
                                <div ng-show="emptySubBlockId" class="help-block step {{ applyClassSubBlock}}">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-12 col-xs-12">
                        <div class="">
                            <div class="widget-header">
                                <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Project List <span id="errContactDetails" class="errMsg"></span></span>
                                <button type="button" class="btn btn-primary" ng-click="addProjectRow( {{enquiryData.project_id}} )">Add Above Project</button> 
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
                                    <tbody>
                                        <tr  id="projectBody"><td colspan="5"><center>No Records Found</center></td>
                                    </tr>
                                    <tr  ng-repeat='list in projectsDetails'>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{ list.project_name}}</td>
                                        <td>{{ list.blocks}}</td>
                                        <td>{{ list.subblocks}}</td>                                               
                                        <td><div class="fa-hover" tooltip-html-unsafe="Project enquiry" style="display: block;">
                                                <!--<a href data-toggle="modal" data-target="#projectDataModal" ng-click="initContactModal()"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;-->
                                                <a href ng-click="removeRow({{ $index}})"><i class="fa fa-trash-o" aria-hidden="true"></i></a> &nbsp;&nbsp;
                                            </div>
                                        </td>
                                    </tr>                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="col-md-12 col-xs-12">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12" align="center">
                    <input type="submit" class="btn btn-primary" ng-click="step = true" value="Save">
                </div>
            </div>
        </div>
    </form>
</div>