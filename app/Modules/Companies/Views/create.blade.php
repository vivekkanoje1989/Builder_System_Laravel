<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
    .fileimg{
        width: 10%;
    }
</style>
<div class="row" ng-controller="companyCtrl" ng-init="id = '0'; manageCountry(); manageCompanies();">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Add Company Details</span>
            </div>
            <div class="widget-body">
                <tabset>
                    <tab heading="Company Information" id="companyTab">
                        <form  ng-submit="companysForm.$valid && docompanyscreateAction(CompanyData.firm_logo,CompanyData.fevicon, CompanyData, document)" name="companysForm"  novalidate enctype="multipart/form-data">
                            <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                            <input type="hidden" ng-model="id" name="id"  class="form-control">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.marketing_name.$dirty && companysForm.marketing_name.$invalid) }">
                                        <label>Marketing name<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.marketing_name" name="marketing_name"   required capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.marketing_name.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.legal_name.$dirty && companysForm.legal_name.$invalid) }">
                                        <label>Legal name<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.legal_name" name="legal_name"  ng-change="errorMsg = null" required capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.legal_name.$error">
                                                <div ng-message="required">This field is required.</div>
                                                <div ng-if="errorMsg">{{errorMsg}}</div>
                                            </div>
                                            <div ng-if="legal_name" class="sp-err legal_name">{{legal_name}}</div>
                                            <br/>
                                        </span>
                                    </div>
                                </div>
                                 <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.type_of_company.$dirty && companysForm.type_of_company.$invalid) }">
                                        <label>Company Type<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="CompanyData.type_of_company" ng-change="" name="type_of_company" class="form-control">
                                                <option value="">Select company type</option>
                                                <option ng-repeat="list in companyType"  ng-selected="{{type_of_company == list.id}}"  value="{{list.id}}">{{list.type_of_company}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.type_of_company.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div> 
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.company_register_no.$dirty && companysForm.company_register_no.$invalid) }">
                                        <label>CIN/FCRN/LLPIN/FLLPIN</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.company_register_no" name="company_register_no"   maxlength="25" >
