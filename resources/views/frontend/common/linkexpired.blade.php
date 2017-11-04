<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app" ng-controller="AppCtrl">
    <meta name="csrf-token" content="[[ csrf_token() ]]">
        <base href="/">
            
            <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="/frontend/angular.min.js"></script>
                    <script src="/frontend/angular-route.min.js"></script>
                    <script src="/frontend/angular-animate.min.js"></script>
                    <script src="/backend/app/ng-file-upload.js"></script>
                    <script src="/frontend/route.js"></script> 
                    <script src="/backend/app/controllers/datepicker.js"></script> 
                    <script src="/backend/lib/angular/angular-ui-bootstrap/ui-bootstrap.js"></script>
                    <link rel="stylesheet" href="/frontend/common/assets/bootstrap.min.css">
                        <link rel="stylesheet" href="/frontend/common/assets/jquery-ui.css">
                            <link rel="stylesheet" href="/frontend/common/assets/intlTelInput.css">

                                <style>
                                    .regbg{
                                        background-color: #f5f5f5;
                                    }
                                    .well{
                                        background-color: #fff;
                                    }
                                    .brand-logo{
                                        max-height:65px;
                                        width:auto;
                                        max-width:150px;
                                    }
                                    .logo{

                                        max-height:65px;
                                        width:auto;
                                        max-width:150px;
                                    }
                                    .well {
                                        min-height: 20px;
                                        padding: 15px;
                                        margin-bottom: 10px;
                                    }
                                    h1.form-title {
                                        text-transform: uppercase;
                                        font-size: 25px;	

                                    }
                                    .mar50{
                                        margin-top: 50px;
                                    }

                                    @media screen and (max-width: 768px) {
                                        .iti-mobile .intl-tel-input.iti-container{
                                            left: 4%;
                                            width: 92%;
                                        }
                                    }
                                    .error_msg
                                    {
                                        color:red;
                                    }
                                </style>		
                                </head>
                                <body class="regbg">
                                    
                                    <div class="container">
                                        <div class="well col-md-12 col-sm-12 col-xs-12 mar50" align="center">
                                            <h1>The link you have clicked has expired!</h1>                                            
                                        </div>	
                                    </div>
                                </body>
                                </html>
