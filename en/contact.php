<!doctype html>
<html class="no-js"="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
     <title> Contact | Qualiti7 </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

   <!-- CSS here -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/slick.css">
    <link rel="stylesheet" href="../assets/css/nice-select.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>
 
<!-- Header Start -->
<?php include '../_includes/header_en.php';?>
<!-- Header End -->


    <main onload="renderCountriesAndStore()">
        <!--? Hero Start -->
        <div class="slider-area ">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 text-center">
                                <h2>Contact Us</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   <!-- contact form -->
   <div class="container mt-5 p-4 mb-5 shadow">
    <div class="row mt-2">
      <div class="col-7">
        <h3 class="text-gold fw-bold mb-3" key="contact">Contact Us</h3>
        <form action="_includes/send_email.php" method="POST">
          <div class="row mb-3">
            <div class="col-lg-6">
              <label for="first-name" class="form-label my-2 required" key="contact-first-name">First Name</label>
              <input type="text" class="form-control" id="first-name" name="first-name" required>
            </div>
            <div class="col-lg-6">
              <label for="last-name" class="form-label my-2 required" key="contact-last-name">Last Name</label>
              <input type="text" class="form-control" id="last-name" name="last-name" required>
            </div>
            <div class="col-lg-6">
              <label for="email" class="form-label my-2 required" key="contact-email">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-lg-6">
              <label for="phone" class="form-label my-2 not-required" key="contact-phone">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="col-lg-4">
              <label for="country" class="form-label my-2 required" key="contact-country">Country</label>
              <select id="country" class="form-select" name="country" onchange="getState()" required>
                <option value="">Choose a country</option>
              </select>
            </div>
            <div class="col-lg-4">
              <label for="state" class="form-label my-2 not-required" key="contact-state">State</label>
              <select id="state" class="form-select" name="state" onchange="getCity()">
                <option value="">-</option>
              </select>
            </div>
            <div class="col-lg-4">
              <label for="city" class="form-label my-2 not-required" key="contact-city">City</label>
              <input list="city" class="form-control" id="city-choice" name="city-choice"/>
              <datalist id="city"  name="city">
                <option value="-"></option>
              </datalist>
            </div>
            <div class="col-lg-12">
              <label for="subject" class="form-label my-2 required" key="contact-subject">Subject</label>
              <select id="subject" class="form-select" name="subject" required>
                <option value="" selected disabled></option>
                <option value="Lorem ipsum">Lorem ipsum Option 1</option>
                <option value="Lorem ipsum">Lorem ipsum Option 2</option>
              </select>
            </div>
            <div class="col-lg-12">
              <label for="message" class="form-label my-2 required" key="contact-message">Your Message</label>
              <textarea class="form-control" id="message" rows="10" name="message" required></textarea>
            </div>
          </div>
          <button type="submit" name="submit" class="btn btn-gold text-light text-uppercase">Send Message</button>
        </form>
      </div>
      <div class="col-5 py-5 ps-4">
        <div class="h-50">
          <h4 class="text-gold" key="contact-info">Our Contact Information</h4>
          <h5 class="lang" key="contact-headquarters">Headquarters and Montreal office</h5>
          <p class="mb-md-0">1000 de la Gauchetière Ouest, suite 2400 Montréal, QC H3B 4W5</p>
          <p class="mb-md-0"><span class="text-decoration-underline" key="contact-our-phone"></span>  +1 514 448-2246</p>
          <p><span class="text-decoration-underline" key="contact-fax"></span> +1 514 448 5101</p>
        </div>
        <h4 class="text-gold" key="contact-why">Why contact us?</h4>
        <p class="lang" key="contact-why-text">You can contact us for more information about consulting, private training sessions or general inquiries about any of Qualiti7’s service</p>
      </div>
    </div>
  </div>
  
    </main>
    
<!-- Footer Start-->
<?php include '../_includes/footer_en.php';?>
<!-- Footer End -->




    <!-- Scroll Up -->
    <div id="back-top" >
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->

    <script src="../assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="../assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="../assets/js/wow.min.js"></script>
    <script src="../assets/js/animated.headline.js"></script>
    
    <!-- Nice-select, sticky -->
    <script src="../assets/js/jquery.nice-select.min.js"></script>
    <script src="../assets/js/jquery.sticky.js"></script>
    <script src="../assets/js/jquery.magnific-popup.js"></script>

    <!-- contact js -->
    <script src="../assets/js/contact.js"></script>
    <script src="../assets/js/jquery.form.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="../assets/js/mail-script.js"></script>
    <script src="../assets/js/jquery.ajaxchimp.min.js"></script>
    
    <!-- Jquery Plugins, main Jquery -->	
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
    <!-- countrycitystate api js -->
    <script src="../assets/js/countrystatecity.js"></script>

    </body>
</html>