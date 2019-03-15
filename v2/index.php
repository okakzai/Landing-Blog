<?php 
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');

require_once("php/koneksi.php");

function excerpt($title, $cutOffLength) {
    $charAtPosition = "";
    $titleLength = strlen($title);
    do {
        $cutOffLength++;
        $charAtPosition = substr($title, $cutOffLength, 1);
    } while ($cutOffLength < $titleLength && $charAtPosition != " ");
    return substr($title, 0, $cutOffLength) . '...';
}

$sql = "SELECT * FROM landblog_sosmed";
$stmt = $db->prepare($sql);
$stmt->execute();
$sosmed = $stmt->fetchAll();

$sql = "SELECT * FROM landblog_perusahaan";
$stmt = $db->prepare($sql);
$stmt->execute();
$usaha = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM landblog_produk";
$stmt = $db->prepare($sql);
$stmt->execute();
$produk= $stmt->fetchAll();

$sql = "SELECT * FROM landblog_blog";
$stmt = $db->prepare($sql);
$stmt->execute();
$blog= $stmt->fetchAll();

$sql = "SELECT * FROM landblog_slider";
$stmt = $db->prepare($sql);
$stmt->execute();
$slider= $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
    <head>
		<!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Landblog - Landing Page + Blog Berbasis PHP Native</title>
		<link rel="icon" href="admin/img/profil/<?php echo $usaha["favicon"];?>" sizes="32x32">
        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<!--
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        -->
		<link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/media-queries.css">

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
		<style>
		/*
		Removes white gap between slides - chagnge to base color of slide images
		*/
		.carousel {
			background:#007aeb;
		}
		/*
		Forces image to be 100% width and not max width of 100%
		*/
		.carousel-item .img-fluid {
			width:100%;
		}
		/* 
		anchors are inline so you need ot make them block to go full width
		*/
		.carousel-item a {
			display: block;
			width:100%;
		}
		</style>
    </head>

    <body>

		<!-- Top menu -->
		<nav class="navbar navbar-dark fixed-top navbar-expand-md navbar-no-bg">
			<div class="container">
				<a class="navbar-brand" href="./" style="color:#3bbfff;">
					<img src="admin/img/profil/<?php echo $usaha["logo"];?>" height="32" />
				</a>
			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			        <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="collapse navbar-collapse" id="navbarNav">
			        <ul class="navbar-nav ml-auto">
			            <li class="nav-item">
			                <a class="nav-link scroll-link" href="#portfolio">Produk</a>
			            </li>
			            <li class="nav-item">
			                <a class="nav-link scroll-link" href="#rating">Rating</a>
			            </li>
						<li class="nav-item">
			                <a class="nav-link scroll-link" href="#blog">Blog</a>
			            </li>
						<li class="nav-item">
			                <a class="nav-link scroll-link" href="#contact">Kontak</a>
			            </li>
						<li class="nav-item">
			                <a class="nav-link" href="./admin">Login</a>
			            </li>
			        </ul>
			    </div>
		    </div>
		</nav>
		
		<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="6000">
			<ol class="carousel-indicators">
				<?php
					$no=0;
					foreach($slider as $row) {
				?>
					<li data-target="#carousel" data-slide-to="<?php echo $no;?>" class="<?php if($no==0) echo 'active'?>"></li>
				<?php 
					$no++;
					} 
				?>
			</ol>
			<div class="carousel-inner" role="listbox">
				<!-- /.carousel-item -->
				<?php 
					$no=0;
					foreach($slider as $row) {
					$no++
				?>
				<div class="carousel-item <?php if($no==1) echo 'active'?>">
					<a href="<?php echo $row["link"];?>">
						<picture>
							<source srcset="<?php echo 'admin/slider/img/'.$row["gambar"];?>" media="(min-width: 1400px)">
							<source srcset="<?php echo 'admin/slider/img/'.$row["gambar"];?>" media="(min-width: 769px)">
							<source srcset="<?php echo 'admin/slider/img/'.$row["gambar"];?>" media="(min-width: 577px)">
							<img srcset="<?php echo 'admin/slider/img/'.$row["gambar"];?>" alt="<?php echo $row["judul"];?>" class="d-block img-fluid">
						</picture>

						<div class="carousel-caption justify-content-center align-items-center">
							<div>
								<h2><?php echo $row["judul"];?></h2>
								<p><?php echo $row["keterangan"];?></p>
								<span class="btn btn-sm btn-outline-secondary"><?php echo $row["tombol"];?></span>
							</div>
						</div>
					</a>
				</div>
				<?php } ?>
				<!-- /.carousel-item -->
			</div>
			<!-- /.carousel-inner -->
			<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		<!-- /.carousel -->

        <!-- Top content -->
		<!--
        <div class="top-content">
            <div class="container">
            	
                <div class="row">
                    <div class="col-md-8 offset-md-2 text">
                        <h1 class="wow fadeInLeftBig"><?php echo $usaha["judul_banner"];?></h1>
                        <div class="description wow fadeInLeftBig">
                        	<?php echo $usaha["deskripsi_banner"];?>
                        </div>
                        <div class="top-big-link wow fadeInUp">
                        	<a class="btn btn-success btn-link-1 scroll-link" href="#portfolio"><?php echo $usaha["tombol_banner"];?></a>
                        </div>
                    </div>
                </div>
               
		
            </div>            
        </div>
         -->
        <!-- Services -->
		<!--
        <div class="services-container section-container">
	        <div class="container">
	            <div class="row">
	                <div class="col services section-description wow fadeIn">
	                    <h2>Our Services</h2>
	                    <div class="divider-1 wow fadeInUp"><span></span></div>
	                </div>
	            </div>
	            <div class="row">
                	<div class="col-md-4 services-box wow fadeInUp">
                		<div class="row">
                			<div class="col-md-4">
			                	<div class="services-box-icon">
			                		<i class="fa fa-magic"></i>
			                	</div>
		                	</div>
	                		<div class="col-md-8">
	                    		<h3>Web Design</h3>
	                    		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
	                    	</div>
	                    </div>
                    </div>
                    <div class="col-md-4 services-box wow fadeInDown">
	                	<div class="row">
                			<div class="col-md-4">
			                	<div class="services-box-icon">
			                		<i class="fa fa-cog"></i>
			                	</div>
		                	</div>
	                		<div class="col-md-8">
	                    		<h3>UI / UX</h3>
	                    		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
	                    	</div>
	                    </div>
                    </div>
                    <div class="col-md-4 services-box wow fadeInUp">
	                	<div class="row">
                			<div class="col-md-4">
			                	<div class="services-box-icon">
			                		<i class="fa fa-google"></i>
			                	</div>
		                	</div>
	                		<div class="col-md-8">
	                    		<h3>Marketing</h3>
	                    		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
	                    	</div>
	                    </div>
                    </div>
	            </div>
	        </div>
        </div>
		-->
        <!-- About us -->
		<!--
        <div class="about-us-container section-container section-container-gray-bg">
	        <div class="container">
	            <div class="row">
	            	<div class="col-12 col-lg-7 about-us-box wow fadeInLeft">
	                    <div class="about-us-box-text">
	                    	<h3>About Us</h3>
	                    	<p class="medium-paragraph">
	                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
	                    		sed do eiusmod tempor incididunt ut labore et. Ut wisi enim ad minim veniam, quis nostrud.
	                    	</p>
	                    	<p>
	                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
	                    		Ut wisi enim ad minim veniam, quis nostrud. 
	                    		Exerci tation ullamcorper suscipit <a href="#">lobortis nisl</a> ut aliquip ex ea commodo consequat. 
	                    		Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl. 
	                    	</p>
	                    	<p>
	                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
	                    		Ut wisi enim ad minim veniam, quis nostrud.
	                    	</p>
	                    </div>
	                </div>
	                <div class="col-12 col-lg-5 about-us-box wow fadeInUp">
	                	<div class="about-us-box-img">
	                    	<img src="assets/img/about/1.jpg" alt="about" data-at2x="assets/img/about/1.jpg">
	                    </div>
	                </div>
	            </div>
	        </div>
        </div>
		-->
		<!-- More services -->
		<!--
        <div class="more-services-container section-container">
	        <div class="container">
	        	
	            <div class="row">
	                <div class="col more-services section-description wow fadeIn">
	                    <h2>More Services</h2>
	                    <div class="divider-1 wow fadeInUp"><span></span></div>
	                </div>
	            </div>
	            
	            <div class="row">
	                <div class="col-md-6 more-services-box wow fadeInLeft">
	                	<div class="row">
	                		<div class="col-md-3">
	                			<div class="more-services-box-icon">
	                				<i class="fa fa-twitter"></i>
	                			</div>
	                		</div>
	                		<div class="col-md-9">
	                			<h3>Ut wisi enim ad minim</h3>
		                    	<p>
		                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
		                    		Ut wisi enim ad minim veniam, quis nostrud.
		                    	</p>
	                		</div>
	                	</div>
	                </div>
	                <div class="col-md-6 more-services-box wow fadeInLeft">
	                	<div class="row">
	                		<div class="col-md-3">
	                			<div class="more-services-box-icon">
	                				<i class="fa fa-pencil-alt"></i>
	                			</div>
	                		</div>
	                		<div class="col-md-9">
	                			<h3>Sed do eiusmod tempor</h3>
		                    	<p>
		                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
		                    		Ut wisi enim ad minim veniam, quis nostrud.
		                    	</p>
	                		</div>
	                	</div>
	                </div>
	            </div>
	            
	            <div class="row">
	                <div class="col-md-6 more-services-box wow fadeInLeft">
	                	<div class="row">
	                		<div class="col-md-3">
	                			<div class="more-services-box-icon">
	                				<i class="fa fa-cloud"></i>
	                			</div>
	                		</div>
	                		<div class="col-md-9">
	                			<h3>Quis nostrud exerci tat</h3>
		                    	<p>
		                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
		                    		Ut wisi enim ad minim veniam, quis nostrud.
		                    	</p>
	                		</div>
	                	</div>
	                </div>
	                <div class="col-md-6 more-services-box wow fadeInLeft">
	                	<div class="row">
	                		<div class="col-md-3">
	                			<div class="more-services-box-icon">
	                				<i class="fa fa-pinterest"></i>
	                			</div>
	                		</div>
	                		<div class="col-md-9">
	                			<h3>Minim veniam quis nostrud</h3>
		                    	<p>
		                    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
		                    		Ut wisi enim ad minim veniam, quis nostrud.
		                    	</p>
	                		</div>
	                	</div>
	                </div>
	            </div>

	        </div>
        </div>
		-->

		<!-- Call to action -->
		<div class="section-container section-container-gray-bg" style="margin-bottom:0;padding-bottom:50px;">
	        <div class="container">
	            <div class="row">			
	                <div class="col call-to-action section-description wow fadeInLeftBig">
						<p align="center">
							<?php echo $usaha["adsense"];?>
						</p>					 
					</div>
	            </div>	         
	        </div>
        </div>
        <!-- Portfolio -->
        <div class="portfolio-container section-container">
	        <div class="container">
	            <div class="row">
	                <div class="col portfolio section-description wow fadeIn">
	                    <h2>Produk Kami</h2>
	                    <div class="divider-1 wow fadeInUp"><span></span></div>
	                    <!--<p>We've completed 537 projects since we started back in 2010. Check them out!</p>-->
	                </div>
	            </div>
	            <div class="row">
					<?php foreach($produk as $row) {?>
                	<div class="col-md-4 portfolio-box wow fadeInUp">
	                	<div class="portfolio-box-image">
	                		<img src="admin/produk/img/<?php echo $row["gambar"];?>"/>
	                	</div>
                		<h3><a href="<?php echo $row["link"];?>"><?php echo $row["nama"];?></a> <i class="fa fa-angle-right"></i></h3>
                		<?php echo excerpt($row["keterangan"],150);?>
                    </div>
					<?php } ?>
	            </div>
				<!--
	            <div class="row">
	            	<div class="col section-bottom-button wow fadeInUp">
                        <a class="btn btn-primary btn-link-3" href="./katalog">Lihat produk lainnya</a>
	            	</div>
	            </div>
				-->
	        </div>
        </div>
		
		<div class="rating-container section-container section-container-gray-bg" style="margin-bottom:0;padding-bottom:50px;">
	        <div class="container">
	            <div class="row">			
	                <div class="col call-to-action section-description wow fadeInLeftBig">
						<h2>Rating Pengunjung</h2>
	                    <div class="divider-1 wow fadeInUp"><span></span></div>
						<p align="center">
							<?php echo $usaha["adsense"];?>
						</p>					 
					</div>
	            </div>	         
	        </div>
        </div>
        
        <!-- Testimonials -->
		<!--
        <div class="testimonials-container section-container section-container-image-bg">
        	<div class="container">
        		<div class="row">
        			<div class="col testimonials section-description wow fadeIn"></div>
        		</div>
        		<div class="row">
        			<div class="col-md-10 offset-md-1 testimonial-list wow fadeInUp">
        				
        				<div class="tab-content" id="myTabContent">
        					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        						<div class="testimonial-image">
                					<img src="assets/img/testimonials/1.jpg" alt="testimonial-1" data-at2x="assets/img/testimonials/1.jpg">
                				</div>
                				<div class="testimonial-text">
	                                <p>
	                                	"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
	                                	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
	                                	Lorem ipsum dolor sit amet."<br>
	                                	<a href="#">Lorem Ipsum, dolor.co.uk</a>
	                                </p>
                                </div>
        					</div>
        					<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        						<div class="testimonial-image">
                					<img src="assets/img/testimonials/2.jpg" alt="testimonial-2" data-at2x="assets/img/testimonials/2.jpg">
                				</div>
                				<div class="testimonial-text">
	                                <p>
	                                	"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip 
	                                	ex ea commodo consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit 
	                                	lobortis nisl ut aliquip."<br>
	                                	<a href="#">Minim Veniam, nostrud.com</a>
	                                </p>
                                </div>
        					</div>
        					<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
        						<div class="testimonial-image">
                					<img src="assets/img/testimonials/3.jpg" alt="testimonial-3" data-at2x="assets/img/testimonials/3.jpg">
                				</div>
                				<div class="testimonial-text">
	                                <p>
	                                	"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
	                                	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et. 
	                                	Lorem ipsum dolor sit amet."<br>
	                                	<a href="#">Lorem Ipsum, dolor.co.uk</a>
	                                </p>
                                </div>
							</div>
        					<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
        						<div class="testimonial-image">
                					<img src="assets/img/testimonials/4.jpg" alt="" data-at2x="assets/img/testimonials/4.jpg">
                				</div>
                				<div class="testimonial-text">
	                                <p>
	                                	"Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip 
	                                	ex ea commodo consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit 
	                                	lobortis nisl ut aliquip."<br>
	                                	<a href="#">Minim Veniam, nostrud.com</a>
	                                </p>
                                </div>
        					</div>
        				</div>
        				
        				<ul class="nav nav-tabs" id="myTab" role="tablist">
        					<li class="nav-item">
        						<a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"></a>
        					</li>
        					<li class="nav-item">
        						<a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"></a>
        					</li>
        					<li class="nav-item">
        						<a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"></a>
        					</li>
        					<li class="nav-item">
        						<a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"></a>
        					</li>
        				</ul>
        				
        			</div>
        		</div>
        	</div>
        </div>
        -->        
        <!-- Blog -->
        <div class="blog-container section-container">
	        <div class="container">
	        	
	            <div class="row">
	                <div class="col blog section-description wow fadeIn">
	                    <h2>Blog Kami</h2>
	                    <div class="divider-1 wow fadeInUp"><span></span></div>
	                </div>
	            </div>
	            
	            <div class="row">
					<?php foreach($blog as $row) {?>
	                <div class="col-md-6 blog-box wow fadeInLeft">
	                	<div class="row">
	                		<div class="col-md-3">
	                			<div class="blog-box-image">
	                				<img src="admin/blog/img/<?php echo $row["gambar"];?>"/>
	                			</div>
	                		</div>
	                		<div class="col-md-9">
	                			<h3><a href="<?php echo $row["link"];?>"><?php echo $row["judul"];?></a> <i class="fa fa-angle-right"></i></h3>
	                			<div class="blog-box-date"><i class="far fa-calendar"></i> <?php echo $row["waktu"];?></div>
		                    	<?php echo excerpt($row["deskripsi"],150);?>
	                		</div>
	                	</div>
	                </div>
					<?php } ?>
	            </div>
	            <!--
	            <div class="row">
	            	<div class="col section-bottom-button wow fadeInUp">
                        <a class="btn btn-primary btn-link-3" href="./blog">Lihat tulisan lainnya</a>
	            	</div>
	            </div>
				-->
	        </div>
        </div>

		<!-- Contact Us -->
	
		<div class="contact-container section-container section-container-gray-bg">
	        <div class="container">
	            <div class="row">
	            	<div class="col-12 col-lg-7 about-us-box wow fadeInLeft">
	                    <div class="about-us-box-text">
							<div class="logo">
								<h6><?php echo $usaha["nama"];?></h6>
							</div>
							<div class="contact-details">
								<p>
									<?php echo $usaha["alamat"];?>
									<br />
									Telepon: <?php echo $usaha["phone"];?>
									<br />
									Email: <a href="mailto:<?php echo $usaha["email"];?>"><?php echo $usaha["email"];?></a>
									<hr />
									<?php foreach($sosmed as $row) {?>	
									<a href="<?php echo $row["facebook"];?>" style="border-bottom:none;"><i class="fa fa-facebook-f"></i></a>
									<a href="<?php echo $row["dribble"];?>" style="border-bottom:none;"><i class="fa fa-dribbble"></i></a>
									<a href="<?php echo $row["twitter"];?>" style="border-bottom:none;"><i class="fa fa-twitter"></i></a>
									<a href="<?php echo $row["instagram"];?>" style="border-bottom:none;"><i class="fa fa-instagram"></i></a>
									<a href="<?php echo $row["pinterest"];?>" style="border-bottom:none;"><i class="fa fa-pinterest"></i></a>
									<?php } ?>
								</p>
							</div>
	                    </div>
	                </div>
	                <div class="col-12 col-lg-5 about-us-box wow fadeInUp">
	                	<div class="about-us-box-img">
	                    	<img src="admin/img/profil/<?php echo $usaha["logo"];?>" />
	                    </div>
	                </div>
	            </div>
	        </div>
        </div>
	
        <!-- Footer -->
        <footer>
	        <div class="container">
	        	<div class="row">
                    <div class="col-md-12">
                    	<p align="center">
							&copy; <?php echo $usaha["nama"];?>
						</p>
                    </div>
                    <!--
                    <div class="col-md-6 footer-right">
					<?php foreach($sosmed as $row) {?>	
                    	<a href="<?php echo $row["facebook"];?>"><i class="fa fa-facebook-f"></i></a>
						<a href="<?php echo $row["dribble"];?>"><i class="fa fa-dribbble"></i></a>
						<a href="<?php echo $row["twitter"];?>"><i class="fa fa-twitter"></i></a>
						<a href="<?php echo $row["instagram"];?>"><i class="fa fa-instagram"></i></a>
						<a href="<?php echo $row["pinterest"];?>"><i class="fa fa-pinterest"></i></a>
					<?php } ?>
                    </div>
					-->
                </div>
                <div class="row">
                	<div class="col footer-bottom">
		           		<a class="scroll-link" href="#top-content"><i class="fa fa-chevron-up"></i></a>
		           	</div>
                </div>
	        </div>
        </footer>


        <!-- Javascript -->
        <!--
		<script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/jquery-migrate-3.0.0.min.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        -->
		<script src="js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/js/wow.min.js"></script>
        <script src="assets/js/scripts.js"></script>
    </body>

</html>