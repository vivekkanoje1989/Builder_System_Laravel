<style>
    .fa-times{cursor: pointer;}
</style>
<div class="modal-body">
    <form role="form" name="inventoryInfoForm" ng-submit="inventoryInfoForm.$valid && getInventoryDetails(projectData.prid, inventoryData.wing_id, inventoryData, otherDataMultiple)" novalidate>
        <input type="hidden" ng-model="inventoryInfoForm.csrfToken" name="csrftoken" ng-init="inventoryInfoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for="">Block Type<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <select ng-model="inventoryData.block_type_id" name="block_type_id" class="form-control" required>
                                <option value="">Select block type</option>
                                <option ng-repeat="t in blockList track by $index" value="{{t.id}}" ng-selected="{{ t.id == inventoryData.block_name}}">{{t.block_name}}</option>
                                <!--<option ng-repeat="t in blockList track by $index" value="{{t.get_block_type[0].id}}" ng-selected="{{ t.get_block_type[0].id == inventoryData.block_name}}">{{t.get_block_type[0].block_name}}</option>-->
                            </select>
                            <i class="fa fa-sort-desc"></i> 
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_type_id.$error" class="help-block">
                                <div ng-message="required">Please select block</div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for="">Sub Block Type<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" ng-model="inventoryData.block_sub_type" name="block_sub_type" required>
                            <i class="fa fa-crosshairs"></i>
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_sub_type.$error" class="help-block">
                                <div ng-message="required">Please enter sub block type</div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for="">Sub Block Label<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" placeholder="Show Label On Website" ng-model="inventoryData.block_sub_type_label" name="block_sub_type_label" required>
                            <i class="fa fa-newspaper-o"></i>
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_sub_type_label.$error" class="help-block">
                                <div ng-message="required">Please enter sub block label</div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for=""></label> 
                        <span class="input-icon icon-right">
                            <label>
                                <input class="checkbox-slider slider-icon colored-primary" type="checkbox" ng-model="inventoryData.block_availablity" name="block_availablity" ng-show="inventoryData.block_availablity = (inventoryData.block_availablity == 1 ? true : false);">
                                <span class="text">&nbsp;&nbsp;Block Availablity</span>
                            </label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for="">Sellable area in Sq Ft<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" ng-model="inventoryData.sellable_area_in_sqft" name="sellable_area_in_sqft" required maxlength="10" oninput="if (/[^0-9.]/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                   ng-change="inventoryData.sellable_area_in_sqmtr = (inventoryData.sellable_area_in_sqft*0.092903).toFixed(3)">
                            <i class="fa fa-pencil"></i>
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.sellable_area_in_sqft.$error" class="help-block">
                                <div ng-message="required">Please enter sellable area in Sqft</div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for="">Sellable area in Sqm<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" ng-model="inventoryData.sellable_area_in_sqmtr" name="sellable_area_in_sqmtr" required maxlength="10" oninput="if (/[^0-9.]/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')">
                            <i class="fa fa-pencil"></i>
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.sellable_area_in_sqft.$error" class="help-block">
                                <div ng-message="required">Please enter sellable area in Sqm</div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for="">Block Quantity<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <input type="text" class="form-control" ng-model="inventoryData.block_quantity" name="block_quantity" required oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                            <i class="fa fa-pencil"></i>
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_quantity.$error" class="help-block">
                                <div ng-message="required">Please enter block quantity</div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-sm-3 col-sx-6">
                    <div class="form-group">
                        <label for=""></label> 
                        <span class="input-icon icon-right">
                            <label>
                                <input class="checkbox-slider slider-icon colored-primary" type="checkbox" ng-model="inventoryData.show_on_website" name="show_on_website" ng-show="inventoryData.show_on_website = (inventoryData.show_on_website == 1 ? true : false);">
                                <span  class="text">&nbsp;&nbsp;Show On Website</span>
                            </label>
                        </span>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="col-sm-12 col-sx-6">
                    <div class="form-group">
                        <label for="">Block Description<span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <textarea ng-model="inventoryData.block_description" name="block_description" class="form-control" maxlength="300" capitalizeFirst required></textarea>
                            <i class="fa fa-align-justify"></i>
                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_description.$error" class="help-block">
                                <div ng-message="required">Please enter block description</div>
                            </div>
                        </span>
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="">
                <div class="widget-header bg-themeprimary">
                    <span class="widget-caption">Other Block Specification</span>
                </div>
                <div class="widget-body">
                    <div class="row" ng-repeat="otherData in otherDataMultiple">
                        <div class="">
                            <div class="col-sm-4 col-sx-6">
                                <div class="form-group">
                                    <label for="">Label<span class="sp-err" ng-show="{{$index}} != 0">*</span></label>
                                    <span class="input-icon icon-right"> 
                                        <input type="hidden" ng-model="otherData.other_block_id" name="other_block_id" value="{{otherData.id}}">
                                        <input type="text" class="form-control" ng-model="otherData.other_label" name="other_label" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" ng-required="{{$index}} != 0">
                                        <i class="fa fa-align-justify"></i>
                                        <div ng-show="sbtBtn && {{$index}} != 0" ng-messages="inventoryInfoForm.other_label.$error" class="help-block">
                                            <div ng-message="required">Please enter block label</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-sx-6">
                                <div class="form-group">
                                    <label for="">Value in Sq Ft<span class="sp-err" ng-show="{{$index}} != 0">*</span></label>
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="otherData.area_in_sqft" name="area_in_sqft" maxlength="10" oninput="if (/[^0-9.]/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                               ng-change="otherData.area_in_sqmtr = (otherData.area_in_sqft*0.092903).toFixed(3)" ng-required="{{$index}} != 0">
                                        <i class="fa fa-times" ng-click="otherData.area_in_sqft='';otherData.area_in_sqmtr=''"></i>
                                        <div ng-show="sbtBtn && {{$index}} != 0" ng-messages="inventoryInfoForm.area_in_sqft.$error" class="help-block">
                                            <div ng-message="required">Please enter area in square feet</div>
                                        </div>
                                    </span>
                                    
                                </div>
                            </div>
                            <div class="col-sm-2 col-sx-6">
                                <div class="form-group">
                                    <label for="">Value in Sqm<span class="sp-err" ng-show="{{$index}} != 0">*</span></label>
                                    <span class="input-icon icon-right">                                        
                                        <input type="text" class="form-control"  ng-model="otherData.area_in_sqmtr" name="area_in_sqmtr" maxlength="10" oninput="if (/[^0-9.]/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                               ng-change="otherData.area_in_sqft = (otherData.area_in_sqft ==null || otherData.area_in_sqft == '') ? (otherData.area_in_sqmtr/0.092903).toFixed(3) : otherData.area_in_sqft" ng-required="{{$index}} != 0">
                                        <i class="fa fa-times" ng-click="otherData.area_in_sqmtr=''"></i>
                                        <div ng-show="sbtBtn && {{$index}} != 0" ng-messages="inventoryInfoForm.area_in_sqmtr.$error" class="help-block">
                                            <div ng-message="required">Please enter area in square meter</div>
                                        </div>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="col-sm-2 col-sx-6">
                                <div class="form-group">
                                    <label for="">Show On Web</label>
                                    <span class="input-icon icon-right">
                                        <label>
                                            <input class="checkbox-slider slider-icon colored-primary" type="checkbox" ng-model="otherData.other_block_show_on_website" name="other_block_show_on_website" ng-show="otherData.other_block_show_on_website = (otherData.other_block_show_on_website == 1 ? true : false);">
                                            <span class="text"></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-sx-6">
                                <div class="form-group">
                                    <label for=""></label>
                                    <span class="input-icon icon-right">
                                        <button type="button" class="btn btn-primary btn-xs" ng-if="$last" ng-click="addNewData()">Add</button>
                                        <button type="button" class="btn btn-primary btn-xs" ng-show="!$first" ng-click="removeRow($index)">Remove</button>                                        
                                    </span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="row col-lg-12 col-sm-12 col-xs-12">
                <div class="form-group" align="right">
                    <label for=""></label>
                    <span class="input-icon icon-right">
                        <button type="submit" class="btn btn-primary" ng-click="sbtBtn = true">Save</button>
                    </span>
                </div>
            </div>
        </div>        
    </form>
</div>

