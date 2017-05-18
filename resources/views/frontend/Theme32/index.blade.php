@extends('layouts/frontend/Theme32/main')
@section('content')
<main class="main-content" ng-controller="webAppController" ng-init="getProjects();">
    <div class="slideshow-main owl-carousel" data-slideshow-options='{"autoPlay":5000,"stopOnHover":true,"transitionStyle":"fade"}'>
	<div class="slideshow-main-item">
		<div class="container">
			<div class="slideshow-main-item-inner">
				<h1 class="animated bounceInUp">Welcome <span>to</span> BMS BUILDER</h1>
				<p class="animated bounceInUp delay-100">ADDING VALUE IN EVERY HOME, OFFICE AND INFRASTRUCTURE WE BUILD</p>
			</div>
		</div>
	</div>
	<div class="slideshow-main-item">
		<div class="container">
			<div class="slideshow-main-item-inner">
				<h1 class="animated bounceInUp">BUILDING LASTING RELATIONS </h1>
				<p class="animated bounceInUp delay-100">  FOLLOWING PERSONAL <span>&amp;</span> ENVIRONMENTAL SAFETY NORMS</p>
				<div class="animated bounceInUp delay-200">
					<a href="#" class="btn">Read More</a> <!--a href="#" class="btn btn-alt">Read More</a-->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<header class="heading">
		<h2>Current Projects</h2>
		<a href="projects.html" class="btn-more" title="VIEW ALL PROJECTS">View all works</a>
	</header>{

	<div class="thumbs offset-bottom">
		<div class="thumbs-item" ng-repeat="current in current">
			<a href="project_details.html">
				<header class="thumbs-item-heading">
					<h3>Project Name</h3>
					<p>project description description project descriptionproject description </p>
				</header>
				<img src="/frontend/Theme32/img/pro1.jpg" alt="">
			</a>
		</div>
		<div class="thumbs-item ">
			<a href="project_details.html">
				<header class="thumbs-item-heading">
					<h3>Project</h3>
					<p>project description</p>
				</header>
				<img src="/frontend/Theme32/img/pro3.jpg" width="586" height="280" alt="">
			</a>
		</div>
		<div class="thumbs-item ">
			<a href="project_details.html">
				<header class="thumbs-item-heading">
					<h3>Project Name</h3>
					<p>project description description project descriptionproject description </p>
				</header>
				<img src="/frontend/Theme32/img/pro1.jpg" alt="">
			</a>
		</div>
		<div class="thumbs-item ">
			<a href="project_details.html">
				<header class="thumbs-item-heading">
					<h3>Project</h3>
					<p>project description</p>
				</header>
				<img src="/frontend/Theme32/img/pro3.jpg" width="586" height="280" alt="">
			</a>
		</div>
		<div class="thumbs-sizer"></div>
	</div>

	<header class="heading">
		<h2>Testimonials</h2>
	</header>

	<div class="testimonials owl-carousel owl-separated offset-bottom" data-slideshow-options='{"items":3,"itemsDesktop":false,"itemsDesktopSmall":false,"itemsTablet":[768,1],"singleItem":false,"pagination":false}'>
		<div class="testimonials-item">
			<blockquote>
				<p>Lorem ip vix congue dndi veniam rationibus nec, assentior honestatis vel ea. Sed fugit dicta ad.</p>
			</blockquote>
			<div class="person">
				<div class="person-photo">
					<img src="/frontend/Theme32/img/testimonial1.jpg" width="110" height="110" alt="">
				</div>
				<div class="person-info">
					Ramdas
					<small>Raut</small>
				</div>
			</div>
		</div>
		<div class="testimonials-item">
			<blockquote>
				<p>Lorem ipsumeant nam, te falli scripta adversarium pro. Ut per. ue dndi venia ue dndi venia</p>
			</blockquote>
			<div class="person">
				<div class="person-photo">
					<img src="/frontend/Theme32/img/testimonial2.jpg" width="110" height="110" alt="">
				</div>
				<div class="person-info">
					Ramdas
					<small>Raut</small>
				</div>
			</div>
		</div>
		<div class="testimonials-item">
			<blockquote>
				<p>Lorem ipsum dom ad nec. In qui elaboraret reprehendunt, mei ex meis homero, erat iusto vel te.</p>
			</blockquote>
			<div class="person">
				<div class="person-photo">
					<img src="/frontend/Theme32/img/testimonial3.png" width="110" height="110" alt="">
				</div>
				<div class="person-info">
					Ramdas
					<small>Raut</small>
				</div>
			</div>
		</div>
		<div class="testimonials-item">
			<blockquote>
				<p>Lorem ip vix congue dndi veniam rationibus nec, assentiorhtml honestatis vel ea. Sed fugit dicta ad.</p>
			</blockquote>
			<div class="person">
				<div class="person-photo">
					<img src="/frontend/Theme32/img/testimonial1.jpg" width="110" height="110" alt="">
				</div>
				<div class="person-info">
					Ramdas
					<small>Raut</small>
				</div>
			</div>
		</div>
	</div>
	
	<header class="heading page-heading" id="apply">
		<h2>Write Us Your Views</h2>
	</header>

	<div class="row">
		<div class="col span_12"  style="padding:4px">
			<form class="form-contact" method="post" >
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<label class="form-item-label">Name</label>
					<input type="text" name="name" required>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<label class="form-item-label">E-mail</label>
					<input type="email" name="email" required>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<label class="form-item-label">Phone</label>
					<input type="tel" name="phone" required>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<label class="form-item-label">Select Position</label>
					<select required class="shape">
						<option value="" selected disabled>Select Position</option>
						<option>Web Designer</option>
						<option>Php Developer</option>
						<option>Sales Manager</option>
						<option>Support Engineer</option>
					</select>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<label class="form-item-label">Upload CV</label>
					<input type="file" required></textarea>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<center>
						<img src="img/captcha_code_file.jpg" class="img-responsive center-block">	
						<br />
						<label class="form-item-label"><a href="#">Click To Refresh </a></label>
					</center>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-item">
					<label class="form-item-label">Captcha</label>
					<input type="text" name="captcha" required>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-item">
					<center>
						<button type="submit" class="btn">Send</button>
					</center>
				</div>
			</form>
		</div>
	</div>
</div>
</main>
@endsection()    
