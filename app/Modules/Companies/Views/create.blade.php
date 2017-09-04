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
<div class="row" ng-controller="companyCtrl" ng-init="id = '0'">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Add Company Information</span>
            </div>
            <div class="widget-body">
                <tabset>
                    <tab heading="Company Information" id="remarkTab">
                        <form  ng-submit="companysForm.$valid && docompanyscreateAction(CompanyData.firm_logo, CompanyData, document)" name="companysForm"  novalidate enctype="multipart/form-data">
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
                                            <input type="file" ngf-select   ng-model="CompanyData.firm_logo" name="firm_logo" id="firm_logo"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
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
                            <div class="row">
                                <div class="col-sm-12 col-xs-12" align="right">
                                    <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="firmBtn">Submit</button>
                                    <a href="[[ config('global.backendUrl') ]]#/companies/index" class="btn btn-primary"><< Back to list</a>
                                </div>
                            </div>                    
                        </form>
                    </tab>
                    <tab heading="Company Documents" disabled="companyDocTab">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="well with-header  with-footer">
                                    <div class="header ">
                                        <!--Manage Documents-->
                                        <input type="button" value="Add More" class="btn btn-primary" style="float:right;"  data-toggle="modal" data-target="#documentModal" >
                                    </div>
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
                                            <tr ng-repeat="list in documentDetails">
                                                <td>{{$index + 1}}</td>
                                                <td>{{list.document_name}}</td>
                                                <td>{{list.document_file}} </td>
                                                <td class="fa-div">
                                                    <div class="fa-hover" style="float:center" tooltip-html-unsafe="Edit" style="display: block;"data-toggle="modal" data-target="#documentModal"><a href="javascript:void(0);" ng-click="editStationary({{list}},{{$index}}, 1)"><i class="fa fa-pencil"></i></a></div>
                                                </td>
                                            </tr>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Stationary" disabled="companyDocTab">

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="well with-header  with-footer">
                                    <div class="header">
                                        <!--Manage Stationary-->
                                        <input type="button" value="Add More" class="btn btn-primary" style="float:right;"  data-toggle="modal" data-target="#stationaryModal" ng-click="clearData()">
                                        <!--<input type="button" value="Add More" class="btn btn-primary" style="float:right;"  ng-click="addNewStationary()">-->
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
                                                        <div class="fa-hover" style="float:center" tooltip-html-unsafe="Edit" style="display: block;"data-toggle="modal" data-target="#stationaryModal"><a href="javascript:void(0);" ng-click="editStationary({{list}},{{$index}}, 1)"><i class="fa fa-pencil"></i></a></div>
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
    <div class="modal fade" id="documentModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header navbar-inner">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Add Document</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <form name="stationaryForm"  ng-submit="documentDetails(documentData, documentData.document_file, companyId)" enctype="multipart/form-data">  
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Document Name </label>
                                        <span class="input-icon icon-right">
                                            <input type="text"   ng-model="documentData.document_name" name="document_name" id="document_name"  class="form-control imageFile" >
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Documents File</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="documentData.document_file" name="document_file" id="document_file"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" ng-model="companyId" name="companyId" value="{{companyId}}">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12" align="right">
                                        <button type="submit" class="btn btn-primary btn-submit-last" >Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="stationaryModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header navbar-inner">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Add Stationary</h4>
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
                                    </div>
                                    <div class="col-md-6">
                                        <label>Stamp</label>
                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select   ng-model="stationary.rubber_stamp_file" name="rubber_stamp_file" id="rubber_stamp_file" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                        </span>
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
                                        <button type="submit" class="btn btn-primary btn-submit-last" >Save</button>
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

