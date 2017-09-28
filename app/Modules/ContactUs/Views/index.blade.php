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
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Contact Us</span>                
            </div>

            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <!--                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View print view" ng-click="contactUsExportToxls()" ng-show="exportData == '1'">
                                                    <span>Export</span>
                                                </a>-->
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="contactUsExportToxls()" ng-show="exportData == '1'">Export</a>
                                </li>

                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
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
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>

                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:5%">Sr. No.</th>                       
                                <th style="width:25%">
                                    <a href="javascript:void(0);" ng-click="orderByField('address')">Address
                                        <span ><img ng-hide="(sortKey == 'address' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'address' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'address' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:8%">
                                    <a href="javascript:void(0);" ng-click="orderByField('pin_code')">Pin code
                                        <span ><img ng-hide="(sortKey == 'pin_code' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'pin_code' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'pin_code' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('contact_person_name')">Contact person
                                        <span ><img ng-hide="(sortKey == 'contact_person_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'contact_person_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'contact_person_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:30%">
                                    <a href="javascript:void(0);" ng-click="orderByField('email')">Email
                                        <span ><img ng-hide="(sortKey == 'email' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'email' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'email' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>                                                       
                                <th style="width: 12%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="item in contactUsRow| filter:search | itemsPerPage:itemsPerPage | filter:searchData | orderBy:sortKey:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{item.address}}</td>     
                                <td>{{item.pin_code}}</td> 
                                <td>{{item.contact_person_name}}</td>  
                                <td>{{item.email}}</td>     
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit" data-toggle="modal" data-target="#contactUsModal"><a href="javascript:void(0);" ng-click="initialModal({{ item.id}},{{$index}})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete" ><a href="" ng-click="confirm({{item.id}},{{$index}})"  class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6"  ng-show="(contactUsRow|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
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
    </div>
    <div class="modal fade modal-primary" id="contactUsModal" role="dialog" tabindex="-1" ng-cloak>    
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

