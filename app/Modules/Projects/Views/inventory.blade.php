<div class="row" >
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div ng-if="notFound">No wings found</div>
        <tabset class="tabs-left" ng-show="wingList">
            <tab ng-repeat="wlist in wingList" heading="{{wlist.wing_name}}" ng-click="getInventoryDetails({{wlist.id}})" class="themeprimary">
                <div class="row">
                    <form role="form" name="inventoryInfoForm" ng-submit="saveInventoryInfo(wlist.id,inventoryData)" novalidate>
                        <input type="hidden" ng-model="inventoryInfoForm.csrfToken" name="csrftoken" ng-init="inventoryInfoForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Block Type<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="inventoryData.block_type_id" name="block_type_id" class="form-control" required>
                                                <option value="">Select block type</option>
                                                <option ng-repeat="t in blockList track by $index" value="{{t.get_block_type[0].id}}" ng-selected="{{ t.get_block_type[0].id == inventoryData.block_name}}">{{t.get_block_type[0].block_name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i> 
                                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_type_id.$error" class="help-block">
                                                <div ng-message="required">This field is</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Block Sub Type<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.block_sub_type" name="block_sub_type" required>
                                            <i class="fa fa-crosshairs"></i>
                                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_sub_type.$error" class="help-block">
                                                <div ng-message="required">Please enter first name</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Block Availability<span class="sp-err">*</span></label>    
                                        <div class="control-group">
                                            <div class="radio">
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="inventoryData.block_availablity" value="1" class="colored-success" required>
                                                    <span class="text">Available</span>
                                                </label>
                                                &nbsp;&nbsp;
                                                <label>
                                                    <input name="form-field-radio" type="radio" ng-model="inventoryData.block_availablity" value="2" class="colored-blue" required>
                                                    <span class="text">Not Available</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Carpet area in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.carpet_area_in_sqft" name="carpet_area_in_sqft" oninput="if (/[^\d\.]/g.test(this.value)) this.value = this.value.replace(/[^\d\.]/g,'')">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Carpet area in sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.carpet_area_in_sqmtr" name="carpet_area_in_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Carpet terrace in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.carpet_terrace_in_sqft" name="carpet_terrace_in_sqft">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Carpet terrace in sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.carpet_terrace_in_sqmtr" name="carpet_terrace_in_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Mezzanine area in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.mezzanine_area_in_sqft" name="mezzanine_area_in_sqft">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Mezzanine area in sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.mezzanine_area_in_sqmtr" name="mezzanine_area_in_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Additional area in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.additional_area_in_sqft" name="additional_area_in_sqft">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Additional area in sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.additional_area_in_sqmtr" name="additional_area_in_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Sellable area in sqft<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.sellable_area_in_sqft" name="sellable_area_in_sqft" required>
                                            <i class="fa fa-crosshairs"></i>
                                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_sub_type.$error" class="help-block">
                                                <div ng-message="required">Please enter first name</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Sellable area in sqmtr<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.sellable_area_in_sqmtr" name="sellable_area_in_sqmtr" required>
                                            <i class="fa fa-crosshairs"></i>
                                            <div ng-show="sbtBtn" ng-messages="inventoryInfoForm.block_sub_type.$error" class="help-block">
                                                <div ng-message="required">Please enter first name</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-lg-12  col-sm-12 col-xs-12"><hr></div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other1 label</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other1_label" name="other1_label" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other1 value in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other1_value_sqft" name="other1_value_sqft">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other1 value sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other1_value_sqmtr" name="other1_value_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other2 label</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other2_label" name="other2_label" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other2 value in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other2_value_sqft" name="other2_value_sqft">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other2 value sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other2_value_sqmtr" name="other2_value_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other3 label</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other3_label" name="other3_label" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other3 value in sqft</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other3_value_sqft" name="other3_value_sqft">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Other3 value sqmtr</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="inventoryData.other3_value_sqmtr" name="other3_value_sqmtr">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" ng-click="sbtBtn=true">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </tab>
        </tabset>
    </div>
</div>