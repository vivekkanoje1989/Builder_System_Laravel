<form name="promotionalsmsForm" novalidate ng-submit="promotionalsmsForm.$valid && sendPromotionalSMS(promotionalsmsData,promotionalsmsData.mobilenumbers)" ng-controller="promotionalsmsController">
    <input type="hidden" ng-model="promotionalsmsForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="promotionalsmsForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
<div class="col-lg-10 col-sm-10 col-xs-12">
    <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}}</h5>
                        <div class="widget flat radius-bordered">
                            <div class="widget-header bordered-bottom bordered-themeprimary">
                                <span class="widget-caption">Promotional SMS</span>
                            </div>
                            <div class="widget-body">
                                <div id="promotionalsms-form">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="send_sms_type" ng-model="promotionalsmsData.send_sms_type" ng-init="promotionalsmsData.send_sms_type =1" type="radio" value="1">
                                                        <span class="text">Simple SMS </span>
                                                    </label>
                                                    <label>
                                                       <input name="send_sms_type" ng-model="promotionalsmsData.send_sms_type" type="radio" value="2">
                                                        <span class="text">Bulk SMS </span>
                                                    </label>
                                                    <label>
                                                       <input name="send_sms_type" ng-model="promotionalsmsData.send_sms_type" type="radio" value="3">
                                                        <span class="text">Send SMS to Customer </span>
                                                    </label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="">SMS Type <span class="sp-err">*</span></label>
                                                    <span class="input-icon icon-right">
                                                        <select ng-model="promotionalsmsData.sms_type" ng-init="promotionalsmsData.sms_type=2" name="sms_type"  class="form-control">
                                                            <option value="1">Regular SMS</option>
                                                             <option value="2">Flash SMS</option>                                                 
                                                        </select>
                                                       <i class="fa fa-sort-desc"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!promotionalsmsForm.sms_body.$dirty && promotionalsmsForm.sms_body.$invalid)}">
                                                    <label for="">Enter SMS Body </label>
                                                    <textarea ng-model="promotionalsmsData.sms_body" id="sms_body" name="sms_body" class="form-control" rows="8" required></textarea>
                                                    <span class="input-icon icon-right">
                                                        <div ng-show="step1" ng-messages="promotionalsmsForm.sms_body.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                    </span>
                                                </div>
                                                <h5 style="margin-top:20px">SMS Count : <span id ="totalsms">1</span> SMS Characters Count : <span id="totalcharacters">0</span></h5>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12" ng-show="promotionalsmsData.send_sms_type == 1">
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!promotionalsmsForm.smsnumbers.$dirty && promotionalsmsForm.smsnumbers.$invalid)}">
                                                    <label for="">Enter Comma Separated Mobile Numbers </label>
                                                    <textarea ng-model="promotionalsmsData.smsnumbers" id="smsnumbers" name="smsnumbers" class="form-control" rows="8" ng-required="promotionalsmsData.send_sms_type == 1"></textarea>
                                                    <span class="hide" id="lengtherr">Mobile number is not valid</span>
                                                    <h5 style="margin-top:20px">Number Count : <span id="totalnumbers">0</span></h5>
                                                    <span class="input-icon icon-right">
                                                        <div ng-show="step1" ng-messages="promotionalsmsForm.smsnumbers.$error" class="help-block step1">
                                                            <div ng-message="required">This field is required.</div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12" ng-show="promotionalsmsData.send_sms_type == 2"> 
                                                <div class="form-group" ng-class="{ 'has-error' : step1 && (!promotionalsmsForm.mobilenumbers.$dirty && promotionalsmsForm.mobilenumbers.$invalid)}">
                                                    <label for="">Upload .xlsx Format Only </label>
                                                    <input type="file" ngf-select ng-model="promotionalsmsData.mobilenumbers"  id="mobilenumbers" class="form-control" name="mobilenumbers" accept="xls/*" ng-required="promotionalsmsData.send_sms_type == 2">
                                                    <span class="input-icon icon-right">
                                                        <div ng-show="step1" ng-messages="promotionalsmsForm.mobilenumbers.$error" class="help-block step1">
                                                            <div ng-message="required">File is not selected.</div>
                                                        </div>
                                                    </span>
                                                    <span><a class="sample-link" href="https://s3-ap-south-1.amazonaws.com/lms-auto-common/bulk_file/sample_bulk_sms_file.xlsx" target="_blank">Download Sample</a></span>
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="row">
                                            <center><button type="submit" class="btn btn-primary" ng-click="step1=true">Submit</button></center>
                                        </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
      </form>


<script>
    $( document ).ready(function() {
        $('#sms_body').keyup(function() {
            var text_length = $('#sms_body').val().length;
            if(text_length < 160)
            {
                $('#totalsms').html(1);
            }
            if(text_length > 160)
            {
                $('#totalsms').html(2);
            }
            if(text_length > 320 )
            {
                $('#totalsms').html(3);
            }
            $('#totalcharacters').html(text_length);
        });
        
        
        $("#smsnumbers").keypress(function(e) {
                     var kcode = e.which || e.keyCode;
                    if ((kcode >= 48 && kcode <= 57) ||kcode==188||kcode==8||kcode==44) {
                        $("#lengtherr").addClass("hide");
                        if(kcode==44)
                        {
                            var strnumbers = $("#smsnumbers").val();
                            var arrnumbers = strnumbers.split(',');
                            
                            $("#totalnumbers").html(arrnumbers.length);
                        }
                    }
                    else {
                            e.preventDefault();
                    }
	});
        
    });
    
    
    </script>