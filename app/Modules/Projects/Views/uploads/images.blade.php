<form role="form">
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Logo (Image Size Should be: 250 X 250 pixels)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="project_logo" name="project_logo" id="project_logo" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span> 
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Thumbnail (Image Size Should be 250 X 250 pixels)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="project_thumbnail" name="project_thumbnail" id="project_thumbnail" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
    </div>     
    <div class="row">    
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Favicon (Image Size Should be: 250 X 250 pixels)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="project_favicon" name="project_favicon" id="project_favicon" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Banner Images (Image Size : W 1000 X H 450)</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="project_banner_images" name="project_banner_images" id="project_banner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>        
    </div>

    <div class="row">      
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Background Image</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="project_background_images" name="project_background_images" id="project_background_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Upload Brochure</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select ng-model="project_broacher" name="project_broacher" id="project_broacher" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="img-div2" data-title="name">   
                    <i class="fa fa-times rem-icon"  title=""></i>
                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                </div>
            </div>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
        </div>
    </div>
    <div class="row">     
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label>Project Website</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" ng-model="project_website" name="project_website">
                    </span>                                                   
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
        <div class=""><hr></div>
        <div class="form-group" align="center">
            <button type="submit" class="btn btn-primary">Save & Continue</button>
        </div> 
    </div>  
</form>