<!--                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.company_register_no.$error">
                                                <div ng-message="required">Company type is required</div>
                                            </div> -->
                                        </span>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group">
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.office_address.$dirty && companysForm.office_address.$invalid) }">   
                                            <label>Registered Address<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <textarea ng-model="CompanyData.office_address" required name="office_address" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched capitalize" required></textarea>
                                                <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.office_address.$error">
                                                    <div ng-message="required">This field is required.</div>
                                                </div>  
                                                <div ng-if="office_address" class="sp-err office_address">{{office_address}}</div>
                                                <br/>
                                            </span>
                                        </div>    
                                    </div>   
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.pin_code.$dirty && companysForm.pin_code.$invalid) }">
                                        <label>Pin code<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.pin_code" name="pin_code" maxlength="6"  required capitalizeFirst oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.pin_code.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div> 
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.country_id.$dirty && companysForm.country_id.$invalid) }">
                                        <label>Country<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select id="country_id" name="country_id" class="form-control"  required  ng-model="CompanyData.country_id"  ng-change="manageStates(CompanyData.country_id)" >
                                                <option value="">Select country</option>
                                                <option ng-repeat="item in countryRow" value="{{item.id}}">{{item.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.country_id.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.state_id.$dirty && companysForm.state_id.$invalid) }">
                                        <label>State<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select class="form-control" ng-model="CompanyData.state_id" required name="state_id" ng-change="manageStateCode(CompanyData.state_id)" required>
                                                <option value="">Select state</option>
                                                <option  ng-repeat="itemone in statesRow" ng-selected="{{ state_id == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.state_id.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group">
                                        <label>GSTIN Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" style="width: 20%; display: inline-block;" ng-model="CompanyData.state_code" maxlength="2" disabled name="state_code" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                            <input type="text" class="form-control" style="width: 55%; display: inline-block; margin-left: -1%;" maxlength="10" ng-model="CompanyData.pan_num" name="pan_num" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                            <input type="text" class="form-control" style="width: 25%; display: inline-block; margin-left: -1%;" maxlength="3" ng-model="CompanyData.gst_number" name="gst_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                        </span>
                                    </div>   
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.punch_line.$dirty && companysForm.legal_name.$invalid) }">
                                        <label>Punch line<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text"  class="form-control" ng-model="CompanyData.punch_line" name="punch_line" capitalizeFirst required oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.punch_line.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                            <div ng-if="punch_line" class="sp-err punch_line">{{punch_line}}</div>
                                        </span>
                                    </div> 
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group">
                                        <label>PAN Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" disabled ng-model="CompanyData.pan_num" name="pan_num" maxlength="10" minlength="10">
                                            <div ng-show="sbtBtn" ng-messages="companysForm.pan_num.$error" class="help-block">
                                                <div ng-message="maxlength" class="sp-err">Please enter maximum 10 Characters.</div> 
                                                <div ng-message="minlength" class="sp-err">Please enter minimum 10 Characters.</div> 
                                            </div>
                                            <br/>
                                        </span>
                                    </div>    
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group">
                                        <label>VAT Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control"  maxlength="25" ng-model="CompanyData.vat_number" name="vat_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                            <br/>
                                        </span>
                                    </div>     
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group">
                                        <label>TAN Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control"  maxlength="25" ng-model="CompanyData.tan_number" name="tan_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                        </span>
                                    </div>  
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.firm_logo.$dirty && companysForm.firm_logo.$invalid) }">
                                        <label>Firm Logo</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select  ng-model="CompanyData.firm_logo" name="firm_logo" id="firm_logo"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                            <div class="help-block" ng-if="sbtBtn" ng-messages="companysForm.firm_logo.$error">
                                                <div ng-message="required">Logo is required</div>
                                            </div>
                                            <br/>
                                            <div ng-if="firm_logo" class="sp-err firm_logo">{{firm_logo}}</div>
                                            <div class="img-div2" data-title="name" ng-repeat="list in firm_logo_preview">    
                                                <img ng-src="{{list}}" class="thumb photoPreview">
                                            </div>
                                        </span>
                                    </div> 
                                </div>
                                <div class="col-sm-3 col-xs-12 ">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.fevicon.$dirty && companysForm.fevicon.$invalid) }">
                                        <label>Fevicon</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select  ng-model="CompanyData.fevicon" name="fevicon" id="fevicon"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                            <div class="help-block" ng-if="sbtBtn" ng-messages="companysForm.fevicon.$error">
                                                <div ng-message="required">Fevicon is required</div>
                                            </div>
                                            <br/>
                                            <div ng-if="fevicon" class="sp-err firm_logo">{{firm_logo}}</div>
                                            <div class="img-div2" data-title="name" ng-repeat="list1 in fevicon_preview">    
                                                <img ng-src="{{list1}}" class="thumb photoPreview">
                                            </div>
                                        </span>
                                    </div> 
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div class="form-group" >
                                        <label>Company Website URL</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.domain_name" name="domain_name"  >
                                        </span>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 " ng-controller="adminController" ng-init="getEmployeeData()">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.contact_person.$dirty && companysForm.contact_person.$invalid) }">
                                        <label>Contact Person<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="CompanyData.contact_person" required name="contact_person" class="form-control">
                                                <option value="">Select contact person</option>
                                                <option ng-repeat="employee in ct_employee" value="{{employee.id}}">{{employee.first_name + " " + employee.last_name + " (" + employee.designation + " )"}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.contact_person.$error">
                                                <div ng-message="required">This field is required.</div>
                                            </div>
                                        </span>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12" align="right">
                                    <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="firmBtn">Submit</button>
                                    <a href="[[ config('global.backendUrl') ]]#/companies/index" class="btn btn-primary">Cancel</a>
                                </div>
                            </div>                    
                        </form>
                    </tab>
                    <tab heading="Company Documents" id="documentTab" disabled="companyDocTab">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="well with-header  with-footer">
                                    <div class="header ">
                                        <!--Manage Documents-->
                                        <input type="button" value="Add More" class="btn btn-primary" style="float:right;"  data-toggle="modal" data-target="#documentModal" ng-click="clearData(); editdocument(0, '', '', 1)">
                                    </div>
                                    <div class="widget-body table-responsive" >

                                        <table class="table table-hover table-responsive table-striped table-bordered">
                                            <thead class="">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Documents Name</th>
                                                    <th>Documents File</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="list in documents">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{list.document_name}}</td>
                                                    <td><img ng-src="[[ Config('global.s3Path') ]]/Company/documents/{{list.documentFile}}" width="80px" height="80px"></td>
                                                    <td class="fa-div">
                                                        <div class="fa-hover" style="float:center" tooltip-html-unsafe="Edit" style="display: block;"data-toggle="modal" data-target="#documentModal"><a href="javascript:void(0);" ng-click="editdocument({{list.documentId}},{{list}},{{$index}}, 0)"><i class="fa fa-pencil"></i></a></div>
                                                    </td>
                                                </tr>  
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Stationary" disabled="companyDocTab" id="stationaryTab">

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="well with-header  with-footer">
                                    <div class="header">
                                        <!--Manage Stationary-->
                                        <input type="button" value="Add More" class="btn btn-primary" style="float:right;"  data-toggle="modal" data-target="#stationaryModal" ng-click="clearData(); editStationary(0, '', '', 1)">
                                    </div>

                                    <div class="widget-body table-responsive" >
                                        <table class="table table-hover table-striped table-bordered" at-config="config">
                                            <thead class="bord-bot">
                                                <tr>
                                                    <th>Sr. No. </th>
                                                    <th>Name</th>
                                                    <th>Letterhead File</th>
                                                    <th>Receipt Letterhead File</th>
                                                    <th>Rubber Stamp File</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="list in stationaryDetails">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{list.stationary_set_name}}</td>
                                                    <td><img ng-src="[[ Config('global.s3Path') ]]/Company/estimateLetterhead/{{list.estimate_letterhead_file}}" width="80px" height="80px"> </td>
                                                    <td><img ng-src="[[ Config('global.s3Path') ]]/Company/receiptLetterhead/{{list.receipt_letterhead_file}}" width="80px" height="80px"></td>
                                                    <td><img ng-src="[[ Config('global.s3Path') ]]/Company/rubberStampFile/{{list.rubber_stamp_file}}" width="80px" height="80px"></td>
                                                    <td class="fa-div">
                                                        <div class="fa-hover" style="float:center" tooltip-html-unsafe="Edit" style="display: block;"data-toggle="modal" data-target="#stationaryModal"><a href="javascript:void(0);" ng-click="editStationary({{list.stationaryId}},{{list}},{{$index}}, 0)"><i class="fa fa-pencil"></i></a></div>
                                                    </td>
                                                </tr>                                            
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </tab>
                </tabset>
            </div>
        </div>
    </div>
    <div class="modal fade modal-primary" id="documentModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header navbar-inner">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{modalHeading}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form name="documentForm" novalidate  ng-submit="documentForm.$valid && documentDetails(documentData, documentData.document_file, companyId)" enctype="multipart/form-data">  
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Document Name </label>
                                        <span class="input-icon icon-right">
                                            <input type="text"   ng-model="documentData.document_name" name="document_name" required id="document_name"  class="form-control imageFile" >
                                        </span>
                                        <div class="help-block" ng-show="sbtBtn1" ng-messages="documentForm.document_name.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Documents File</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="documentData.document_file" name="document_file" ng-required="docid == 0" id="document_file"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                        <div class="help-block" ng-show="sbtBtn1" ng-messages="documentForm.document_file.$error">
                                            <div ng-message="required">This field is required.</div>
                                        </div>
                                        <div ng-if="documentFile && document_file_preview.length == 0">
                                            <img ng-src="[[ Config('global.s3Path') ]]/Company/documents/{{documentFile}}" width="80px" height="80px">
                                        </div>
                                        <br/>
                                        <div class="img-div2" data-title="name" ng-repeat="list in document_file_preview">    
                                            <img ng-src="{{list}}" class="thumb photoPreview">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" ng-model="companyId" name="companyId" value="{{companyId}}">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12" align="right">
                                        <button type="submit" ng-click="sbtBtn1 = true" class="btn btn-primary btn-submit-last" style=" margin-top: 20px;" >{{modalBtn}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-primary" id="stationaryModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header navbar-inner">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{modalHeading}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form name="stationaryForm"  ng-submit="stationaries(stationary, stationary.estimate_logo_file, companyId)" enctype="multipart/form-data">  
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Stationary Name </label>
                                        <span class="input-icon icon-right">
                                            <input type="text" required class="form-control" ng-model="stationary.stationary_set_name" name="stationary_set_name">

                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Letter Head</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.estimate_letterhead_file" name="estimate_letterhead_file" id="estimate_letterhead_file" accept="image/*"  class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Payment Receipt Letter Head </label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.receipt_letterhead_file" name="receipt_letterhead_file" id="receipt_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >

                                        </span>
                                        <div class="img-div2" data-title="name" ng-repeat="list in receipt_letterhead_file_preview">    
                                            <img ng-src="{{list}}" class="thumb photoPreview">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Stamp</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.rubber_stamp_file" name="rubber_stamp_file" id="rubber_stamp_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                        <br/>
                                        <div class="img-div2" data-title="name" ng-repeat="list in rubber_stamp_file_preview">    
                                            <img ng-src="{{list}}" class="thumb photoPreview">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Estimate logo file </label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.estimate_logo_file" name="estimate_logo_file" id="estimate_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Demand letter file</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.demandletter_letterhead_file" name="demandletter_letterhead_file" id="demandletter_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Demand letter logo file</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.demandletter_logo_file" name="demandletter_logo_file" id="demandletter_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Receipt logo file</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.receipt_logo_file" name="receipt_logo_file" id="receipt_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" ng-model="companyId" name="companyId" value="{{companyId}}">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12" align="right">
                                        <button type="submit" class="btn btn-primary btn-submit-last" ng-disable="stationaryBtn" style=" margin-top: 20px;" >{{modalBtn}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

