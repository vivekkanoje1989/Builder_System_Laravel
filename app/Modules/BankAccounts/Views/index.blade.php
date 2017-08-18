<style>
    ul.dropdown-menu li {
        cursor: pointer;
    }

    ul.dropdown-menu li span.red {
        color: red;
    }

    ul.dropdown-menu li span.green {
        color: green;
    }
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
<div class="row" ng-controller="bankAccountsCtrl" ng-init="manageBankAccounts(); manageCompanys();">
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Bank Accounts</span>                
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
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a title="Create bank account" class="btn btn-primary btn-right" data-toggle="modal" ng-click="initialModel('0', '', '', '')" data-target="#bankAccountModal" >Create Bank Account</a>
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                            </span>
                        </div>
                    </div>
                </div> 
                <!-- filter data-->
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'legal_name'" data-toggle="tooltip" title=""><strong> Project Name : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'name'" data-toggle="tooltip" title="Name"><strong> Name : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'account_type'" data-toggle="tooltip" title="Account Type"><strong> Account Type : </strong> {{ value == '1' ? "Saving":"Current"}}</strong>
                                    <strong ng-if="key === 'account_number'" data-toggle="tooltip" title="Account Number"><strong> Account Number : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'branch'" data-toggle="tooltip" title="Branch"><strong> Branch  : </strong> {{ value}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">Sr. No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>                       
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'legal_name'; reverseSort = !reverseSort">Company
                                    <span ng-show="orderByField == 'legal_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'name'; reverseSort = !reverseSort">Name
                                    <span ng-show="orderByField == 'name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'branch'; reverseSort = !reverseSort">Branch
                                    <span ng-show="orderByField == 'branch'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'account_type'; reverseSort = !reverseSort">Account Type
                                    <span ng-show="orderByField == 'account_type'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:15%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'account_number'; reverseSort = !reverseSort">Account Number
                                    <span ng-show="orderByField == 'account_number'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>                               
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="item in bankAccountRow| filter:search |filter:searchData | orderBy:orderByField:reverseSort |itemsPerPage:itemsPerPage">
                            <td>{{$index + 1}}</td>
                            <td>{{item.legal_name}}</td>  
                            <td>{{item.name}}</td>     
                            <td>{{item.branch}}</td> 
                            <td>{{item.account_type == '1' ? "Saving":"Current"}}</td>
                            <td>{{item.account_number}}</td>  
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" data-toggle="modal" data-target="#bankAccountModal"><a href="javascript:void(0);" ng-click="initialModel({{ item.id}},{{item}},{{itemsPerPage}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listUsersLength }} entries</div>-->
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bankAccountModal" role="dialog" tabindex="-1" ng-cloak  ng-init="managePaymentHeading()">    
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="bankAccountForm.$valid && doBankAccountAction(bankAccount)" name="bankAccountForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" class="form-control" ng-model="id" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.company_id.$dirty && bankAccountForm.company_id.$invalid)}">
                                    <label>Account Type<span class="sp-err">*</span></label>  
                                    <span class="input-icon icon-right">
                                        <select ng-model="bankAccount.company_id" name="company_id" class="form-control" required>
                                            <option value="">Select Company</option>
                                            <option ng-repeat="list in companyRow" ng-selected="company == list.id"  value="{{list.id}}">{{list.legal_name}}</option>
                                        </select>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.company_id.$error">
                                            <div ng-message="required" class="err">Select company</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>
                            <div class="col-md-6">       
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.name.$dirty && bankAccountForm.name.$invalid)}">
                                    <input type="hidden" class="form-control" ng-model="id" name="id">
                                    <label>Bank Name<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="bankAccount.name" name="name" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.name.$error">
                                            <div ng-message="required" class="err">Bank name is required</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">    
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.branch.$dirty && bankAccountForm.branch.$invalid)}">
                                    <label>Bank Branch<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="bankAccount.branch" name="branch" oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')"  required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.branch.$error">
                                            <div ng-message="required" class="err">Branch name is required</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>  <div class="col-md-6">          
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.ifsc.$dirty && bankAccountForm.ifsc.$invalid)}">
                                    <label>IFSC Code<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="bankAccount.ifsc" name="ifsc"   required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.ifsc.$error">
                                            <div ng-message="required" class="err">IFSC code is required</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">        
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.micr.$dirty && bankAccountForm.micr.$invalid)}">
                                    <label>MICR Code<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="bankAccount.micr" name="micr"   required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.micr.$error">
                                            <div ng-message="required" class="err">MICR Code is required</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>  
                            <div class="col-md-6">               
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.account_number.$dirty && bankAccountForm.account_number.$invalid)}">
                                    <label>Account Number<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="bankAccount.account_number" name="account_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.account_number.$error">
                                            <div ng-message="required" class="err">Account number is required</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>    
                        </div>    
                        <div class="row">
                            <div class="col-md-6">  
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.account_type.$dirty && bankAccountForm.account_type.$invalid)}">
                                    <label>Account Type<span class="sp-err">*</span></label>  
                                    <span class="input-icon icon-right">
                                        <select ng-model="bankAccount.account_type" name="account_type" class="form-control" required>
                                            <option value="">Select account type</option>
                                            <option value="1">Saving account</option>
                                            <option value="2">Current account</option>
                                        </select>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.account_type.$error">
                                            <div ng-message="required" class="err">Account type is required</div>
                                        </div>                                        
                                    </span>                                    
                                </div>
                            </div>  
                            <div class="col-md-6">         
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.address.$dirty && bankAccountForm.address.$invalid)}">
                                    <label>Address<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <textarea  ng-model="bankAccount.address" name="address" required rows="2" cols="50"></textarea>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.address.$error">
                                            <div ng-message="required" class="err">Address is required</div>
                                        </div>                                        
                                    </span>                                      
                                </div>
                            </div>
                        </div>     
                        <div class="row">
                            <div class="col-md-6">  
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.phone.$dirty && bankAccountForm.phone.$invalid)}">
                                    <label>Phone<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="bankAccount.phone" name="phone" ng-maxlength="10" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-minlength="10" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.phone.$error">
                                            <div ng-message="required" class="err">phone number is required</div>
                                            <div ng-message="maxlength" class="err">phone number must be 10 digit</div>
                                            <div ng-message="minlength" class="err">phone number must be 10 digit</div>
                                        </div>                                        
                                    </span>                                      
                                </div>
                            </div>    
                            <div class="col-md-6"> 
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!bankAccountForm.email.$dirty && bankAccountForm.email.$invalid)}">
                                    <label>Email<span class="sp-err">*</span></label>    
                                    <span class="input-icon icon-right">
                                        <input type="email" class="form-control" ng-model="bankAccount.email" name="email"  required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.email.$error">
                                            <div ng-message="required" class="err">Email is required</div>
                                            <div ng-message="email" class="err">Invalid email id</div>
                                        </div>                                        
                                    </span>                                     
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">  
                                <div class="form-group multi-sel-div" ng-class="{ 'has-error' : (sbtBtn && (!bankAccountForm.payment_heading.$dirty && bankAccountForm.payment_heading.$invalid))}" >
                                    <label for="">Select payment heading </label>	
                                    <ui-select multiple ng-model="bankAccount.payment_heading" name="payment_heading" theme="select2"  required style="width: 300px;"  >
                                        <ui-select-match>{{$item.payment_heading}}</ui-select-match>
                                        <ui-select-choices repeat="list in paymentHeadings | filter:$select.search">
                                            {{list.payment_heading}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="emptyDepartmentId" class="err {{ applyClassDepartment}}">
                                        Payment heading is required.
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">Submit</button>
                        </div>                            
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="bankAccountFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.name" name="name" class="form-control"  oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Company</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.legal_name" name="legal_name" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Branch</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.branch" name="branch" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Account Type</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.account_type" name="account_type" class="form-control">
                                <option value="">Select account type</option>
                                <option value="1">Saving account</option>
                                <option value="2">Current account</option>
                            </select>

                        </span>    
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Account Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.account_number" name="account_number" class="form-control">
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" align="center">
                            <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>

