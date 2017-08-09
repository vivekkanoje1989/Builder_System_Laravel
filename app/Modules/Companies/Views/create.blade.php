<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div class="row" ng-controller="companyCtrl" ng-init="id = '0'">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Add Company Information</span>
            </div>
            <div class="widget-body">
                <form  ng-submit="companysForm.$valid && docompanyscreateAction(CompanyData.firm_logo, CompanyData, document, stationary)" name="companysForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" ng-model="id" name="id"  class="form-control">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.legal_name.$dirty && companysForm.legal_name.$invalid) }">
                                <label>Legal name<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.legal_name" name="legal_name"  ng-change="errorMsg = null" required>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.legal_name.$error">
                                        <div ng-message="required">Legal name is required</div>
                                        <div ng-if="errorMsg">{{errorMsg}}</div>
                                    </div>
                                    <div ng-if="legal_name" class="sp-err legal_name">{{legal_name}}</div>
                                    <br/>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.punch_line.$dirty && companysForm.legal_name.$invalid) }">
                                <label>Punch line<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.punch_line" name="punch_line"  required>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.punch_line.$error">
                                        <div ng-message="required">Punch Line is required</div>
                                    </div>
                                    <div ng-if="punch_line" class="sp-err punch_line">{{punch_line}}</div>
                                </span>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Vat Number</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.vat_num" name="vat_num" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                    <br/>
                                </span>
                            </div>     
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Pan Number</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.pan_num" name="pan_num" maxlength="10" minlength="10">
                                    <div ng-show="sbtBtn" ng-messages="companysForm.pan_num.$error" class="help-block">
                                        <div ng-message="maxlength" class="sp-err">Please enter maximum 10 Characters.</div> 
                                        <div ng-message="minlength" class="sp-err">Please enter minimum 10 Characters.</div> 
                                    </div>
                                    <br/>
                                </span>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Service Tax Number</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.service_tax_number" name="service_tax_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                </span>
                            </div>  
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Gst Number</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.gst_number" name="gst_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                </span>
                            </div>   
                        </div>

                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.cloud_telephoney_client.$dirty && companysForm.cloud_telephoney_client.$invalid) }">
                                <label>Cloud Telephony Client <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select  class="form-control" ng-model="CompanyData.cloud_telephoney_client" name ="cloud_telephoney_client" required>
                                        <option value="" >Select</option>
                                        <option value="1" >Yes</option>
                                        <option value="0">No</option>
                                    </select>  
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.cloud_telephoney_client.$error">
                                        <div ng-message="required">Please select this field</div>
                                    </div>
                                    <div ng-if="cloud_telephoney_client" class="sp-err cloud_telephoney_client">{{cloud_telephoney_client}}</div>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group" >
                                <label>Domain name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="CompanyData.domain_name" name="domain_name"  >
                                </span>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.firm_logo.$dirty && companysForm.firm_logo.$invalid) }">
                                <label>Firm Logo<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="file" ngf-select   ng-model="CompanyData.firm_logo" name="firm_logo" id="firm_logo" required accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.firm_logo.$error">
                                        <div ng-message="required">Logo is required</div>
                                    </div>
                                    <div ng-if="firm_logo" class="sp-err firm_logo">{{firm_logo}}</div>
                                </span>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.office_address.$dirty && companysForm.office_address.$invalid) }">   
                                    <label>Main Office Address<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="CompanyData.office_address" required name="office_address" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.office_address.$error">
                                            <div ng-message="required">Main Office Address is required</div>
                                        </div>  
                                        <div ng-if="office_address" class="sp-err office_address">{{office_address}}</div>
                                        <br/>
                                    </span>
                                </div>    
                            </div>   
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="well with-header  with-footer">
                                <div class="header ">
                                    Manage Documents
                                    <input type="button" value="Add More" class="btn btn-primary" style="float:right;" ng-click="addNewDocuments()">
                                </div>
                                <table class="table table-hover">
                                    <thead class="">
                                        <tr>
                                            <th>Document No.</th>
                                            <th>Documents Name</th>
                                            <th>Documents File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr  data-ng-repeat="document in documents"><td width="10%">{{document.id}}</td>
                                            <td>
                                                <input type="text"   ng-model="document.document_name" name="document_name" id="document_name"  class="form-control imageFile" >
                                            </td>
                                            <td > <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="document.document_file" name="document_file" id="document_file"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                    <br/>
                                                </span>
                                            </td>
                                            <td >
                                                <button class="btn btn-primary" value="Remove" ng-show="$last" ng-if="$first != $last" ng-click="removeChoice()">-</button>
                                            </td>
                                        </tr>
                                    <div class="img-div2" data-title="name" ng-repeat="list in document_file_preview">    
                                        <img ng-src="{{list}}" class="thumb photoPreview" height="180px" width="180px;">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="well with-header  with-footer">
                                <div class="header">
                                    Manage Stationary
                                    <input type="button" value="Add More" class="btn btn-primary" style="float:right;"  ng-click="addNewStationary()">
                                </div>
                                <table class="table table-hover" data-ng-repeat="stationary in Stationary">
                                    <thead class="">
                                        <tr>
                                            <th>Stationary No.</th>
                                            <th>Name</th>
                                            <th>Letter Head</th>
                                            <th>Payment Receipt Letter Head
                                            <th>Stamp </th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="10%">{{stationary.id}}</td>
                                            <td width="20%">
                                                <span class="input-icon icon-right">
                                                    <input type="text" class="form-control" ng-model="stationary.stationary_set_name" name="stationary_set_name">

                                                </span>
                                            </td>
                                            <td width="30%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.estimate_letterhead_file" name="estimate_letterhead_file" id="estimate_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                </span>
                                            </td>
                                            <td width="20%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.receipt_letterhead_file" name="receipt_letterhead_file" id="receipt_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >

                                                </span>
                                            </td>
                                            <td width="20%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.rubber_stamp_file" name="rubber_stamp_file" id="rubber_stamp_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead class="">
                                        <tr>
                                            <th></th>
                                            <th>Estimate logo file</th>
                                            <th>Demand letter file</th>
                                            <th>Demand letter logo file</th>
                                            <th>Receipt logo file</th>    
                                        <tr>
                                        <tr>
                                            <td width="10%"></td>
                                            <td width="20%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.estimate_logo_file" name="estimate_logo_file" id="estimate_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                </span>
                                            </td>
                                            <td width="30%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.demandletter_letterhead_file" name="demandletter_letterhead_file" id="demandletter_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                </span>
                                            </td>
                                            <td width="20%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.demandletter_logo_file" name="demandletter_logo_file" id="demandletter_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                </span>
                                            </td>
                                            <td width="20%">
                                                <span class="input-icon icon-right">
                                                    <input type="file" ngf-select   ng-model="stationary.receipt_logo_file" name="receipt_logo_file" id="receipt_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                </span>
                                            </td>
                                        </tr>    
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12" align="right">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="firmBtn">Submit</button>
                            <a href="[[ config('global.backendUrl') ]]#/companies/index" class="btn btn-primary"><< Back to list</a>
                        </div>
                    </div>                    
                </form>
            </div>
	</div>
    </div>
</div>

