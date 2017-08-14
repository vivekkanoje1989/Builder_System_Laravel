<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <form name="blockStageFilter" role="form" ng-submit="filterDetails(searchDetails)">

                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Block Stage <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="searchDetails.block_stage_name" name="block_stage_name" class="form-control" required>

                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12" >
                                    <div class="form-group">
                                        <span class="input-icon icon-right" >
                                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
