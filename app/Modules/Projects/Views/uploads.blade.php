<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <tabset class="tabs-left">
            <tab heading="Projects Images">
                <form role="form">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Logo (Image Size Should be: 250 X 250 pixels)</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="project_logo" name="project_logo" id="project_logo" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                                    </span> 
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-6">
                                <div class="img-div2" data-title="name">   
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 col-lg-12 "><hr></div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Thumbnail (Image Size Should be 250 X 250 pixels)</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="project_thumbnail" name="project_thumbnail" id="project_thumbnail" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                                    </span>                                                   
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-6">
                                <div class="img-div2" data-title="name">   
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 col-lg-12 "><hr></div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Favicon (Image Size Should be: 250 X 250 pixels)</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="project_favicon" name="project_favicon" id="project_favicon" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                                    </span>                                                   
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-6">
                                <div class="img-div2" data-title="name">   
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 col-lg-12 "><hr></div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Banner Images (Image Size Should be: W 1000 X H 450)</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="project_banner_images" name="project_banner_images" id="project_banner_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                                    </span>                                                   
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-6">
                                <div class="img-div2" data-title="name">   
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 col-lg-12 "><hr></div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Background Image</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="project_background_images" name="project_background_images" id="project_background_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                                    </span>                                                   
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-6">
                                <div class="img-div2" data-title="name">   
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 col-lg-12 "><hr></div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Upload Brochure</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="project_broacher" name="project_broacher" id="project_broacher" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                                    </span>                                                   
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-6">
                                <div class="img-div2" data-title="name">   
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img src="[[config('global.s3Path')]]Banner-Images/14909572820.jpg" style="width: 60px;height: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 col-lg-12 "><hr></div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label>Project Website</label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="project_website" name="project_website">
                                    </span>                                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </tab>
            <tab heading="Projects Status">
                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
            </tab>
            <tab heading="Projects Layout">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
            </tab>
            <tab heading="Projects Map">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
            </tab>
            <tab heading="Projects Amenities">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
            </tab>
            <tab heading="Projects Specification">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
            </tab>
            <tab heading="Projects Gallery">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
            </tab>
            <tab heading="Projects Events">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
            </tab>
        </tabset>
        <div class="horizontal-space"></div>
    </div>
</div>



