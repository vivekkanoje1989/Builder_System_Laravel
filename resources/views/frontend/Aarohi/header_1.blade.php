<?php $url =  Yii::app()->theme->baseUrl;
$action = Yii::app()->controller->action->id;


if( $action=='projects' || $action=='projectdetails' )
	$project='active';
else if( $action=='contact' )
	$contact='active';
else if( $action=='about')
	$about='active';
else if( $action=='careers')
	$careers='active';
else
	$index='active';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
       
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->pageTitle;?></title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/font-awesome/css/font-awesome.min.css">
			<!-- bxSlider CSS file -->
		<link rel="stylesheet" href="<?php echo $url; ?>/assets/css/jquery.bxslider.css"/>
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/animate.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/flexslider/flexslider.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/media-queries.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="icon" href="<?php echo $this->image_path."builder_uploads/".$this->builderInfo['favicon'];?>" type="image/x-icon" />

    </head>

    <body>
        
        <!-- Top menu -->
		<nav class="navbar" role="navigation">
			<div class="container head">
				<div class="navbar-header">
					<div class="navbar-brand">
					<a href="<?php echo Yii::app()->createUrl('//site/index'); ?>">
                                            <img src="<?php echo COMPANY_LOGO; ?>" class="img-responsive" alt="<?php echo COMPANY_NAME; ?>" style="margin-top:0px;"/>
                                        </a>
					</div>
					<div class="brand-name">
                                            <?php 
                                                                            if(SHOW_ON_HEADER !=0)
																			{		
                                                                                    echo substr( COMPANY_NAME ,0,35 ); 
                                             ?> 
                                                   
                                                                                                        <br><span><?php echo substr( PUNCH_LINE, 0, 60 ); ?></span>
																			<?php } ?>
                                        </div>
						
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="top-navbar-1">
					<ul class="nav navbar-nav navbar-right">
					<!--	<li class="dropdown active">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000">
								Home <span class="caret"></span>
							</a>
							<ul class="dropdown-menu dropdown-menu-left" role="menu">
								<li><a href="index.html">Home</a></li>
								<li class="active"><a href="index-2.html">Home 2</a></li>
							</ul>
						</li>-->
						<li class="<?php echo $index;?>">
							<a href="<?php echo Yii::app()->createUrl('//site/index'); ?>">Home</a>
						</li>
						<li class="<?php echo $about;?>">
							<a href="<?php echo Yii::app()->createUrl('//site/about'); ?>">About</a>
						</li>
						<li class="<?php echo $project;?>">
							<a href="<?php echo Yii::app()->createUrl('//site/projects'); ?>">Projects</a>
						</li>
						<?php $career = Pages::model()->findByPk(11);
						if($career->status == 1)
						{ 
						?>
						<li class="<?php echo $careers;?>">
						<a href="<?php echo Yii::app()->createUrl('//site/careers'); ?>">Careers</a>
						</li>
						<?php }?>
                                                <li class="<?php echo $project;?>">
						<a href="<?php echo Yii::app()->createUrl('//site/projects'); ?>">Newsupdate</a>
						</li>
                                                <li class="<?php echo $project;?>">
						<a href="<?php echo Yii::app()->createUrl('//site/projects'); ?>">Event</a>
						</li>
                                                <li class="<?php echo $project;?>">
						<a href="<?php echo Yii::app()->createUrl('//site/projects'); ?>">Press Release</a>
						</li>
                                                <li class="<?php echo $contact;?>">
						<a href="<?php echo Yii::app()->createUrl('//site/contact'); ?>">Contact</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>