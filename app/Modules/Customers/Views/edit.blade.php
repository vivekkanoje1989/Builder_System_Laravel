<style>
    .actions {
        z-index: 0 !important;
    }
    .help-block {
        margin-top: 0px !important; 
        margin-bottom: 0px !important; 
        color:red;
    }
    input[capitalizeFirst]{ text-transform: capitalize; }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Edit Customer</span>
            </div>
            <div class="widget-body">
                <form name="customerForm" novalidate ng-submit="customerForm.$valid && updateCustomer(customerData, customerData.image_file)" ng-controller="customerCtrl"  ng-init="getcustomerdata('<?php echo $custId; ?>')">
                <input type="hidden" ng-model="customerForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                <input type="hidden" ng-model="customerForm.id" name="id" id="id" ng-init="customerForm.id = '<?php ?>'" class="form-control">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="form-title">Customer Information</div>
                            <div class="row">
                                <input type="hidden" ng-model="customerData.id" name="id" >
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.title_id.$dirty && customerForm.title_id.$invalid)}">
                                        <label for="">Title <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-controller="titleCtrl" ng-model="customerData.title_id" name="title_id" class="form-control" ng-change="checkTitle()" required>
                                                <option value="">Select Title</option>
                                                <option ng-repeat="t in titles track by $index" ng-selected="customerData.title_id == t.id" value="{{t.id}}">{{t.title}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.title_id.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <div ng-if="title_id" class="sp-err title_id">{{title_id}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.first_name.$dirty && customerForm.first_name.$invalid)}">
                                        <label for="">First Name <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerData.first_name" name="first_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15"  required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.first_name.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-message="maxlength">First name not more than 15 characters long.</div>
                                            </div>
                                             <div ng-if="first_name" class="sp-err first_name">{{first_name}}</div>
                                        </span>                                
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Middle Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerData.middle_name" name="middle_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" >
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.last_name.$dirty && customerForm.last_name.$invalid)}">
                                        <label for="">Last Name <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="customerData.last_name" name="last_name" class="form-control" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15"  required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.last_name.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-message="maxlength">First name not more than 15 characters long.</div>
                                            </div>
                                            <div ng-if="last_name" class="sp-err first_name">{{last_name}}</div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.gender_id.$dirty && customerForm.gender_id.$invalid)}">
                                        <label for="">Gender <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-controller="genderCtrl" ng-model="customerData.gender_id" name="gender_id" class="form-control" required>
                                                <option value="">Select Gender</option>
                                                <option ng-repeat="gender in genders" ng-selected="customerData.gender_id == gender.id"  value="{{gender.id}}">{{gender.gender}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.gender.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <div ng-if="gender_id" class="sp-err gender_id">{{gender_id}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.profession_id.$dirty && customerForm.profession_id.$invalid)}">
                                        <label for="">Profession <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-controller="professionCtrl" ng-model="customerData.profession_id" name="profession_id" class="form-control" required>
                                                <option value="">Select Title</option>
                                                <option ng-repeat="profession in professions" ng-selected="customerData.profession_id == profession.id"  value="{{profession.id}}">{{profession.profession}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.profession_id.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <div ng-if="profession_id" class="sp-err profession_id">{{profession_id}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.monthly_income.$dirty && customerForm.monthly_income.$invalid)}">
                                            <label for="">Monthly Income<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.monthly_income" name="monthly_income" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>                                    
                                                <i class="fa fa-money"></i>
                                            </span>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.monthly_income.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <div ng-if="monthly_income" class="sp-err monthly_income">{{monthly_income}}</div>
                                        </div>
                                    </div>
                                </div>                        

                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="">Aadhar Card Number<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.aadhar_number" name="aadhar_number" ng-maxlength="12" ng-minlength="12" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                                                <div ng-show="sbtBtn" ng-messages="customerForm.aadhar_number.$error" class="help-block">
                                                    <div ng-message="required">This field is required.</div>
                                                    <div ng-message="minlength">Aadhar card number must be 12 digits.</div>
                                                    <div ng-message="maxlength">Aadhar card number must be 12 digits.</div>
                                                </div>
                                                <div ng-if="aadhar_number" class="sp-err aadhar_number">{{aadhar_number}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">     
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="">Pan Card Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.pan_number" name="pan_number" class="form-control">
                                            </span>
                                        </div>
                                    </div>
                                </div> 

                                <div class="col-sm-3 col-xs-6">
                                    <label>Birth Date <span class="sp-err">*</span></label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.birth_date.$dirty && customerForm.birth_date.$invalid)}">
                                        <p class="input-group">
                                            <input type="text" ng-model="customerData.birth_date" name="birth_date" id="birth_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                        <div ng-show="sbtBtn" ng-messages="customerForm.birth_date.$error" class="help-block">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                         <div ng-if="birth_date" class="sp-err birth_date">{{birth_date}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <label>Marriage Date </label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <input type="text" ng-model="customerData.marriage_date" name="marriage_date" id="marriage_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-xs-6">
                                    <label>Sms Privacy Status<span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.sms_privacy_status.$dirty && customerForm.sms_privacy_status.$invalid)}">
                                        <p class="input-icon icon-right">
                                            <select ng-model="customerData.sms_privacy_status" name="sms_privacy_status" id="sms_privacy_status" class="form-control" required>
                                                <option value="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </p>
                                        <div ng-show="sbtBtn" ng-messages="customerForm.sms_privacy_status.$error" class="help-block">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                        <div ng-if="sms_privacy_status" class="sp-err sms_privacy_status">{{sms_privacy_status}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-controller="enquirySourceCtrl" >
                                <div class="col-sm-3 col-xs-6">
                                    <label>Email Privacy Status<span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.email_privacy_status.$dirty && customerForm.email_privacy_status.$invalid)}">
                                        <p class="input-icon icon-right">
                                            <select ng-model="customerData.email_privacy_status" name="email_privacy_status" id="email_privacy_status" class="form-control" required>
                                                <option value="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </p>
                                        <div ng-show="sbtBtn" ng-messages="customerForm.email_privacy_status.$error" class="help-block">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                        <div ng-if="email_privacy_status" class="sp-err email_privacy_status">{{email_privacy_status}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!customerForm.source_id.$dirty && customerForm.source_id.$invalid)}">
                                        <label for="">Source <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select  ng-model="customerData.source_id" name="source_id" class="form-control" ng-change="onEnquirySourceChange(customerData.source_id)" required>
                                                <option value="">Select Source</option>
                                                <option ng-repeat="source in sourceList"  ng-selected="customerData.source_id == source.id"  value="{{source.id}}">{{source.sales_source_name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="sbtBtn" ng-messages="customerForm.source_id.$error" class="help-block">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <div ng-if="source_id" class="sp-err source_id">{{source_id}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="">Sub source</label>
                                        <span class="input-icon icon-right">
                                            <select  ng-model="customerData.subsource_id" name="subsource_id" class="form-control">                          
                                                <option value="">Select Sub Source</option>
                                                <option ng-repeat="sub in subSourceList" ng-selected="subsource_id == sub.id" value="{{sub.id}}">{{sub.sub_source}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.source_description.$dirty && requestLeave.source_description.$invalid) }">
                                        <label>Source Description<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="customerData.source_description" name="source_description" class="form-control" required></textarea>
                                        </span>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.source_description.$error">
                                            <div ng-message="required">Source Description is required.</div>
                                        </div>
                                         <div ng-if="source_description" class="sp-err source_description">{{source_description}}</div>
                                        <br/>
                                    </div>
                                </div>
        <!--                        <div class="col-sm-3 col-xs-6">
                                    <label for="">Customer Image File</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="customerData.image_file" name="image_file" id="image_file" accept="image/*" ngf-max-size="2MB" class="form-control"  ngf-model-invalid="errorFile" >
                                       <br/>
                                        <img id="empPhotoPreview" ng-src="[[ Session::get('s3Path') ]]Customer/{{image}}" alt="Image" width="80px" height="80px" class="thumb"/>
                                    </span> 
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12" align="right">
                                    <button type="submit" class="btn btn-primary" ng-click="sbtBtn = true">Update</button>
                                    <a href="[[ config('global.backendUrl') ]]#/customers/index" class="btn btn-primary"><< Back to list</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>    
            </div>
	</div>
    </div>
</div>