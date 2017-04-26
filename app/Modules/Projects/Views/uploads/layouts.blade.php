<div class="row">
    <form role="form">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>Layout Plan</h5>
                <div id="horizontal-form" class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Project Wing</label>
                            <span class="input-icon icon-right">
                                <select ng-model="wing" name="wing" class="form-control" required>
                                    <option value="">Please Select</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Upload Layout Plan</label>
                            <span class="input-icon icon-right">
                                <input type="file" ngf-select ng-model="layout_plan_images" name="layout_plan_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                            </span>                                                   
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="img-div2" data-title="name">
                            <i class="fa fa-times rem-icon" title=""></i>
                            <img class="thumb photoPreview">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>Floor Plan</h5>
                <div id="horizontal-form" class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Project Wing</label>
                            <span class="input-icon icon-right">
                                <select ng-model="wing" name="wing" class="form-control" required>
                                    <option value="">Please Select</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Upload Floor Plan</label>
                            <span class="input-icon icon-right">
                                <input type="file" ngf-select ng-model="floor_plan_images" name="floor_plan_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                            </span>                                                   
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="img-div2" data-title="name">
                            <i class="fa fa-times rem-icon" title=""></i>
                            <img class="thumb photoPreview">
                        </div>
                    </div>
                </div>
                 <div id="horizontal-form" class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Upload Floor Plan</label>
                            <span class="input-icon icon-right">
                                <select multiple ng-model="wing" name="wing" class="form-control" required>
                                    
                                </select>
                            </span>                                                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
            </div> 
        </div>    
    </form>
</div>
