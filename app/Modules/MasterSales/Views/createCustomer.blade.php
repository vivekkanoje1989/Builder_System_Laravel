<div id="customer-form">
    <form novalidate role="form" name="customerForm" ng-submit="customerForm.$valid && createCustomer(customerData, customerData.image_file, contactData)">
        <input type="hidden" ng-model="customerData.id" name="id" value="{{customerData.id}}">
        <div class="row col-lg-12 col-sm-12 col-xs-12" ng-if="showDivCustomer">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="form-title">
                    Personal Details
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Title<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-model="customerData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required>
                                    <option value="">Select Title</option>
                                    <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i> 
                                <div ng-show="formButton" ng-messages="customerForm.title_id.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="title_id" class="errMsg title_id">{{title_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">First Name<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                <i class="fa fa-user"></i>
                                <div ng-show="formButton" ng-messages="customerForm.first_name.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="first_name" class="errMsg first_name">{{first_name}}</div>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Middle Name</label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="customerData.middle_name" name="middle_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="17">
                                <i class="fa fa-user"></i>
                                <div ng-if="middle_name" class="errMsg middle_name">{{middle_name}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Last Name<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                <i class="fa fa-user"></i>
                                <div ng-show="formButton" ng-messages="customerForm.last_name.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="last_name" class="errMsg last_name">{{last_name}}</div>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Gender<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-model="customerData.gender_id" name="gender_id" id="gender_id" ng-controller="genderCtrl" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option ng-repeat="genderList in genders track by $index" value="{{genderList.id}}" ng-selected=" genderList.id == customerData.gender_id">{{genderList.gender}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="customerForm.gender_id.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="gender_id" class="errMsg gender_id">{{gender_id}}</div>
                            </span>
                        </div>
                    </div>                    
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Birth Date</label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="customerData.birth_date" name="birth_date" id="birth_date" class="form-control" datepicker-popup="dd-MM-yyyy"  is-open="opened" max-date="maxDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event,3)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                            </div>                                           
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Profession</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="customerData.profession_id" name="profession_id" id="profession_id" ng-controller="professionCtrl">
                                    <option value="">Select Profession</option>
                                    <option ng-repeat="t in professions track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.profession_id }}">{{t.profession}}</option>
                                </select>                
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="customerForm.profession_id.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="profession_id" class="errMsg profession_id">{{profession_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Monthly Income</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="customerData.monthly_income" name="monthly_income" class="form-control" ng-pattern="/^[1-9]\d*$/" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="6">
                                <i class="fa fa-rupee"></i>
                                <div ng-show="formButton" ng-messages="customerForm.monthly_income.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                    <div ng-message="pattern">Please enter valid income</div>
                                </div>
                                <div ng-if="monthly_income" class="errMsg monthly_income">{{monthly_income}}</div>
                            </span>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="row" ng-controller="enquirySourceCtrl">
                    <div class="col-sm-3 col-md-3 col-xs-12">                        
                        <div class="form-group">
                            <label for="">Marriage Date</label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="customerData.marriage_date" name="marriage_date" id="marriage_date" class="form-control" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event,3)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="formButton" ng-messages="customerForm.marriage_date.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="marriage_date"class="errMsg marriage_date">{{marriage_date}}</div>
                                </p>
                            </div>
                        </div>
                    </div>                    
