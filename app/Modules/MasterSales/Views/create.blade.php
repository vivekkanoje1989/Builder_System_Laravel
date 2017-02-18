<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget-body bordered-top bordered-sky col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" ng-submit="customerForm.$valid && create(customerData)" name="customerForm" ng-controller="customerController" >
                        <input type="hidden" ng-model="customerData.csrfToken" name="csrftoken" id="csrftoken" ng-init="customerData.csrfToken = '[[ csrf_token() ]]'" class="form-control">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-title">
                                    Customer Details 
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Mobile Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.searchWithMobile" get-customer-details minlength="10" maxlength="10" name="searchWithMobile" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" ng-model-options="{allowInvalid: true, debounce: 100 }">
                                                <i class="glyphicon glyphicon-phone"></i>
                                                <div ng-show="sbtBtn" ng-messages="customerData.searchWithMobile.$error" class="help-block">
                                                    <div ng-message="minlength">Invalid mobile no.</div>
                                                    <div ng-message="customerInputs">Mobile number does not exist!</div>
                                                </div> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email ID</label>
                                            <span class="input-icon icon-right">
                                                <input type="email" class="form-control" get-customer-details ng-model="customerData.searchWithEmail" name="searchWithEmail" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model-options="{ allowInvalid: true, debounce: 500 }">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>  
                        <div class="row col-lg-12 col-sm-12 col-xs-12">  
                            <hr class="wide" />
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-title">
                                    Personal Details
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <span class="input-icon icon-right" style="width: 35%;float: left;">
                                                <select ng-model="customerData.title_id" name="title_id" style="width: 95%;">
                                                    <option>Mr.</option>
                                                    <option>Mrs.</option>
                                                    <option>Miss.</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.first_name" name="first_name">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Middle Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.middle_name" name="middle_name">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Last Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="customerData.last_name" name="last_name">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Profession</label>
                                            <span class="input-icon icon-right">
                                                <select style="width:100%;">
                                                    <option>Profession 1</option>
                                                    <option>Profession 2 </option>
                                                    <option>Profession 3</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Monthly Income</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-money"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Pan Number</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text" data-date-format="dd-mm-yyyy">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Aadhar Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Birth Date</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text" data-date-format="dd-mm-yyyy">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Photo</label>
                                            <span class="input-icon icon-right">
                                                <input type="file">
                                                <img class="thumb photoPreview"/>
                                                <i class="fa fa-file-image-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Marrage Date</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text" data-date-format="dd-mm-yyyy">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Source Description</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-share"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">SMS Privacy Status</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text" data-date-format="dd-mm-yyyy">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email Privacy Status</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <hr class="wide col-md-12" />
                        </div>    
                        <div class="row col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-title">
                                    Contact Details
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Number Type</label>
                                            <span class="input-icon icon-right">
                                                <select style="width:100%;">
                                                    <option>Personal</option>
                                                    <option>Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <span class="input-icon icon-right">
                                                <label for="">Email Type</label>
                                                <select  style="width:100%;">
                                                    <option>Personal</option>
                                                    <option>Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Mobile Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="glyphicon glyphicon-phone"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email ID</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Address</label>		
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">landmark</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-thumb-tack"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <span class="input-icon icon-right">
                                                <select style="width:100%;">
                                                    <option>City 1</option>
                                                    <option>City 2</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <span class="input-icon icon-right">
                                                <label for="">State</label>
                                                <select  style="width:100%;">
                                                    <option>State 1</option>
                                                    <option>State 2</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">House Number</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text">
                                                <i class="fa fa-home"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Building House Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Wing Name</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Area Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-compass" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div align="right">
                                    <button type="submit" class="btn btn-primary btn-round"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>                   
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-title">
                                    Contact Details
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Number Type</label>
                                            <span class="input-icon icon-right">
                                                <select style="width:100%;">
                                                    <option>Personal</option>
                                                    <option>Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <span class="input-icon icon-right">
                                                <label for="">Email Type</label>
                                                <select  style="width:100%;">
                                                    <option>Personal</option>
                                                    <option>Office</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Mobile Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="glyphicon glyphicon-phone"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Email ID</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Address</label>		
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">landmark</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-thumb-tack"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <span class="input-icon icon-right">
                                                <select style="width:100%;">
                                                    <option>City 1</option>
                                                    <option>City 2</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <span class="input-icon icon-right">
                                                <label for="">State</label>
                                                <select  style="width:100%;">
                                                    <option>State 1</option>
                                                    <option>State 2</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">House Number</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text">
                                                <i class="fa fa-home"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Building House Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Wing Name</label>
                                            <span class="input-icon icon-right">
                                                <input class="form-control date-picker" id="" type="text">
                                                <i class="fa fa-building-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Area Name</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control">
                                                <i class="fa fa-compass" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div align="right">
                                    <button type="submit" class="btn btn-primary btn-round"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>                        
                        </div>
                        <hr class="wide col-lg-12 col-xs-12 col-md-12" />
                        <div class="col-lg-12 col-xs-12 col-md-12" align="center">
                            <button type="submit" class="btn btn-primary" ng-click="sbtBtn=true">Save & Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .btn-round{
        border-radius: 50%;
        height: 40px;
        width: 40px;
        line-height: 28px;
        padding-left: 13px;
        outline: none !important;
    }
</style>