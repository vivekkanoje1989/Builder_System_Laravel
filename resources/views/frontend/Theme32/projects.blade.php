@extends('layouts/frontend/Theme32/main')
@section('content')
<!-- END HEADER -->

<!-- BEGIN MAIN CONTAINER -->
<main class="main-content">

    <!-- start content -->
    <!-- start breadcrumbs.html-->
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><span>All Projects</span></li>
            </ul>
        </div>
    </div>

    <!-- end breadcrumbs.html-->

    <div class="container">

        <header class="heading page-heading">
            <h1>All Projects</h1>
        </header>

        <div class="filter thumbs-filter" id="current">
            <ul>
                <li class="active" data-group="all"><span>Current Project</span></li>
            </ul>
        </div>

        <div class="thumbs offset-bottom">
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project Name</h3>
                        <p>project description description project descriptionproject description </p>
                    </header>
                    <img src="img/pro1.jpg" alt="">
                </a>
            </div>
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project</h3>
                        <p>project description</p>
                    </header>
                    <img src="img/pro3.jpg" width="586" height="280" alt="">
                </a>
            </div>
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project Name</h3>
                        <p>project description description project descriptionproject description </p>
                    </header>
                    <img src="img/pro1.jpg" alt="">
                </a>
            </div>
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project</h3>
                        <p>project description</p>
                    </header>
                    <img src="img/pro3.jpg" width="586" height="280" alt="">
                </a>
            </div>
            <div class="thumbs-sizer"></div>
        </div>

        <div class="filter thumbs-filter" id="upcoming">
            <ul>
                <li class="active" data-group="all"><span>Upcoming Project</span></li>
            </ul>
        </div>

        <div class="thumbs offset-bottom">

            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project</h3>
                        <p>project description</p>
                    </header>
                    <img src="img/pro3.jpg" width="586" height="280" alt="">
                </a>
            </div>
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project Name</h3>
                        <p>project description description project descriptionproject description </p>
                    </header>
                    <img src="img/pro1.jpg" alt="">
                </a>
            </div>
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project</h3>
                        <p>project description</p>
                    </header>
                    <img src="img/pro3.jpg" width="586" height="280" alt="">
                </a>
            </div>
            <div class="thumbs-sizer"></div>
        </div>

        <div class="filter thumbs-filter" id="completed">
            <ul>
                <li class="active" data-group="all"><span>Completed Project</span></li>
            </ul>
        </div>

        <div class="thumbs offset-bottom">

            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project Name</h3>
                        <p>project description description project descriptionproject description </p>
                    </header>
                    <img src="img/pro1.jpg" alt="">
                </a>
            </div>
            <div class="thumbs-item ">
                <a href="project_details.html">
                    <header class="thumbs-item-heading">
                        <h3>Project</h3>
                        <p>project description</p>
                    </header>
                    <img src="img/pro3.jpg" width="586" height="280" alt="">
                </a>
            </div>
            <div class="thumbs-sizer"></div>
        </div>

    </div>


    <!-- end content -->

</main>
<!-- END MAIN CONTAINER -->
@endsection() 