<!--                </div>
                <div class="row" ng-controller="enquirySourceCtrl">-->
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Source<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select ng-change="onEnquirySourceChange(customerData.source_id)" class="form-control" ng-model="customerData.source_id" name="source_id"  id="source_id" ng-disabled="disableSource" required>
                                    <option value="">Select Source</option>
                                    <option ng-repeat="source in sourceList" value="{{source.id}}" ng-selected="{{source.id == customerData.source_id}}">{{source.sales_source_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="customerForm.source_id.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="source_id" class="errMsg source_id">{{source_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Sub Source</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="customerData.subsource_id" name="subsource_id" id="subsource_id" ng-disabled="disableSource">
                                    <option value="">Select SubSource</option>
                                    <option ng-repeat="subSource in subSourceList" value="{{subSource.id}}" ng-selected="{{subSource.id == customerData.subsource_id}}">{{subSource.sub_source}}</option>
                                </select>   
                                <i class="fa fa-sort-desc"></i>
                                <div ng-if="subsource_id" class="errMsg subsource_id">{{subsource_id}}</div>
                            </span>                                            
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Source Description</label>
                            <span class="input-icon icon-right">
                                <textarea ng-model="customerData.source_description" name="source_description" maxlength="50" class="form-control" ng-disabled="disableSource"></textarea>
                                
                                <!--<input type="text" ng-model="customerData.source_description" name="source_description" class="form-control" ng-disabled="disableSource">-->
                                <i class="fa fa fa-align-left"></i>
                                <div ng-show="formButton" ng-messages="customerForm.source_description.$error" class="help-block errMsg">
                                    <div ng-message="required">This field is required</div>
                                </div>
                                <div ng-if="source_description" class="errMsg source_description">{{source_description}}</div>
                            </span>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" >
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <label>
                                    <input type="checkbox" ng-model="customerData.corporate_customer"name="corporate_customer" id="corporateCust" ng-click="isChecked(customerData.corporate_customer)">
                                    <span class="text"> Corporate Customer</span>
                                </label>
                            </span>	
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3 col-xs-12" >
                        <div class="form-group" ng-if="companyInput">
                            <label for="">Company Name<span class="sp-err">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Company name" maxlength="50"  name="company_name" ng-model="customerData.company_name" ng-keyup="getCompanyList(customerData.company_name)" ng-required="companyInput == '1'">
                            <ul class="companyField" ng-if="company_list.length > 0 && showComapnyList">
                                <li ng-repeat="company in company_list| filter : customerData.company_name" ng-click="setCompany(company)"><span>{{company.company_name}}</span></li>
                            </ul> 
                            <div ng-show="formButton" ng-messages="customerForm.company_name.$error" class="help-block">
                                <div ng-message="required" style="color: red !important;">This field is required</div>
                                <div ng-message="maxlength" style="color: red !important;">Maximum 50 Characters Allowed</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">SMS Privacy Status</label>
                            <span class="fa fa-toggle-on toggleClassActive" ng-if="customerData.sms_privacy_status === 1" ng-click="changeSmsPrivacyStatus(0);"></span>
                            <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-if="customerData.sms_privacy_status === 0" ng-click="changeSmsPrivacyStatus(1);"></span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Email Privacy Status</label>
                            <span class="fa fa-toggle-on toggleClassActive" ng-if="customerData.email_privacy_status === 1" ng-click="changeEmailPrivacyStatus(0);"></span>
                            <span class="fa fa-toggle-on fa-rotate-180 toggleClassInactive" ng-if="customerData.email_privacy_status === 0" ng-click="changeEmailPrivacyStatus(1);"></span>
                        </div>
                    </div>
                </div>
            </div> 
            <hr class="wide col-md-12" /> 
        </div> 
        <div class="col-xs-12 col-md-12" ng-if="showDivCustomer">
            <div class="widget">                                
                <div class="widget-header">
                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Contact List <span id="errContactDetails" class="errMsg"></span></span>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#contactDataModal" ng-click="initContactModal()" style="margin: 10px;">Add new contact</button> 
                </div>
                <div class="widget-body table-responsive">
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th>Sr. No. </th>
                                <th>Mobile Number</th>
                                <th>Landline Number</th>
                                <th>Email ID</th>
                                <th>Pin Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="list in contacts">
                                <td>{{$index + 1}}</td>
                                <td><span ng-if="list.mobile_calling_code != '+NaN' && list.mobile_calling_code != '0' && list.mobile_calling_code != '' ">{{list.mobile_calling_code}} </span>
                                    <span ng-if="displayMobile != '1'">{{ list.mobile_number }}</span>
                                    <span ng-if="displayMobile == '1'">{{ list.mobile_number | mobileHider }}</span>
                                    <span ng-if="list.mobile_number == ''"> - </span>
                                </td>
                                <td><span ng-if="list.landline_number == ''"> - </span>
                                    <span ng-if="list.landline_number != ''"> 
                                        {{list.landline_calling_code}} 
                                        {{list.landline_number}}
                                    </span>
                                </td>
                                <td>
                                    <span ng-if="displayMobile != '1'">{{ list.email_id }}</span>
                                    <span ng-if="displayMobile == '1'">{{ list.email_id | emailHider }}</span>
                                </td>
                                <td>{{list.pin}}</td>
                                <td>
                                    <div class="fa-hover"  >
                                        <a href data-toggle="modal" data-target="#contactDataModal" ng-click="editContactDetails({{$index}})" tooltip-html-unsafe="Edit Contact"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
                                    </div>
                                </td>
                            </tr>                                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xs-12 col-md-12" align="center" ng-disabled="disableCreateButton">
            <button type="submit" class="btn btn-primary" ng-show="showDivCustomer" id="custSubmitBtn" ng-disabled="custSubmitBtn" ng-click="formButton = true">{{btnLabelC}}</button>
            <button class="btn btn-primary" ng-show="backBtn" ng-click="backToListing('{{searchData.searchWithMobile}}','{{searchData.searchWithEmail}}','0')">Cancel</button>
        </div>
    </form>
</div>