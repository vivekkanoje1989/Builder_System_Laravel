<style>
    .tabsets ul li{
        width:50%;
    }
</style>
<div class="row" ng-controller="smsController">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h5 class="row-title"><i class="fa fa-arrow-circle-o-right themeprimary"></i>SMS Reports</h5>
        <div class="col-lg-12 col-sm-6 col-xs-12">
                <tabset class="tabsets">
                    <tab heading="Company Information">
                        <div data-ng-include=" '/manage-companies/companyInfo' "></div>
                    </tab>
                    <tab heading="Documents" class="uploadsTab">
                        <div data-ng-include=" '/manage-companies/companyDocuments' "></div>
                    </tab>
                    <tab heading="Stationary" class="uploadsTab">
                        <div data-ng-include=" '/manage-companies/companyStationary' "></div>
                    </tab>
                </tabset>
        </div>
    </div>
</div>



