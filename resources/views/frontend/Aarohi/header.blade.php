<?php
$url = Yii::app()->theme->baseUrl;
?>
<style>
    .navbar {
        margin-top: -20px;
    }
    </style>
<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->pageTitle; ?></title>
        <?php echo $this->META_KEYWORDS; ?>
        <meta name="description" content="<?php echo $this->META_DESCRIPTION; ?>"/>
        <link href="<?php echo $this->CANONICAL_TAG; ?>" rel="canonical"/>        
        <link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo FAVICON; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo FAVICON; ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo FAVICON; ?>">  
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/jquery.bxslider.css"/>
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/animate.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/flexslider/flexslider.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo $url; ?>/assets/css/media-queries.css">
        <link rel="icon" href="<?php echo $this->image_path . "builder_uploads/" . $this->builderInfo['favicon']; ?>" type="image/x-icon" />
    </head>
    <body>
   <nav class="navbar" role="navigation">
            <div class="container head">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        <a href="<?php echo BASE_URL ?>/index.php">
                            <img src="<?php echo COMPANY_LOGO; ?>" class="img-responsive" alt="<?php echo COMPANY_NAME; ?>" style="margin-top:0px;"/>
                        </a>
                    </div>
                    <div class="brand-name">
                    <?php
                    if (SHOW_ON_HEADER != 0) {
                    echo substr(COMPANY_NAME, 0, 35);
                    ?> 
                   <br><span><?php echo substr(PUNCH_LINE, 0, 60); ?></span>
                    <?php } ?>
                    </div>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    </div>
                    <div class="collapse navbar-collapse" id="top-navbar-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                        $controller = Yii::app()->getController();
                        if ($controller->getAction()->getId() === 'page' ? true : false)
                        $view = $controller->getAction()->getRequestedView();
                        else
                        $view = $controller->getAction()->getId();
                        $action = Yii::app()->controller->action->id;
                        $criteria = new CDbCriteria;
                        $criteria->select = 'status,page_name';
                        $criteria->addInCondition('page_id', array(1, 10, 11, 8, 12, 9, 13, 28, 29));
                        $criteria->order = 'page_id ASC';
                        $pages_status = Pages::model()->findAll($criteria);
                        $about_status = $pages_status[0]->status;
                        $status_index = $pages_status[1]->status;
                        $status_contact = $pages_status[2]->status;
                        $status_Testimonial = $pages_status[3]->status;
                        $status_Careers = $pages_status[4]->status;
                        $status_projects = $pages_status[5]->status;
                        $status_news_room = $pages_status[6]->status;
                        $status_events = $pages_status[7]->status;
                        $status_press_relase = $pages_status[8]->status;
                        ?>
                        <?php if ($status_index == 1) { ?><li  <?php if ($view == 'index') echo 'class="active"';?>>  <a href="<?php echo BASE_URL ?>">Home</a> </li> <?php  } ?>
                        <?php if ($about_status == 1) { ?>  <li <?php if ($view == 'about') echo 'class="active"';?>><a href="<?php echo BASE_URL ?>/index.php/about">About</a> </li> <?php }  ?>
                        <?php if ($status_projects == 1) { ?>  <li <?php if ($view == 'projects' || $view == 'projectdetails') echo 'class="active"';?>>  <a href="<?php echo BASE_URL ?>/index.php/projects">Projects</a> </li><?php } ?>
                        <?php if ($status_Careers == 1) { ?>  <li <?php if ($view == 'careers') echo 'class="active"';?> ><a href="<?php echo BASE_URL ?>/index.php/careers">Careers</a></li>                    <?php } ?>
                        <?php if ($status_news_room == 1) { ?> <li <?php if (Yii::app()->controller->id == 'newsroom')  echo 'class="active"';?>> <a href="<?php echo BASE_URL; ?>/index.php/newsroom/newsupdates">Newsupdate</a> </li> <?php } ?>
                        <?php if ($status_events == 1) { ?> <li <?php if ($view == 'event') echo 'class="active"';?>><a href="<?php echo BASE_URL; ?>/event">Event</a> </li> <?php } ?>
                        <?php if ($status_press_relase == 1) { ?> <li  <?php if ($view == 'press_release') echo 'class="active"'  ?>><a href="<?php echo BASE_URL ?>/index.php/press_release">Press Release</a></li><?php } ?>
                        <?php if ($status_contact == 1) { ?> <li  <?php if ($view == 'contact') echo 'class="active"'  ?>> <a href="<?php echo BASE_URL ?>/index.php/contact">Contact</a> </li> <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>