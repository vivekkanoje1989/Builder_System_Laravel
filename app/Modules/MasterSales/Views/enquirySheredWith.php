<form novalidate style="margin-left: 5%;" role="form" name="presa" id="presales" ng-submit="presa.$valid && predata.presalesemployee_id.length != 0 && predata.presalesemployee_id.length != null && preSalesShareEnquiry(predata.presalesemployee_id, all_chk_reassign)">
    <div class="row" >
        <div class="col-sm-6 col-sx-12">
            <div class="form-group" >
                <label for="">Select Employee </label>   
                <ui-select multiple ng-model="predata.presalesemployee_id" name="presalesemployee_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                    <ui-select-match placeholder='Select  Employee'>{{$item.first_name}}</ui-select-match>
                    <ui-select-choices repeat="list in ct_presalesemployee  | filter:$select.search">
                        {{list.first_name + " " + list.last_name + " (" + list.designation + ")"}} 
                    </ui-select-choices>
                </ui-select>
                <div ng-if="sbtBtn"  ng-show="predata.presalesemployee_id.length == 0 || predata.presalesemployee_id.length == null "  class="help-block errMsg">
                    <div style="sp-err" >Please Select Employee</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="margin-top:22px;">
            <button type="submit" name="sbtBtn" ng-click="sbtBtn = true;" value="Share" id="presalesbtn" class="btn btn-primary">Share</button>
        </div>   
    </div>
</form>