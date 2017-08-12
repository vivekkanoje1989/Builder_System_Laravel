<style>
    .close {
        color:black;
    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        /* background: rgba(173, 181, 185, 0.81); */
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
        width: 110%;
    }
</style>
<div class="row" ng-controller="contactUsCtrl" ng-init="manageContactUs(); manageCountry();">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Contact Us</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="search" name="search" class="form-control">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>

                    </div>
                </div>
                <div class="row" style="border:2px;" id="filter-show" ng-controller="adminController">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'address'" data-toggle="tooltip" title="Address"><strong> Address : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'pin_code'" data-toggle="tooltip" title="Pin Code"><strong> Pin Code : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'contact_person_name'" data-toggle="tooltip" title="Contact Person"><strong> Contact Person : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'email'" data-toggle="tooltip" title="Email"><strong> Email : </strong> {{ value}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>                       
                            <th style="width:25%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'address'; reverseSort = !reverseSort">Address
                                    <span ng-show="orderByField == 'address'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'pin_code'; reverseSort = !reverseSort">Pin code
                                    <span ng-show="orderByField == 'pin_code'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:25%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'contact_person_name'; reverseSort = !reverseSort">Contact person
                                    <span ng-show="orderByField == 'contact_person_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:35%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'email'; reverseSort = !reverseSort">Email
                                    <span ng-show="orderByField == 'email'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>                                                       
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="item in contactUsRow| filter:search | itemsPerPage:itemsPerPage | filter:searchData">
                            <td>{{$index + 1}}</td>
                            <td>{{item.address}}</td>     
                            <td>{{item.pin_code}}</td> 
                            <td>{{item.contact_person_name}}</td>  
                            <td>{{item.email}}</td>     
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" data-toggle="modal" data-target="#contactUsModal"><a href="javascript:void(0);" ng-click="initialModal({{ item.id}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
                <div data-ng-include="'/ContactUs/showFilter'"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="contactUsModal" role="dialog" tabindex="-1" ng-cloak>    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="contactUsForm.$valid && doContactusAction()" name="contactUsForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" ng-model="id" name="id">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.country_id.$dirty && contactUsForm.country_id.$invalid) }">
                                    <label>Country<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select id="country_id" name="country_id" class="form-control" ng-model="country_id" ng-options="item.id as item.name for item in countryRow" ng-change="manageStates()" required>
                                            <option value="">Select country</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.country_id.$error">
                                            <div ng-message="required">Country is required</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.state_id.$dirty && contactUsForm.state_id.$invalid) }">
                                    <label>State<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="state_id" name="state_id" ng-change="manageCity()" required>
                                            <option value="">Select state</option>
                                            <option  ng-repeat="itemone in statesRow" ng-selected="{{ state_id == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.state_id.$error">
                                            <div ng-message="required">State is required</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>                            
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.city_id.$dirty && contactUsForm.city_id.$invalid) }">
                                    <label>City<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="city_id" name="city_id" ng-change="manageLocationRow(city_id)" required>
                                            <option value="">Select city</option>
                                            <option  ng-repeat="itemtwo in cityRow" ng-selected="{{ city_id == itemtwo.id}}" value="{{itemtwo.id}}">{{itemtwo.name}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.city_id.$error">
                                            <div ng-message="required">City is required</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.location_id.$dirty && contactUsForm.location_id.$invalid) }">
                                    <label>Location<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select id="country_id" name="location_id" class="form-control" ng-model="location_id" ng-options="itemthree.id as itemthree.location for itemthree in locationRow" required>
                                            <option value="">Select location</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.location_id.$error">
                                            <div ng-message="required">Location is required</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>                            
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.address.$dirty && contactUsForm.address.$invalid) }">
                                    <label>Address<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <textarea col="50" row="2" class="form-control" ng-model="address" name="address" maxlength="250" required></textarea>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.address.$error">
                                            <div ng-message="required">Address is required</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group">
                                    <label>Contact Number</label> 
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="contact_number1" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  name="contact_number1"  maxlength="10" minlength="10">
                                    </span>
                                </div>
                            </div>
                        </div>                            
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group">
                                    <label>Alternate Number1</label>  
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="contact_number2" name="contact_number2" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="10" minlength="10">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group">
                                    <label>Alternate Number2</label>   
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="contact_number3" name="contact_number3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="10" minlength="10">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group">
                                    <label>Contact Person</label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="contact_person_name" name="contact_person_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="20">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.country_id.$dirty && contactUsForm.country_id.$invalid) }">
                                    <label>Pin Code<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="pin_code" name="pin_code"  maxlength="6" minlength="6" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.pin_code.$error">
                                            <div ng-message="required">Pin code is required</div>
                                            <div ng-message="minlength">Pin code must be 6 digits</div>
                                            <div ng-message="maxlength">Pin code must be 6 digits</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>                            
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group">
                                    <label>Email Address</label>  
                                    <span class="input-icon icon-right">
                                        <input type="email" class="form-control" ng-model="email" name="email">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 ">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!contactUsForm.country_id.$dirty && contactUsForm.country_id.$invalid) }">
                                    <label>Google Map Url<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="google_map_url" name="google_map_url"  required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="contactUsForm.google_map_url.$error">
                                            <div ng-message="required">Map is required</div>
                                        </div>
                                    </span>  
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 " align="center">
                                <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="contactUs">Update</button>
                            </div>
                        </div>
                    </div>                    
                </form>           
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="contactUsFilter" role="form" ng-submit="filterDetails(searchDetails)">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Address</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.address" name="address" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Contact Person</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.contact_person_name" name="contact_person_name" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Pin Code</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.pin_code" name="pin_code" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Email</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.email" name="email" class="form-control">
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>

