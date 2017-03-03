<style>
    .btn-round{
        border-radius: 50%;
        height: 40px;
        width: 40px;
        line-height: 28px;
        padding-left: 13px;
        outline: none !important;
    }
    @media (min-width:768px){
        .modal-dialog {
            width: 700px !important;
        }
    }
</style>
<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="customerController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-sky col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" ng-submit="createCustomer(customerData, customerData.image_file, contactData)" name="customerForm">
                        <input type="hidden" ng-model="customerData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerData.csrfToken = '[[ csrf_token() ]]'" class="form-control">
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
                                                <input type="text" class="form-control" ng-model="customerData.searchWithMobile" get-customer-details minlength="10" maxlength="10" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")" ng-model-options="{allowInvalid: true, debounce: 100 }">
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
                                                <input type="email" class="form-control" get-customer-details ng-model="customerData.searchWithEmail" name="searchWithEmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{ allowInvalid: true, debounce: 500 }">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>  
                        <div class="row col-lg-12 col-sm-12 col-xs-12">  
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
                                                <div ng-show="sbtBtn" ng-messages="customerForm.title_id.$error" class="help-block">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>
                                                <div ng-if="title_id" class="errMsg">{{title_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15">
                                                <i class="fa fa-user"></i>
                                                <div ng-if="first_name" class="errMsg">{{first_name}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Middle Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.middle_name" name="middle_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Last Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15">
                                                <i class="fa fa-user"></i>
                                                <div ng-if="last_name" class="errMsg">{{last_name}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Gender</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="customerData.gender_id" name="gender_id" ng-controller="genderCtrl" class="form-control">
                                                    <option value="">Select Gender</option>
                                                    <option ng-repeat="genderList in genders track by $index" value="{{genderList.gender_id}}" ng-selected="{{ genderList.gender_id == customerData.gender}}">{{genderList.gender_title}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="gender_id" class="errMsg">{{gender_id}}</div>
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
                                                <div ng-if="birth_date"class="errMsg">{{birth_date}}</div>
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
                                                <div ng-if="marriage_date" class="errMsg">{{marriage_date}}</div>
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
                                                <select class="form-control" ng-model="customerData.profession_id" name="profession_id" ng-controller="professionCtrl">
                                                    <option value="">Select Profession</option>
                                                    <option ng-repeat="t in professions track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.profession}}">{{t.profession}}</option>
                                                </select>                
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="profession_id" class="errMsg">{{profession_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Monthly Income</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.monthly_income" name="monthly_income" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                <i class="fa fa-money"></i>
                                                <div ng-if="monthly_income" class="errMsg">{{monthly_income}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">SMS Privacy Status</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="customerData.sms_privacy_status" name="sms_privacy_status" class="form-control">
                                                    <option value="0">In active</option>
                                                    <option value="1">Active</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="sms_privacy_status" class="errMsg">{{sms_privacy_status}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Privacy Status</label>
                                            <span class="input-icon icon-right">                                                
                                                <select ng-model="customerData.email_privacy_status" name="email_privacy_status" class="form-control">
                                                    <option value="0">In active</option>
                                                    <option value="1">Active</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="email_privacy_status" class="errMsg">{{email_privacy_status}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Source</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.source_id" name="source_id" class="form-control">
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="source_id" class="errMsg">{{source_id}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Sub Source</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.subsource_id" name="subsource_id" class="form-control">
                                                <i class="fa fa-sort-desc"></i>
                                                <div ng-if="subsource_id" class="errMsg">{{subsource_id}}</div>
                                            </span>                                            
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Source Description</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="customerData.source_description" name="source_description" class="form-control">
                                                <i class="fa fa fa-align-left"></i>
                                                <div ng-if="source_description" class="errMsg">{{source_description}}</div>
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div> 
                            <hr class="wide col-md-12" />                            
                        </div>    
                        <div class="col-xs-12 col-md-12">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Contact List</span>
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
                                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#contactDataModal" ng-click="editContactDetails({{$index}})"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
                                                    </div>
                                                </td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr class="wide col-lg-12 col-xs-12 col-md-12" />
                        <div class="col-lg-12 col-xs-12 col-md-12" align="center">
                            <button type="submit" class="btn btn-primary" ng-click="sbtBtn = true">Save & Continue</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="contactDataModal" role="dialog" tabindex='-1'>
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" ng-click="closeModal()">&times;</button>
                            <h4 class="modal-title" align="center">Contact Details</h4>
                        </div>
                        <form ng-submit="addRow()">
                        <div class="modal-body">
                            <!--<div class="row col-lg-12 col-sm-12 col-xs-12">-->                           
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Number Type</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="contactData.mobile_number_lable" name="mobile_number_lable" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="1">Personal</option>
                                                    <option value="2">Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Mobile Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.mobile_number" name="mobile_number"  id="mobile_number" class="form-control" intl-Tel>
                                                <i class="glyphicon glyphicon-phone"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Landline Type</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="contactData.landline_lable" name="landline_lable" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="1">Personal</option>
                                                    <option value="2">Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Landline Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.landline_number" name="landline_number" id="landline_number" class="form-control" intl-Tel>
                                                <i class="glyphicon glyphicon-phone"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Type</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="contactData.email_id_lable" name="email_id_lable" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="1">Personal</option>
                                                    <option value="2">Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email ID</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.email_id" name="email_id" class="form-control">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Address</label>		
                                            <span class="input-icon icon-right">
                                                <select ng-model="contactData.address_type" name="address_type" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option>Personal</option>
                                                    <option>Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">House Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.house_number" name="house_number" class="form-control date-picker">
                                                <i class="fa fa-home"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Building House Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.building_house_name" name="building_house_name" class="form-control">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <span class="input-icon icon-right">
                                                <label for="">Wing Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="contactData.wing_name" name="wing_name" class="form-control">
                                                    <i class="fa fa-building-o"></i>
                                                </span> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Area Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.area_name" name="area_name" class="form-control date-picker">
                                                <i class="fa fa-building-o"></i>
                                            </span>                                      
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">                                            
                                            <label for="">Lane Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.lane_name" name="lane_name" class="form-control date-picker">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Landmark</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.landmark" name="landmark" class="form-control date-picker">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Pin</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.pin" name="pin" class="form-control">
                                                <i class="fa fa-compass" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Country</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.country_id" name="country_id" class="form-control date-picker">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.state_id" name="state_id" class="form-control">
                                                <i class="fa fa-compass" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.city_id" name="city_id" class="form-control">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Google Map Link</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="contactData.google_map_link" name="google_map_link" class="form-control">
                                                <i class="fa fa-compass" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Remarks</label>
                                            <span class="input-icon icon-right">
                                                <textarea ng-model="contactData.other_remarks" name="other_remarks" class="form-control"></textarea>
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>   
                            <!--</div>-->
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="submit" class="btn btn-sub" ng-click="changePassword(modal.empId)">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
