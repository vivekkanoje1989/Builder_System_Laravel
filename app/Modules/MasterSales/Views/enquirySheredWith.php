<form novalidate style="margin-left: 5%;" role="form" name="presa" id="presales" ng-submit="preSalesShareEnquiry(predata.presalesemployee_id, all_chk_reassign)">
    <div class="row" >
        <div class="col-sm-6 col-sx-12">
            <div class="form-group" >
                <label for="">Select Employee </label>   
                <ui-select multiple ng-model="predata.presalesemployee_id" name="category_id" theme="select2" ng-disabled="disabled" style="width: 100%;">
                    <ui-select-match placeholder='Select  Employee'>{{$item.first_name}}</ui-select-match>
                    <ui-select-choices repeat="list in ct_presalesemployee  | filter:$select.search">
                        {{list.first_name + " " + list.last_name + " (" + list.designation + ")"}} 
                    </ui-select-choices>
                </ui-select>
                <div ng-show="sbtBtn" ng-messages="bulkForm.employee_id.$error" class="help-block errMsg">
                    <div style="sp-err" ng-message="required">Please Select Employee</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="margin-top:22px;">
            <button type="submit" name="sbtbtn" value="Share" id="presalesbtn" class="btn btn-primary">Share</button>
        </div>   
    </div>
</form>