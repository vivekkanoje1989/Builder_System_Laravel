<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal" ng-click="closeModal()">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <form name="calllogsFilter" role="form" ng-submit="filterDetails(searchDetails)">

                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Blog title</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="searchDetails.blog_title" name="blog_title" class="form-control">
                                        </span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Seo Url</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="searchDetails.blog_seo_url" name="blog_seo_url" class="form-control">
                                        </span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Meta Description</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="searchDetails.meta_description" name="meta_description" class="form-control">
                                        </span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Meta Keywords</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="searchDetails.meta_keywords" name="meta_keywords" class="form-control">
                                        </span>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Blog Status</label>
                                        <span class="input-icon icon-right">
                                            <select class="form-control" ng-model="searchDetails.blog_status" name="blog_status">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
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
