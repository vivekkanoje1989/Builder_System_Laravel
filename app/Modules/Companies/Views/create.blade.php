<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div class="row" ng-controller="companyCtrl" ng-init="id ='0'" >  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Add New Company</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <form  ng-submit="companysForm.$valid && docompanyscreateAction(CompanyData.firm_logo,CompanyData)" name="companysForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                   <input type="text" ng-model="id" name="id"  class="form-control">
                    
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <td colspan="4">Add New Company</td>
                            <tr>
                        </thead>
                        <tbody>                
                            <tr>
                                <td width="10%">Legal Name<span class="sp-err">*</span></td>
                                <td width="30%">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.legal_name.$dirty && companysForm.legal_name.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.legal_name" name="legal_name"  ng-change="errorMsg = null" required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.legal_name.$error">
                                                <div ng-message="required">Legal name is required</div>
                                                <div ng-if="errorMsg">{{errorMsg}}</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                                <td width="10%">Punch Line<span class="sp-err">*</span></td>
                                <td width="30%">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.punch_line.$dirty && companysForm.legal_name.$invalid) }">

                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="CompanyData.punch_line" name="punch_line"  required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.punch_line.$error">
                                                <div ng-message="required">Punch Line is required</div>
                                            </div>
                                        </span>
                                    </div>    
                                </td>
                            </tr>
                            <tr>    
                                <td width="10%">VAT Number</td>
                                <td width="30%">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="CompanyData.vat_num" name="vat_num" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">

                                        <br/>
                                    </span>
                                </td>

                                <td width="10%">PAN Number</td>
                                <td width="30%">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="CompanyData.pan_num" name="pan_num" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">

                                        <br/>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">Service TAX Number</td>
                                <td width="30%">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="CompanyData.service_tax_number" name="service_tax_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                    </span>
                                </td>

                                <td width="10%">GST Number</td>
                                <td width="30%">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="CompanyData.gst_number" name="gst_number" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                    </span>
                                </td>
                            <tr> 
                            <tr>     
                                <td width="10%">Cloud Telephoney Client<span class="sp-err">*</span></td>
                                <td width="30%">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.cloud_telephoney_client.$dirty && companysForm.cloud_telephoney_client.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <select  class="form-control" ng-model="CompanyData.cloud_telephoney_client" name ="cloud_telephoney_client" required>
                                                <option value="" >Select</option>
                                                <option value="1" >Yes</option>
                                                <option value="0">No</option>
                                            </select>  
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.cloud_telephoney_client.$error">
                                                <div ng-message="required">Please select field</div>
                                            </div>
                                        </span>
                                    </div>
                                </td>

                                <td width="10%">Domain Name</td>
                                <td width="30%">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="CompanyData.domain_name" name="gst_number"  >
                                    </span>
                                </td>
                            </tr>
                            <tr>   <td width="10%">Firm Logo<span class="sp-err">*</span></td>
                                <td width="30%">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.firm_logo.$dirty && companysForm.firm_logo.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="CompanyData.firm_logo" name="firm_logo" id="firm_logo" required accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.firm_logo.$error">
                                                <div ng-message="required">Logo is required</div>
                                            </div>
                                        </span>
                                    </div>
                                </td>
                                <td width="10%">Main Office Address<span class="sp-err">*</span></td>
                                <td width="30%">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!companysForm.main_office_addr.$dirty && companysForm.main_office_addr.$invalid) }">

                                        <span class="input-icon icon-right">
                                            <textarea cols="60" rows="5" ng-model="CompanyData.main_office_addr" name="main_office_addr" required></textarea> 
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="companysForm.main_office_addr.$error">
                                                <div ng-message="required">Main Office Address is required</div>
                                            </div>  
                                            <br/>
                                        </span>
                                    </div>   
                                </td>
                            </tr>
                    </table>
                    <table class="table table-hover table-striped table-bordered" at-config="config">    
                        <thead class="bord-bot">
                            <tr>
                                <td width="10%">Document No.</td>
                                <td width="50%">Documents Name</td>
                                <td width="30%">Documents File</td>
                                <td width="10%">Action  &nbsp;&nbsp;&nbsp; <input type="button" value="Add More" class="btn btn-primary" style="float:right;" ng-click="addNewDocuments()"></td>
                            <tr>
                        </thead>
                        <tr  data-ng-repeat="document in documents"><td width="10%">{{document.id}}</td>
                            <td width="30%">
                                <input type="text"   ng-model="document.document_name" name="document_name" id="document_name"  class="form-control imageFile" >
                            </td>
                            <td width="10%"> <span class="input-icon icon-right">
                                    <input type="file" ngf-select   ng-model="document.document_file" name="document_file" id="document_file"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                    <br/>
                                </span>
                            </td>
                            <td width="30%">
                                <button class="btn btn-primary" value="Remove" ng-show="$last" ng-if="$first != $last" ng-click="removeChoice()">-</button>
                            </td>
                        </tr>

                    </table>
                    <table class="table table-hover table-striped table-bordered"  data-ng-repeat="stationary in Stationary">

                        <tr class="bord-bot" style="background-color: #e2e2e2;">
                            <td>Stationary No.</td>
                            <td>Name</td>
                            <td>Letter Head</td>
                            <td>Payment Receipt Letter Head</td>
                            <td>Stamp &nbsp;&nbsp;&nbsp; <input type="button" value="Add More" class="btn btn-primary" style="float:right;" ng-if="$first" ng-click="addNewStationary()"></td>
                        <tr>
                        <tbody >
                            <tr >
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

                            <tr class="bord-bot" style="background-color: #e2e2e2;">
                                <td></td>
                                <td>Estimate logo file</td>
                                <td>Demand letter file</td>
                                <td>Demand letter logo file</td>
                                <td>Receipt logo file</td>
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
                        <br/>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <br/><br/>
                        <div class="col-md-5"></div>
                        <div class="col-md-1">
                            <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button></div>

                        <div class="col-md-5">
                            <button type="button" class="btn btn-sub">Cancel</button></div>
                        </tr>
                        </table>
                </form>
            </div>
        </div>
    </div>
</div>

