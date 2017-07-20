<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <tabset class="tabs-left">
            <tab heading="Images">
                <div data-ng-include=" '/projects/uploads/images'"></div>
            </tab>
            <tab heading="Status">
                <div data-ng-include=" '/projects/uploads/status' "></div>
            </tab>
            <tab heading="Layout">
               <div data-ng-include=" '/projects/uploads/layouts' "></div>
            </tab>
            <tab heading="Map">
                <div data-ng-include=" '/projects/uploads/maps' "></div>
            </tab>
            <tab heading="Amenities">
                <div data-ng-include=" '/projects/uploads/amenities' "></div>
            </tab>
            <tab heading="Specification">
                <div data-ng-include=" '/projects/uploads/specification' "></div>
            </tab>
            <tab heading="Gallery">
                <div data-ng-include=" '/projects/uploads/gallery' "></div>
            </tab>
        </tabset>
        <div class="horizontal-space"></div>
    </div>
</div>
<style>
    .tab-content{
        box-shadow:none;
        overflow-x: hidden !important;
    }    
    .img-div2{
        margin-bottom: 10px;
    }
 </style>   