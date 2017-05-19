<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div class="row" ng-controller="companyCtrl"  ng-init="loadCompanyData('<?php echo $companyId; ?>');">   
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="widget flat radius-bordered">
                    <div class="widget-body">
                        <div id="registration-form">
                            <form  ng-submit="companysForm.$valid && docompanyscreateAction(CompanyData.firm_logo, CompanyData)" name="companysForm"  novalidate enctype="multipart/form-data">
                                <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                                <input type="hidden" ng-model="id" name="id"  class="form-control">
                                <div class="form-title">
                                    Manage Companies
                                </div>
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
                                                <input type="text" class="form-control" ng-model="CompanyData.pan_num" name="pan_num" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
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
                                        <div><img ng-src="{{firm_logo}}"  height="80px" width="80px" ></div>
                                        <label>   Firm Logo</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="CompanyData.firm_logo" name="firm_logo" id="firm_logo"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >        
                                        </span>
                                    </div>
                                    <div class="col-sm-3 col-xs-12 ">
                                        <div class="form-group">
                                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.main_office_addr.$dirty && companysForm.main_office_addr.$invalid) }">   
                                                <label style="margin-top:63px;"> Main Office Address<span class="sp-err">*</span></label>
                                                <span class="input-icon icon-right">
                                                    <textarea ng-model="CompanyData.main_office_addr" required name="main_office_addr" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>
                                                    <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.main_office_addr.$error">
                                                        <div ng-message="required">Main Office Address is required</div>
                                                    </div>  
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
                                                        <th>
                                                            Document No.
                                                        </th>
                                                        <th>
                                                            Documents Name
                                                        </th>
                                                        <th>
                                                            Documents File
                                                        </th>
                                                        <th>
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr  data-ng-repeat="document in documents"><td width="10%">{{document.id}}</td>
                                                        <td>
                                                            <input type="text"   ng-model="document.document_name" name="document_name" id="document_name"  class="form-control imageFile" >
                                                        </td>
                                                        <td> 
                                                            <span class="input-icon icon-right">
                                                                <input type="file" ngf-select   ng-model="document.document_file" name="document_file" id="document_file"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                                <br/>
                                                            </span>
                                                            <div><img ng-src="[[ Session::get('s3Path') ]]Company/documents/{{document.documentFile}}"  height="80px" width="80px" ></div>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary" value="Remove" ng-show="$last" ng-if="$first != $last" ng-click="removeChoice()">-</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="well with-header  with-footer">
                                            <div class="header ">
                                                Manage Stationary
                                                <input type="button" value="Add More" class="btn btn-primary" style="float:right;"  ng-click="addNewStationary()">
                                            </div>
                                            <table class="table table-hover" data-ng-repeat="stationary in Stationary">
                                                <thead class="">
                                                    <tr>
                                                        <th>Stationary No.</th>
                                                        <th>Name</th>
                                                        <th>Letter Head</th>
                                                        <th>Payment Receipt Letter Headthtd
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
                                                            <div ng-if="stationary.estimateLetterheadFile"><img ng-src="[[ Session::get('s3Path') ]]Company/estimateLetterhead/{{stationary.estimateLetter}}"  height="80px" width="80px" ></div>
                                                        </td>
                                                        <td width="20%">
                                                            <span class="input-icon icon-right">
                                                                <input type="file" ngf-select   ng-model="stationary.receipt_letterhead_file" name="receipt_letterhead_file" id="receipt_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                            </span>
                                                            <div ng-if="stationary.receiptLetterhead"><img ng-src="[[ Session::get('s3Path') ]]Company/receiptLetterhead/{{stationary.receiptLetterhead}}"  height="80px" width="80px" ></div>
                                                        </td>
                                                        <td width="20%">
                                                            <span class="input-icon icon-right">
                                                                <input type="file" ngf-select   ng-model="stationary.rubber_stamp_file" name="rubber_stamp_file" id="rubber_stamp_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                            </span>
                                                            <div ng-if="stationary.rubberStamp"><img ng-src="[[ Session::get('s3Path') ]]Company/rubberStampFile/{{stationary.rubberStamp}}"  height="80px" width="80px" ></div>
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
                                                            <div ng-if="stationary.estimateLogo"><img ng-src="[[ Session::get('s3Path') ]]Company/estimateLogoFile/{{stationary.estimateLogo}}"  height="80px" width="80px" ></div>
                                                        </td>
                                                        <td width="30%">
                                                            <span class="input-icon icon-right">
                                                                <input type="file" ngf-select   ng-model="stationary.demandletter_letterhead_file" name="demandletter_letterhead_file" id="demandletter_letterhead_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                                <div ng-if="stationary.demandletterFile"><img ng-src="[[ Session::get('s3Path') ]]Company/demandletterFile/{{stationary.demandletterFile}}"  height="80px" width="80px" ></div>
                                                            </span>
                                                        </td>
                                                        <td width="20%">
                                                            <span class="input-icon icon-right">
                                                                <input type="file" ngf-select   ng-model="stationary.demandletter_logo_file" name="demandletter_logo_file" id="demandletter_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                            </span>
                                                            <div ng-if="stationary.demandletterLogoFile"><img ng-src="[[ Session::get('s3Path') ]]Company/demandletterLogoFile/{{stationary.demandletterLogoFile}}"  height="80px" width="80px" ></div>
                                                        </td>
                                                        <td width="20%">
                                                            <span class="input-icon icon-right">
                                                                <input type="file" ngf-select   ng-model="stationary.receipt_logo_file" name="receipt_logo_file" id="receipt_logo_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                                            </span>
                                                            <div ng-if="stationary.receiptLogoFile"><img ng-src="[[ Session::get('s3Path') ]]Company/receiptLogoFile/{{stationary.receiptLogoFile}}"  height="80px" width="80px" ></div>
                                                        </td>
                                                <br/>
                                                </tr>    
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

