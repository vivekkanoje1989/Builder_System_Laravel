<style>
    .app-btn {
        /*position: fixed;*/
        font-size: 12px;
        height: 54px;
        background-color: #262626;
        z-index: 100;
        padding-top:10px;
        /*line-height: 54px;*/
        margin-bottom: 1px;
        width: 100%;
        top: 0;
    }
    .left-div {
        float: left;
        color: rgb(255, 255, 255);
        font-size: 20px;
        text-transform: uppercase;
        margin-left: 20px;
    }
    .right-div {
        float: right;
        margin-right: 20px;
    }
    .close-app{
        margin-left: 5px;
    }

</style>
<div class="row" ng-controller="themesController" ng-init="themeName()">
    <div class="app-btn">
        <div class="left-div">{{themeName}}</div>
        <div class="right-div">     
            <button class="btn btn-lg btn-success" id="sbtbtn1" ng-click="applyTheme([[ $id ]])">Apply Now</button>
            <span>
                <button  class="btn btn-lg btn-danger" ng-click="closeWindow()">Close<i class="fa fa-times close-app" aria-hidden="true"></i></button>  
            </span>
        </div>
    </div>
    <iframe width="100%" height="600px" src="#/about/[[ $id ]]"></iframe>
</div>