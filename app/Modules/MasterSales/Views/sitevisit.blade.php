<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <h4><b>Mrs. Uma Shinde</b></h4>
                </div>
            </div>
        </div>
        <tabset>
            <tab heading="Add New Details" id="addNewTab">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                            
                        <form name="siteVisitForm" novalidate ng-submit="siteVisitForm.$valid && addNewSiteVisit(siteVisitData)"> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Project</label>
                                        <span class="input-icon icon-right">
                                            <ui-select ng-controller="projectCtrl" ng-model="siteVisitData.project_id" name="project_id" theme="bootstrap">
                                                <ui-select-match placeholder="Select Project">{{plist.project_name}}</ui-select-match>
                                                <ui-select-choices repeat="plist in projectList | filter: $select.search">
                                                    <div ng-bind-html="item.project_name | highlight: $select.search"></div>
                                                </ui-select-choices>
                                            </ui-select>
                                        </span>
                                    </div>
                                </div>                            
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Attended By</label>
                                        <span class="input-icon icon-right">
                                            <ui-select ng-controller="salesemployeesCtrl" ng-model="siteVisitData.followup_by_employee_id" name="followup_by_employee_id" theme="bootstrap">
                                                <ui-select-match placeholder="Select Employee" align="left">{{siteVisitData.followup_by_employee_id.first_name}}</ui-select-match>
                                                <ui-select-choices repeat="item in salesemployeeList | filter: $select.search">
                                                    <div ng-bind-html="item.first_name | highlight: $select.search"></div>
                                                </ui-select-choices>
                                            </ui-select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Visited Date & Time</label>
                                        <span class="input-icon icon-right">
                                            <p class="input-group">
                                                <input type="text" ng-model="siteVisitData.next_followup_date" name="next_followup_date" class="form-control followupdate" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" ng-change="todayremarkTimeChange(siteVisitData.next_followup_date)" readonly required/>
                                                <span class="input-group-btn" >
                                                    <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </p>
                                        </span>
                                    </div>
                                </div>                            
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Remark</label>
                                        <span class="input-icon icon-right">
                                            <textarea class="form-control" rows="2" cols="50" ng-model="siteVisitData.textRemark" name="textRemark" ng-required="divText" capitalization></textarea>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Next Followup Date & Time</label>
                                        <span class="input-icon icon-right">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="siteVisitData.next_followup_date" name="next_followup_date" class="form-control followupdate" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" ng-change="todayremarkTimeChange(siteVisitData.next_followup_date)" readonly required/>
                                                        <span class="input-group-btn" >
                                                            <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </div>

                                                <div class="col-sm-6">
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="siteVisitData.next_followup_time" name="next_followup_time" id="next_followup_time" class="form-control" required>
                                                            <option value=""> Select Time </option>
                                                            <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == siteVisitData.next_followup_time}}">{{time.label}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Enquiry Category</label>
                                        <span class="input-icon icon-right">
                                            <select class="form-control" ng-model="remarkData.sales_category_id" name="sales_category_id" id="sales_category_id" ng-change="getSubCategory(remarkData.sales_category_id)" required>
                                                <option value="">Select Category</option>
                                                <option ng-repeat="list in salesEnqCategoryList" ng-if="list.id != 1" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_category_id}}">{{list.enquiry_category}}</option>          
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="sbtBtn" ng-messages="remarkForm.sales_category_id.$error" class="help-block errMsg">
                                                <div ng-message="required">Please select category</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Schedule Revisit</label>
                                        <span class="input-icon icon-right">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" ng-model="mobile_number" ng-change="checkedMobileNo(mlist, $index)" value="{{mlist}}" id="mob_{{$index}}" class="clsMobile">
                                                    <span class="text">{{mlist}}</span>
                                                </label>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Schedule Revisit</label>
                                        <span class="input-icon icon-right">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="siteVisitData.next_followup_date" name="next_followup_date" class="form-control followupdate" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" ng-change="todayremarkTimeChange(siteVisitData.next_followup_date)" readonly required/>
                                                        <span class="input-group-btn" >
                                                            <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </div>

                                                <div class="col-sm-6">
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="siteVisitData.next_followup_time" name="next_followup_time" id="next_followup_time" class="form-control" required>
                                                            <option value=""> Select Time </option>
                                                            <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == siteVisitData.next_followup_time}}">{{time.label}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>                                     
                        </form>
                    </div>
                </div>
            </tab>
            <tab heading="Schedule Site Visit" id="scheduleTab">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                        <form name="siteVisitForm" novalidate ng-submit="siteVisitForm.$valid && insertTodayRemark(siteVisitData)">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Project</label>
                                        <span class="input-icon icon-right">
                                            <ui-select ng-controller="projectCtrl" ng-model="siteVisitData.project_id" name="project_id" theme="bootstrap">
                                                <ui-select-match placeholder="Select Project">{{plist.project_name}}</ui-select-match>
                                                <ui-select-choices repeat="plist in projectList | filter: $select.search">
                                                    <div ng-bind-html="item.project_name | highlight: $select.search"></div>
                                                </ui-select-choices>
                                            </ui-select>
                                        </span>
                                    </div>
                                </div>                            
                                <div class="col-sm-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Visit Date & Time</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="input-group">
                                                    <input type="text" ng-model="siteVisitData.next_followup_date" name="next_followup_date" class="form-control followupdate" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" ng-change="todayremarkTimeChange(siteVisitData.next_followup_date)" readonly required/>
                                                    <span class="input-group-btn" >
                                                        <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="col-sm-6">
                                                <span class="input-icon icon-right">
                                                    <select ng-model="siteVisitData.next_followup_time" name="next_followup_time" id="next_followup_time" class="form-control" required>
                                                        <option value=""> Select Time </option>
                                                        <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == siteVisitData.next_followup_time}}">{{time.label}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>SMS Template</label>
                                        <span class="input-icon icon-right">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" rows="2" cols="50" ng-model="siteVisitData.textRemark" name="textRemark" ng-required="divText" capitalization></textarea>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" ng-model="mobile_number" ng-change="checkedMobileNo(mlist, $index)" value="{{mlist}}" id="mob_{{$index}}" class="clsMobile">
                                                            <span class="text">{{mlist}}</span>
                                                        </label>
                                                        SMS Reminder &nbsp;&nbsp;&nbsp;
                                                    
                                                        <label>
                                                            <input type="checkbox" ng-model="mobile_number" ng-change="checkedMobileNo(mlist, $index)" value="{{mlist}}" id="mob_{{$index}}" class="clsMobile">
                                                            <span class="text">{{mlist}}</span>
                                                        </label>
                                                        Email Reminder
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!siteVisitForm.title_id.$dirty && siteVisitForm.title_id.$invalid)}">
                                        <label>Email Subject</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="remarkData.customer_fname" name="customer_fname" capitalization class="form-control" ng-required="editableCustInfo">                                            
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget flat radius-bordered">
                                        <div class="widget-header bordered-bottom bordered-themeprimary">
                                            <span class="widget-caption">Email Template</span>
                                        </div>
                                        <div class="widget-body no-padding">
                                            <div ng-controller="TextAngularCtrl">
                                                <div text-angular ng-model="projectData.brief_description" name="brief_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </tab>
            <tab heading="Upcoming/Pending" id="upcomingTab">

            </tab>
            <tab heading="History" id="historyTab">
                <table class="table table-hover table-striped table-bordered table-responsive">
                    <tbody>
                        <tr>
                            <td>Sr. No.</td>
                            <td>Project</td>
                            <td>Schedule Date & Time</td>
                            <td>Visit Date</td>
                            <td>Attended By</td>
                            <td>Remark</td>
                        </tr>
                        <tr align="center">
                            <td colspan="6">Record not found</td>
                        </tr>
                    </tbody>
                </table>
            </tab>
        </tabset>
    </div>
</div>

