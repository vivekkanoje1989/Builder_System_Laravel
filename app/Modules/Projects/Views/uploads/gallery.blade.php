<div class="row">
    <form role="form" name="galleryForm" ng-submit="!galleryForm.$pristine && galleryForm.$valid && uploadsData(projectData.prid, galleryImages, galleryData)">
        <input type="hidden" ng-model="galleryForm.csrfToken" name="csrftoken" ng-init="galleryForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Video Link</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" ng-model="galleryData.video_link" name="video_link" ng-pattern="/^((http[s]?|ftp):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/"/>
                        <div ng-show="formButton" ng-messages="galleryForm.video_link.$error" class="help-block errMsg">
                            <div ng-message="pattern">Please enter valid url</div>
                        </div>
                    </span>                                                   
                </div>
            </div>  
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Video Short Link</label>
                    <span class="input-icon icon-right">
                        <input type="text" class="form-control" ng-model="galleryData.video_short_link" name="video_short_link" ng-pattern="/^((http[s]?|ftp):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/"/>
                        <div ng-show="formButton" ng-messages="galleryForm.video_short_link.$error" class="help-block errMsg">
                            <div ng-message="pattern">Please enter valid url</div>
                        </div>
                    </span>                                                   
                </div>
            </div>
        </div>  
        
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>Project Gallery</label>
                    <span class="input-icon icon-right">
                        <input type="file" ngf-select multiple ng-model="galleryImages.project_gallery" name="project_gallery" id="project_gallery" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile">
                    </span>                                                   
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" ng-if="project_gallery">
                <div class="img-div2" data-title="name" ng-repeat="list in project_gallery" id="del_project_gallery_{{$index}}">    
                    <i class="fa fa-times rem-icon" title="{{list}}" ng-click="deleteImage({{project_gallery}},'{{list}}', {{$index}}, {{projectData.project_id}}, 'project/project_gallery/', 'project_gallery')"></i>
                    <img ng-src="[[ config('global.s3Path') ]]/project/project_gallery/{{list}}" class="thumb photoPreview">
                </div>
                <div class="img-div2" data-title="name" ng-repeat="list in project_gallery_preview">    
                    <i class="fa fa-times rem-icon" title=""></i>
                    <img ng-src="{{list}}" class="thumb photoPreview">
                </div>
            </div>            
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br>
            <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-primary" ng-click="formButton=true">{{btnLabel}}</button>
                <button type="button" class="btn btn-primary" ng-click="cancel_uploads()">Cancel</button>
            </div> 
        </div>
    </form>
</div>
