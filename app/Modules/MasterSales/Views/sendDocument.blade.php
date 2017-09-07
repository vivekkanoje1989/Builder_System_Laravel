<div class="modal-body">
    <div class="modal-content">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <tabset>
                    <tab heading="Send Documents" id="documentTab">
                        <div class="row">
                            <div class="col-lg-21 col-sm-12 col-xs-12">                            
                                <form name="sendDocumentForm" novalidate ng-submit="sendDocumentForm.$valid && insertSendDocument(documentData)" class="main-container1">
                                    <input type="hidden" ng-model="documentData.enquiryId" name="enquiryId" id="enquiryId" value="{{documentData.enquiryId}}">
                                    <input type="hidden" ng-model="documentData.customerId" name="customerId" id="custId" value="{{documentData.customerId}}">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                        <span ng-show="custInfo"><b style="font-size: 16px;">{{documentData.title}} {{documentData.customer_fname}} {{documentData.customer_lname}}</b></span>  	
                                        </div>
                                    </div>
                                    <div class="row col-lg-12 col-sm-12 col-xs-12" ng-show="editableCustInfo">
                                        <div class="col-sm-4">
                                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sendDocumentForm.title_id.$dirty && sendDocumentForm.title_id.$invalid)}">
                                                <span class="input-icon icon-right">
                                                    <select ng-model="documentData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" ng-required="editableCustInfo">
                                                        <option value="">Select Title</option>
                                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == documentData.title_id}}">{{t.title}}</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                    <div ng-show="sbtBtn" ng-messages="sendDocumentForm.title_id.$error" class="help-block">
                                                        <div ng-message="required">This field is required.</div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sendDocumentForm.customer_fname.$dirty && sendDocumentForm.customer_fname.$invalid)}">
                                                <span class="input-icon icon-right">
                                                    <input type="text" placeholder="First Name" ng-model="documentData.customer_fname" name="customer_fname" capitalization class="form-control" ng-required="editableCustInfo">
                                                    <i class="fa fa-user"></i>
                                                    <div ng-show="sbtBtn" ng-messages="sendDocumentForm.first_name.$error" class="help-block">
                                                        <div ng-message="required">This field is required.</div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sendDocumentForm.customer_lname.$dirty && sendDocumentForm.customer_lname.$invalid)}">
                                                <span class="input-icon icon-right">
                                                    <input type="text" placeholder="Last Name" ng-model="documentData.customer_lname" name="customer_lname" capitalization class="form-control" ng-required="editableCustInfo">
                                                    <i class="fa fa-user"></i>
                                                    <div ng-show="sbtBtn" ng-messages="sendDocumentForm.last_name.$error" class="help-block">
                                                        <div ng-message="required">This field is required.</div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr><br>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="col-sm-6 col-xs-6">
                                                <div ng-if="documentData.customer_mobile_no != ''">
                                                    <span><b>Mobile :</b> {{ documentData.customer_mobile_no}}<br></span>
                                                </div><br>
                                                <div ng-if="documentData.customer_email_id != ''">
                                                    <span><b>Email : </b>{{ documentData.customer_email_id}}<br></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <!--<b>Address:</b> {{ documentData.customer_address}}-->
                                                <b>Address:</b><span ng-if="documentData.customer_area_name =='' "> -</span><span ng-if="documentData.customer_area_name !='' ">{{ documentData.customer_area_name}}</span>
                                            </div>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="col-sm-4 col-xs-6">  
                                                <div class="form-group">
                                                    <label>Projects<span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right" ng-controller="projectCtrl">
                                                        <select ng-model="documentData.project_id"  name="project_id" class="form-control" ng-change="documentList(documentData.project_id)" required>
                                                            <option value="0">Select Project</option>
                                                            <option ng-repeat="plist in projectList" value="{{plist.id}}" >{{plist.project_name}}</option>
                                                        </select>
                                                        <i class="fa fa-sort-desc"></i>
                                                        <div ng-show="savebtn" ng-messages="sendDocumentForm.project_id.$error" class="help-block errMsg">
                                                            <div ng-message="required">Please select project</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="col-sm-12 col-xs-12 col-md-12">
                                            <div class="col-sm-12 col-xs-12"  ng-show="(documentListData | json) != '{}'">
                                                <label> Select Documents</label>
<!--                                                    <label> 
                                                        <input type="checkbox" name="chkLocation" value="location_map_images">
                                                        <span class="text">Select All</span>
                                                    </label>-->
                                                <div class="form-group">                                                    
                                                    <div class="col-sm-3" ng-repeat="(key,value) in documentListData" ng-if="value !='' && value!= null ">
                                                        <label> 
                                                            <input type="checkbox" name="{{ key }}" value="{{ key }}" id="{{ key }}" class="chkDocList">
                                                            <span class="text" >{{ key | split:"_images":0 | underscoreless:' ' | capitalize }}</span>
                                                        </label>                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><hr>
                                    <div class="row" style="float:right;margin-right: 0px;">
                                        <input type="submit" class="btn btn-primary" name="sendbtn"  id="sendbtn" ng-disabled="" value="Send">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </tab>
                    <tab heading="Documents History" id="historyTab">

                    </tab>
                </tabset>
            </div>
        </div>
    </div>
</div>