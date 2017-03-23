<div class="row" ng-controller="testimonialsCtrl" >  
    <div>
        <flash-message duration="5000"></flash-message>
    </div>
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
                <form novalidate ng-submit="testimonialsForm.$valid && doTestimonialsAction(photo_src)" name="testimonialsForm" enctype="multipart/form-data">
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <td colspan="2">Create Testimonials</td>
                        <tr>
                    </thead>
                    <tbody>
                       
                            <tr><td>Person name *</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.person_name.$dirty && testimonialsForm.person_name.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="person_name" name="person_name" placeholder="person name" ng-change="errorMsg = null" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.person_name.$error">
                                            <div ng-message="required">Person name is required</div>
                                            <div ng-if="errorMsg">{{errorMsg}}</div>
                                        </div>
                                        <br/>
                                    </span>
                                    </div>
                                </td>
                            </tr>
                             <tr><td>company name *</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.company_name.$dirty && testimonialsForm.company_name.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="company_name" name="company_name" placeholder="Company name" required>
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
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.photo_src.$dirty && testimonialsForm.photo_src.$invalid) }">
                                   
                                    <span class="input-icon icon-right">
                                      <input type="file" ngf-select multiple ng-model="photo_src" name="photo_src" id="photo_src" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile">
                                        <br/>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.photo_src.$error">
                                            <div ng-message="required">Photo is required</div>
                                        </div>
                                        <br/>
                                    </span>
                                    </div>  
                                </td>
                            </tr>
                            <tr><td>Video url *</td>
                                <td>
                                     <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="video_url" name="video_url" placeholder="Video url" >
                                     </span>
                                </td>
                            </tr>
                            <tr><td>Mobile No. *</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.mobile_no.$dirty && testimonialsForm.mobile_no.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="number" class="form-control" ng-model="mobile_no" name="mobile_no" placeholder="Mobile no" ng-maxlength="10" ng-minlength="10" required>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.mobile_no.$error">
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
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.testimonial.$dirty && testimonialsForm.testimonial.$invalid) }">
                                   
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="testimonial" name="testimonial" cols="50" rows="5" required></textarea>
                                       <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.testimonial.$error">
                                            <div ng-message="required">Testimonial is required</div>
                                        </div>
                                        <br/>
                                    </span>
                                   </div>     
                                </td>
                            </tr>
                            <tr><td>Display on Portal</td>
                                <td><div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!testimonialsForm.is_shown.$dirty && testimonialsForm.is_shown.$invalid) }">
                                   <span class="input-icon icon-right">
                                        <select name="status" ng-model="is_shown" name="is_shown" class="form-control" style="width:30%;">
                                            <option value="1">Yes</option> 
                                            <option value="0" selected>No</option>
                                        </select>
                                       <div class="help-block" ng-show="sbtBtn" ng-messages="testimonialsForm.is_shown.$error">
                                            <div ng-message="required">Status is required</div>
                                        </div>
                                    </span>
                                </td>
                                    </div>
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

