<style>
    .thumb{
        width: 70px;
        height: 70px;
        margin-top: -15px !important;
    }
    .help-block {
        color: #e46f61;
    }
</style>
<div class="row" ng-controller="testimonialsCtrl">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Create Testimonial</span>
            </div>
            <div class="widget-body">
                <form novalidate ng-submit="testimonialsForm.$valid && doTestimonialsAction(testimonial.photo_url,testimonial)" name="testimonialsForm" enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Customer Name <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.customer_name.$dirty && testimonialsForm.customer_name.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="testimonial.customer_name" name="customer_name" ng-change="errorMsg = null" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.customer_name.$error">
                                            <div ng-message="required">Customer name is required</div>
                                            <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                        </div>
                                        <div ng-if="customer_name" class="sp-err customer_name">{{customer_name}}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Company Name<span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.company_name.$dirty && testimonialsForm.company_name.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="testimonial.company_name" name="company_name"  required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.company_name.$error">
                                            <div ng-message="required">Company name is required</div>
                                        </div>
                                        <div ng-if="company_name" class="sp-err company_name">{{company_name}}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Mobile number<span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.mobile_number.$dirty && testimonialsForm.mobile_number.$invalid) }" >
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="testimonial.mobile_number" name="mobile_number"  maxlength="10" minlength="10" required oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.mobile_number.$error">
                                            <div ng-message="required">Mobile no is required</div>
                                            <div ng-message="maxlength">Mobile no must be 10 digit</div>
                                            <div ng-message="minlength">Mobile no must be 10 digit</div>
                                        </div>
                                        <div ng-if="mobile_number" class="sp-err mobile_number">{{mobile_number}}</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Video url </label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="testimonial.video_url" name="video_url">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Photo<span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.photo_url.$dirty && testimonialsForm.photo_url.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select  ng-model="testimonial.photo_url" name="photo_url" id="photo_url" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile">
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.photo_url.$error">
                                            <div ng-message="required">Photo is required</div>
                                            <div ng-if="invalidImage">{{invalidImage}}</div>
                                        </div>
                                        <div ng-if="photo_url" class="sp-err photo_url">{{photo_url}}</div>
                                    </span>
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Display on website <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select name="web_status" ng-model="testimonial.web_status"  class="form-control" >
                                        <option value="1" >Yes</option> 
                                        <option value="0" >No</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Description <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.description.$dirty && testimonialsForm.description.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="testimonial.description" name="description" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.description.$error">
                                            <div ng-message="required">Description is required</div>
                                        </div>
                                        <div ng-if="description" class="sp-err description">{{description}}</div>
                                    </span>
                                </div>  
                            </div>
                        </div>
                    </div> 
                    <div class="row" ng-if="photo_url_preview || photo_url">
                        <div class="col-sm-3 col-xs-6">
                            <div ng-if="!photo_url_preview" class="img-div2" data-title="name">    
                                <img ng-src="[[ Session::get('s3Path') ]]/Testimonial/{{photo_url}}" class="thumb photoPreview">
                            </div>
                            <div class="img-div2" data-title="name" ng-repeat="list in photo_url_preview"> 
                                <img ng-src="{{list}}" class="thumb photoPreview">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="testimonialsBtn">Submit</button>
                            <a href="[[ config('global.backendUrl') ]]#/testimonials/index" class="btn btn-primary"><< Back To List</a>
                        </div>
                    </div>
                </form>
            </div>
	</div>
    </div>
</div>

