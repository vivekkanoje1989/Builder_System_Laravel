<div id="customer-form">
    <form novalidate role="form" name="customerForm" ng-submit="customerForm.$valid && createCustomer(customerData, customerData.image_file, contactData)">
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
                                <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" required capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" >
                                <i class="fa fa-user"></i>
                                <div ng-show="formButton" ng-messages="customerForm.first_name.$error" class="help-block errMsg">
                                    <div ng-message="required">Please enter first name</div>
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
                                    <div ng-message="required">Please enter last name</div>
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
                                <select ng-model="customerData.gender_id" name="gender_id" ng-controller="genderCtrl" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option ng-repeat="genderList in genders track by $index" value="{{genderList.id}}" ng-selected="{{ genderList.id == customerData.gender}}">{{genderList.gender}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="customerForm.gender_id.$error" class="help-block errMsg">
                                    <div ng-message="required">Please enter gender</div>
                                </div>
                                <div ng-if="gender_id" class="errMsg gender_id">{{gender_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Birth Date<span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="customerData.birth_date" name="birth_date" id="birth_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="formButton" ng-messages="customerForm.birth_date.$error" class="help-block errMsg">
                                    <div ng-message="required">Please select birth date</div>
                                </div>
                                <div ng-if="birth_date"class="errMsg birth_date">{{birth_date}}</div>
                                </p>
                            </div>                                           
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Marriage Date<span class="sp-err">*</span></label>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                <p class="input-group">
                                    <input type="text" ng-model="customerData.marriage_date" name="marriage_date" id="marriage_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                <div ng-show="formButton" ng-messages="customerForm.marriage_date.$error" class="help-block errMsg">
                                    <div ng-message="required">Please select marriage date</div>
                                </div>
                                <div ng-if="marriage_date"class="errMsg birth_date">{{marriage_date}}</div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Profession<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="customerData.profession_id" name="profession_id" ng-controller="professionCtrl" required>
                                    <option value="">Select Profession</option>
                                    <option ng-repeat="t in professions track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.profession}}">{{t.profession}}</option>
                                </select>                
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="customerForm.profession_id.$error" class="help-block errMsg">
                                    <div ng-message="required">Please enter profession</div>
                                </div>
                                <div ng-if="profession_id" class="errMsg profession_id">{{profession_id}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Monthly Income<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="customerData.monthly_income" name="monthly_income" class="form-control" ng-pattern="/^[1-9]\d*$/" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                                <i class="fa fa-money"></i>
                                <div ng-show="formButton" ng-messages="customerForm.monthly_income.$error" class="help-block errMsg">
                                    <div ng-message="required">Please enter monthly income</div>
                                    <div ng-message="pattern">Please enter valid income</div>
                                </div>
                                <div ng-if="monthly_income" class="errMsg monthly_income">{{monthly_income}}</div>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">SMS Privacy Status</label>
                            <span class="input-icon icon-right">
                                <select ng-model="customerData.sms_privacy_status" name="sms_privacy_status" class="form-control">
                                    <option value="0">In active</option>
                                    <option value="1">Active</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Email Privacy Status</label>
                            <span class="input-icon icon-right">                                                
                                <select ng-model="customerData.email_privacy_status" name="email_privacy_status" class="form-control" >
                                    <option value="0">In active</option>
                                    <option value="1">Active</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row" ng-controller="enquirySourceCtrl">
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
                                    <div ng-message="required">Please select source</div>
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
                            <label for="">Source Description<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="customerData.source_description" name="source_description" class="form-control" ng-disabled="disableSource" required>
                                <i class="fa fa fa-align-left"></i>
                                <div ng-show="formButton" ng-messages="customerForm.source_description.$error" class="help-block errMsg">
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
        <div class="col-xs-12 col-md-12" ng-if="showDivCustomer">
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
                                <td>
                                    <div class="fa-hover" tooltip-html-unsafe="Edit Contact" style="display: block;">
                                        <a href data-toggle="modal" data-target="#contactDataModal" ng-click="editContactDetails({{$index}})"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
                                    </div>
                                </td>
                            </tr>                                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xs-12 col-md-12" align="center" ng-disabled="disableCreateButton">
            <button type="submit" class="btn btn-primary" ng-show="showDivCustomer" id="custSubmitBtn" ng-click="formButton = true">{{btnLabelC}}</button>
            <button type="submit" class="btn btn-primary" ng-show="backBtn" ng-click="backToListing('{{searchData.searchWithMobile}}','{{searchData.searchWithEmail}}')"><< Back To List</button>
        </div>
    </form>
</div>