<style>
    .select2-container-multi .select2-choices {
        position: relative;
        min-height: 32px !important;
    }
    .ui-select-multiple input.ui-select-search {
        width: 100% !important;
        position: absolute;
    }
   
   .close {
      color:black;

    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
    }

</style>
<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <tabset justified="false">
                           
                            <tab heading="SMS Filters">
                                <form name="smsFilter" role="form" ng-submit="getDetailFilteredData(filterData, 1, [[ config('global.recordsPerPage')]])">
                                      <div class="row">
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for="">From Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filterData.fromDate" name="fromDate" id="fromDate" class="form-control" datepicker-popup='dd-MM-yyyy' is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                            <div class="form-group">
                                                <label for=""> To Date</label>
                                                <span class="input-icon icon-right">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="filterData.toDate"  name="toDate" id="toDate" class="form-control" datepicker-popup='dd-MM-yyyy' is-open="opened" max-date="dt" datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                    </div>  
                                  
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label for="">Mobile Number </label>
                                                <input type="text" ng-model="filterData.mobile_number" name="mobile_number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  maxlength="10">
                                            </div>
                                        </div>
                                        
                                    </div>
                                  
                                   
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary">Search</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>                                
                            </tab>
                        </tabset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
