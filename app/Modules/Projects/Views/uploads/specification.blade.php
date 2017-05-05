<style>
#container {
    width: 20%;
    border: 1px solid Black;
    padding: 5px 5px 5px 10px;
    margin: 0px 0px 10px 0px;
    /*background: #A4D3EE;*/
    overflow: visible;
    position: relative;
}

#x {
    position: absolute;
    background: black;
    color: white;
    top: -10px;
    right: -10px;
}
</style>
<div class="row">
    <form role="form" name="galleryForm" ng-submit="saveBasicInfo(specificationData, projectImages)">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group">
                    <label></label>
                    <div id="container">
                        <button id = "x">X</button>
                        A Wing Floor:2,3
                    </div>
                    <span class="input-icon icon-right">
                        <a href data-toggle="modal" data-target="#specificationDataModal" ng-click="resetSpecificationDetails()">CLICK HERE TO UPLOAD SPECIFICATION</a> 
                    </span>                                                   
                </div>
            </div> 
        </div>   
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="widget flat radius-bordered">
                    <div class="widget-header bordered-bottom bordered-themeprimary">
                        <span class="widget-caption">Specification Description</span>
                    </div>
                    <div class="widget-body no-padding">
                        <div ng-controller="TextAngularCtrl">
                            <div text-angular ng-model="specificationData.specification_description" name="specification_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
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
 <!-- Modal -->
<div class="modal fade" id="specificationDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Specification Details</h4>
            </div>
            <form novalidate name="modalForm" ng-submit="specicationRow(modalData,modalImages)">
                <div class="modal-body">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="row" ng-init="wings()">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Wing</label>
                                    <span class="input-icon icon-right">
                                        <select ng-model="modalData.wing" name="wing" class="form-control" ng-change="selectFloor(modalData.wing)">
                                            <option value="">Select Wing</option>
                                            <option ng-repeat="wList in wingList" value="{{wList.id}}">{{wList.wing_name}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                    </span>
                                </div>
                            </div>
                        
                            <div class="col-sm-12">
                                <div class="form-group multi-sel-div">
                                    <label for="">Select Floors </label>	
                                    <ui-select multiple ng-model="modalData.floors" name="floors" theme="select2">
                                        <ui-select-match>{{$item.floor_name}}</ui-select-match>
                                        <ui-select-choices repeat="flist in floorList | filter:$select.search">
                                            {{flist.floor_name}} 
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Specification Images (Size: W 250 X H 250)</label>
                                    <span class="input-icon icon-right">
                                        <input type="file" ngf-select ng-model="modalData.specification_images" name="specification_images" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ng-change="checkImageExtension(projectImages.specification_images)">
                                    </span>    
                                    <span class="help-block">{{specification_images_err}}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12" ng-if="specification_images">
                                <div class="img-div2" data-title="name" ng-repeat="list in specification_images">    
                                    <i class="fa fa-times rem-icon"  title=""></i>
                                    <img ng-src="{{list}}" class="thumb photoPreview">
                                </div>
                            </div> 
                        </div>  
                    </div>
                <div class="modal-footer" align="left">
                    <button type="submit" class="btn btn-primary" ng-click="modalSbtBtn=true">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
