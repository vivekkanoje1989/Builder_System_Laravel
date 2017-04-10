<div class="row">
    <form role="form">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="horizontal-form">
                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Location Map</label>
                        <span class="input-icon icon-right">
                            <select ng-model="wing" name="wing" class="form-control" required>
                                <option value="">Please Select</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Google Map Iframe</label>
                        <span class="input-icon icon-right">
                            <input type="file" ngf-select ng-model="project_thumbnail" name="project_thumbnail" id="project_thumbnail" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                        </span>                                                   
                    </div>
                </div>
                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Google Map URL</label>
                        <span class="input-icon icon-right">
                            <input type="file" ngf-select ng-model="project_thumbnail" name="project_thumbnail" id="project_thumbnail" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" ng-change="checkImageExtension(userData.emp_photo_url)">
                        </span>                                                   
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
