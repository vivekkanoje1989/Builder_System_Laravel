<form novalidate role="form" name="custContactForm" ng-submit="custContactForm.$valid && createCustomer(customerData, customerData.image_file, contactData)">
                        <input type="hidden" ng-model="customerData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerData.csrfToken = '[[ csrf_token() ]]'" class="form-control">
                        <input type="hidden" ng-model="searchData.customerId" name="customerId" id="custId" value="{{customerData.customerId}}" class="form-control">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-title">
                                    Customer Details  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Mobile Number</label>
                                            <span class="input-icon icon-right">                                    
                                                <input type="text" class="form-control" ng-model="searchData.searchWithMobile" get-customer-details-directive minlength="10" maxlength="10" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100 }" ng-change="checkValue(customerData.searchWithMobile)">
                                                <i class="glyphicon glyphicon-phone"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerData.searchWithMobile.$error" class="help-block">
                                                    <div ng-message="minlength">Invalid mobile no.</div>
                                                    <div ng-message="customerInputs">Mobile number does not exist!</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email ID</label>
                                            <span class="input-icon icon-right">
                                                <input type="email" class="form-control" get-customer-details-directive ng-model="searchData.searchWithEmail" name="searchWithEmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{ allowInvalid: true, debounce: 500 }" ng-change="checkValue(customerData.searchWithEmail)">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>  
                        <div class="row col-lg-12 col-sm-12 col-xs-12" ng-if="showDiv">
                            <hr class="wide" />
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-title">
                                    Personal Details
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="customerData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required>
                                                    <option value="">Select Title</option>
                                                    <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i> 
                                                <div ng-show="formSbtBtn" ng-messages="custContactForm.title_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                                <div ng-if="title_id" class="errMsg title_id">{{title_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                                <i class="fa fa-user"></i>
                                                <div ng-show="formSbtBtn" ng-messages="custContactForm.first_name.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please enter first name</div>
                                                </div>
                                                <div ng-if="first_name" class="errMsg first_name">{{first_name}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Middle Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.middle_name" name="middle_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="17">
                                                <i class="fa fa-user"></i>
                                                <div ng-if="middle_name" class="errMsg middle_name">{{middle_name}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Last Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                                <i class="fa fa-user"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.last_name.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please enter last name</div>
                                                </div>
                                                <div ng-if="last_name" class="errMsg last_name">{{last_name}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Gender</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="customerData.gender_id" name="gender_id" ng-controller="genderCtrl" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option ng-repeat="genderList in genders track by $index" value="{{genderList.gender_id}}" ng-selected="{{ genderList.gender_id == customerData.gender}}">{{genderList.gender_title}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.gender_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please enter gender</div>
                                                </div>
                                                <div ng-if="gender_id" class="errMsg gender_id">{{gender_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Birth Date</label>
                                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                <p class="input-group">
                                                    <input type="text" ng-model="customerData.birth_date" name="birth_date" id="birth_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                    <div ng-show="sbtBtn" ng-messages="customerForm.birth_date.$error" class="help-block errMsg">
                                                        <div ng-message="required">Please select birth date</div>
                                                    </div>
                                                    <div ng-if="birth_date"class="errMsg birth_date">{{birth_date}}</div>
                                                </p>
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Marriage Date</label>
                                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                <p class="input-group">
                                                    <input type="text" ng-model="customerData.marriage_date" name="marriage_date" id="marriage_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                    <div ng-show="sbtBtn" ng-messages="customerForm.marriage_date.$error" class="help-block errMsg">
                                                        <div ng-message="required">Please select marriage date</div>
                                                    </div>
                                                    <div ng-if="marriage_date" class="errMsg marriage_date">{{marriage_date}}</div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Profession</label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="customerData.profession_id" name="profession_id" ng-controller="professionCtrl" required>
                                                    <option value="">Select Profession</option>
                                                    <option ng-repeat="t in professions track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.profession}}">{{t.profession}}</option>
                                                </select>                
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.profession_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please enter profession</div>
                                                </div>
                                                <div ng-if="profession_id" class="errMsg profession_id">{{profession_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Monthly Income</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.monthly_income" name="monthly_income" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                                                <i class="fa fa-money"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.monthly_income.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please enter monthly income</div>
                                                </div>
                                                <div ng-if="monthly_income" class="errMsg monthly_income">{{monthly_income}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">SMS Privacy Status</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="customerData.sms_privacy_status" name="sms_privacy_status" class="form-control" required>
                                                    <option value="0">In active</option>
                                                    <option value="1">Active</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.sms_privacy_status.$error" class="help-block errMsg">
                                                    <div ng-message="required">This field is required</div>
                                                </div>
                                                <div ng-if="sms_privacy_status" class="errMsg sms_privacy_status">{{sms_privacy_status}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Privacy Status</label>
                                            <span class="input-icon icon-right">                                                
                                                <select ng-model="customerData.email_privacy_status" name="email_privacy_status" class="form-control" required>
                                                    <option value="0">In active</option>
                                                    <option value="1">Active</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="email_privacy_status" class="errMsg email_privacy_status">{{email_privacy_status}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" ng-controller="enquirySourceCtrl">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Source</label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-change="onEnquirySourceChange()" ng-model="customerData.source_id" name="source_id" id="source_id" required>
                                                    <option value="">Select Source</option>
                                                    <option ng-repeat="source in sourceList" value="{{source.id}}" ng-selected="{{source.id == customerData.source_id}}">{{source.source_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.source_id.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please select source</div>
                                                </div>
                                                <div ng-if="source_id" class="errMsg source_id">{{source_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Sub Source</label>
                                            <span class="input-icon icon-right">
                                                <select class="form-control" ng-model="customerData.subsource_id" name="subsource_id" id="subsource_id">
                                                    <option value="">Select SubSource</option>
                                                    <option ng-repeat="subSource in subSourceList" value="{{subSource.id}}" ng-selected="{{subSource.id == customerData.subsource_id}}">{{subSource.sub_source}}</option>
                                                </select>   
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="subsource_id" class="errMsg subsource_id">{{subsource_id}}</div>
                                            </span>                                            
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Source Description</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.source_description" name="source_description" class="form-control" required>
                                                <i class="fa fa fa-align-left"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.source_description.$error" class="help-block errMsg">
                                                    <div ng-message="required">Please enter source description</div>
                                                </div>
                                                <div ng-if="source_description" class="errMsg source_description">{{source_description}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div> 
                            <hr class="wide col-md-12" />                            
                        </div>    
                        <div class="col-xs-12 col-md-12" ng-if="showDiv">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Contact List <span id="errContactDetails" class="errMsg"></span></span>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#contactDataModal" ng-click="initContactModal()">Add new contact</button> 
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Sr. No. </th>
                                                <th>Mobile Number</th>
                                                <th>Landline Number</th>
                                                <th>Email ID</th>
                                                <th>Pin</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in contacts">
                                                <td>{{$index + 1}}</td>
                                                <td>{{list.mobile_number}}</td>
                                                <td>{{list.landline_number}}</td>
                                                <td>{{list.email_id}}</td>
                                                <td>{{list.pin}}</td>
                                                <td><div class="fa-hover" tooltip-html-unsafe="Edit User" style="display: block;">
                                                        <a href data-toggle="modal" data-target="#contactDataModal" ng-click="editContactDetails({{$index}})"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
                                                    </div>
                                                </td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr class="wide col-lg-12 col-xs-12 col-md-12" ng-if="showDiv"/>
                        <div class="col-lg-12 col-xs-12 col-md-12" align="center" ng-if="showDiv">
                            <button type="button" class="btn btn-primary" ng-click="formSbtBtn=true">Save & Continue</button>
                        </div>
                    </form>