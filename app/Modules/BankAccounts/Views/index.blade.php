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
                 <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
              </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <a title="Create bank account" class="btn btn-default" data-toggle="modal" ng-click="initialModel('0', '', '', '')" data-target="#bankAccountModal" >Create Bank Account</a>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <!--                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="bankAccountExportToxls()" ng-show="exportData == '1'">   
                                                    <span>Export</span>
                                                </a>-->
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="bankAccountExportToxls()" ng-show="exportData == '1'">Export</a>
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
                            <tr>
                                <th style="width:5%">Sr. No.</th>                       
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('legal_name')">Company
                                        <span ><img ng-hide="(sortKey == 'legal_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'legal_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'legal_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('name')">Name
                                        <span><img ng-hide="(sortKey == 'name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('branch')">Branch
                                        <span ><img ng-hide="(sortKey == 'branch' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'branch' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'branch' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('account_type')">Account Type
                                        <span ><img ng-hide="(sortKey == 'account_type' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'account_type' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'account_type' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('account_number')">Account Number
                                        <span ><img ng-hide="(sortKey == 'account_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'account_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'account_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>                               
                                <th style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="item in bankAccountRow| filter:search |filter:searchData | orderBy:sortKey:reverseSort |itemsPerPage:itemsPerPage">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td> 
                                <td>{{item.legal_name}}</td>  
                                <td>{{item.name}}</td>     
                                <td>{{item.branch}}</td> 
                                <td>{{item.account_type == '1' ? "Saving":"Current"}}</td>
                                <td>{{item.account_number}}</td>  
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit" data-toggle="modal" data-target="#bankAccountModal"><a href="javascript:void(0);" ng-click="initialModel({{ item.id}},{{item}},{{itemsPerPage}},{{$index}})" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span  ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{item.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"  ng-show="(bankAccountRow|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-primary" id="bankAccountModal" role="dialog" tabindex="-1" ng-cloak  ng-init="managePaymentHeading()">    
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
                                        <input type="text" class="form-control" ng-model="bankAccount.account_number" name="account_number"  ng-maxlength="11" ng-minlength="11" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="bankAccountForm.account_number.$error">
                                            <div ng-message="required" class="err">Account number is required</div>
                                            <div ng-message="minlength" class="err">Account number must be 11 digits.</div>
                                            <div ng-message="maxlength" class="err">Account number must be 11 digits.</div>
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
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">{{btn}}</button>
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
    <div class="modal fade" id="help" role="dialog" tabindex="-1" >    
        <div class="modal-dialog">
           
            <div class="modal-content helpModal" >
                <div class="modal-header helpModalHeader bordered-bottom bordered-themeprimary" >
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title" align="center">Task Priority Help Info</h4>
                </div>                
                <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="helpContent">- This listing shows information about bank accounts. </label>
                                <label class="helpContent">- After click on "Create Bank Account" you can create new bank account. </label>
                                <span class="input-icon icon-right">                                    
                                    
                                </span>
                            </div>                            
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</div>

