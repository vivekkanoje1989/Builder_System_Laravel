<div class="row" ng-controller="testimonialsCtrl" >  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Create Testimonials</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div> 
            <div class="widget-body table-responsive">     
                <form novalidate ng-submit="testimonialsForm.$valid && doTestimonialsAction(photo_url)" name="testimonialsForm" enctype="multipart/form-data">
                     <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <td colspan="2">Create Testimonials</td>
                            <tr>
                        </thead>
                        <tbody>

                            <tr><td>Customer name <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.customer_name.$dirty && testimonialsForm.customer_name.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="customer_name" name="customer_name" ng-change="errorMsg = null" required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.customer_name.$error">
                                                <div ng-message="required">Customer name is required</div>
                                                <div ng-if="errorMsg">{{errorMsg}}</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr><td>company name <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.company_name.$dirty && testimonialsForm.company_name.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="company_name" name="company_name"  required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.company_name.$error">
                                                <div ng-message="required">Company name is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>


                            <tr><td>Photo</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.photo_url.$dirty && testimonialsForm.photo_url.$invalid) }">

                                        <span class="input-icon icon-right">
                                            <input type="file" ngf-select  ng-model="photo_url" name="photo_url" id="photo_url" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile">
                                            <br/>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.photo_url.$error">
                                                <div ng-message="required">Photo is required</div>
                                                <div ng-if="invalidImage">{{invalidImage}}</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>  
                                </td>
                            </tr>
                            <tr><td>Video url <span class="sp-err">*</span></td>
                                <td>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="video_url" name="video_url">
                                    </span>
                                </td>
                            </tr>
                            <tr><td>Mobile No. <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.mobile_number.$dirty && testimonialsForm.mobile_number.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="number" class="form-control" ng-model="mobile_number" name="mobile_number"  ng-maxlength="10" ng-minlength="10" required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.mobile_number.$error">
                                                <div ng-message="required">Mobile no is required</div>
                                                <div ng-message="maxlength">Mobile no must be 10 digit</div>
                                                <div ng-message="minlength">Mobile no must be 10 digit</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr><td>Testimonial</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.description.$dirty && testimonialsForm.description.$invalid) }">

                                        <span class="input-icon icon-right">
                                            <textarea ng-model="testimonial" name="description" cols="50" rows="5" required></textarea>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.description.$error">
                                                <div ng-message="required">Testimonial is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>     
                                </td>
                            </tr>
                            <tr><td>Display on Portal</td>
                                <td>
                                    <span class="input-icon icon-right">
                                        <select name="web_status" ng-model="web_status"  class="form-control" style="width:30%;">
                                            <option value="1" >Yes</option> 
                                            <option value="0" >No</option>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr><td></td>
                                <td><button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

