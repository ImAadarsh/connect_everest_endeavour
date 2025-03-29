<!DOCTYPE html>
<html lang="zxx">

<head>

    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="HTML5 Template Hubfolio Multi-Purpose themeforest">
    <meta name="description" content="Hubfolio - Multi-Purpose HTML5 Template">
    <meta name="author" content="">

    <!-- Title  -->
    <title>Connect Everest</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Six+Caps&display=swap" rel="stylesheet">

    <!-- Plugins -->
    <link rel="stylesheet" href="../common/css/plugins.css">

    <!-- Core Style Css -->
    <link rel="stylesheet" href="../common/css/common_style.css">
    <link rel="stylesheet" href="assets/css/inner_pages.css">

</head>

<body>



    <!-- ==================== Start Loading ==================== -->

    <div class="loader-wrap">
        <svg viewBox="0 0 1000 1000" preserveAspectRatio="none">
            <path id="svg" d="M0,1005S175,995,500,995s500,5,500,5V0H0Z"></path>
        </svg>

        <div class="loader-wrap-heading">
            <div class="load-text">
                <span>L</span>
                <span>o</span>
                <span>a</span>
                <span>d</span>
                <span>i</span>
                <span>n</span>
                <span>g</span>
            </div>
        </div>
    </div>

    <!-- ==================== End Loading ==================== -->


    <div class="cursor"></div>


    <!-- ==================== Start progress-scroll-button ==================== -->

    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- ==================== End progress-scroll-button ==================== -->



    <!-- ==================== Start Navbar ==================== -->

    <?php include 'components/header.php'; ?>

    <div class="hamenu">
        <div class="close-menu cursor-pointer ti-close"></div>
        <div class="container-fluid rest d-flex">
            <div class="menu-links">
                <ul class="main-menu rest">
                    <li>
                        <div class="o-hidden">
                            <div class="link cursor-pointer dmenu"><span class="fill-text" data-text="Home">Home</span>
                                <i></i></div>
                        </div>
                        <div class="sub-menu">
                            <ul>
                                <li>
                                    <a href="../index.php" class="sub-link">Home</a>
                                </li>
                                <li>
                                    <a href="about.html" class="sub-link">About Us</a>
                                </li>
                                <li>
                                    <a href="services.html" class="sub-link">Our Services</a>
                                </li>
                                <li>
                                    <a href="contact.php" class="sub-link">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="o-hidden">
                            <div class="link cursor-pointer dmenu"><span class="fill-text" data-text="Services">Services</span>
                                <i></i></div>
                        </div>
                        <div class="sub-menu">
                            <ul>
                                <li>
                                    <a href="employer.php" class="sub-link">For Employers</a>
                                </li>
                                <li>
                                    <a href="employee.php" class="sub-link">For Employees</a>
                                </li>
                                <li>
                                    <a href="student.php" class="sub-link">For Students</a>
                                </li>
                                <li>
                                    <a href="faqs.html" class="sub-link">FAQs</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="o-hidden">
                            <div class="link cursor-pointer dmenu"><span class="fill-text" data-text="Resources">Resource</span>
                                <i></i></div>
                        </div>
                        <div class="sub-menu">
                            <ul>
                                <li>
                                    <a href="faqs.html" class="sub-link">Help Center</a>
                                </li>
                                <li>
                                    <a href="contact.php" class="sub-link">Support</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="o-hidden">
                            <a href="contact.php" class="link"><span class="fill-text"
                                    data-text="Contact Us">Contact Us</span></a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="cont-info valign">
                <div class="text-center full-width">
                    <div class="logo">
                        <img src="assets/imgs/Logo-light.svg" alt="Connect Everest">
                    </div>
                    <div class="social-icon mt-40">
                        <a href="https://facebook.com/connecteverest" target="_blank"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="https://twitter.com/connecteverest" target="_blank"> <i class="fab fa-x-twitter"></i> </a>
                        <a href="https://linkedin.com/company/connect-everest" target="_blank"> <i class="fab fa-linkedin-in"></i> </a>
                        <a href="https://instagram.com/connecteverest" target="_blank"> <i class="fab fa-instagram"></i> </a>
                    </div>
                    <div class="item mt-30">
                        <h5>1417a London Road, <br> London, England, SW16 4AH</h5>
                    </div>
                    <div class="item mt-10">
                        <h5><a href="mailto:hello@connecteverest.co.uk">hello@connecteverest.co.uk</a></h5>
                        <h5 class="underline"><a href="tel:+447464430200">+44 7464430200</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== End Navbar ==================== -->

    <div id="smooth-wrapper">


        <div id="smooth-content">

            <main>



                <!-- ==================== Start Header ==================== -->

                <header class="contact-hed section-padding pb-0">
                    <div class="container">
                        <div class="caption mb-80 text-center">
                            <h1>Connect with Connect Everest</h1>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="google-map">
                            <iframe id="gmap_canvas"
                                src="https://maps.google.com/maps?q=1417a+London+Road+London+SW16+4AH&t=&z=15&ie=UTF8&iwloc=&output=embed">
                            </iframe>
                        </div>
                    </div>
                </header>

                <!-- ==================== End Header ==================== -->



                <!-- ==================== Start Contact ==================== -->

                <section class="contact-pg section-padding">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 valign">
                                <div class="full-width md-mb80">
                                    <div class="sec-head md-mb80">
                                        <h2 class="text-u">
                                            Your Gateway to <br> Global <span class="fw-200">Opportunities!</span>
                                        </h2>
                                        <p class="mt-20 mb-20">Connect Everest is your trusted partner in international recruitment and education consulting. We bridge the gap between talented professionals and global opportunities across Europe, Nepal, and India.</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="morinfo mt-30">
                                                    <h6 class="mb-15">Registered Office</h6>
                                                    <p>1417a London Road, London, England, SW16 4AH</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="morinfo mt-30">
                                                    <h6 class="mb-15">Company Details</h6>
                                                    <p>Company Number: 11948035</p>
                                                    <p>Website: Connecteverest.co.uk</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="phone fz-30 fw-600 mt-30 underline main-color">
                                            <a href="#0">+44 7464430200</a>
                                        </div>
                                    </div>
                                    <ul class="rest social-text d-flex mt-60 fz-16">
                                        <li class="mr-30">
                                            <a href="#0" class="hover-this"><span class="hover-anim">Facebook</span></a>
                                        </li>
                                        <li class="mr-30">
                                            <a href="#0" class="hover-this"><span class="hover-anim">Twitter</span></a>
                                        </li>
                                        <li class="mr-30">
                                            <a href="#0" class="hover-this"><span class="hover-anim">LinkedIn</span></a>
                                        </li>
                                        <li>
                                            <a href="#0" class="hover-this"><span
                                                    class="hover-anim">Instagram</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 offset-lg-1 valign">
                                <div class="full-width">
                                    <div class="sec-head mb-50">
                                        <h6 class="sub-head">Get in <span class="fw-200">Touch</span></h6>
                                    </div>
                                    <form id="contact-form" method="post" action="controller/contact.php">

                                        <div class="messages"></div>

                                        <div class="controls row">

                                            <div class="col-lg-6">
                                                <div class="form-group mb-30">
                                                    <input id="form_name" type="text" name="name" placeholder="Name"
                                                        required="required">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group mb-30">
                                                    <input id="form_email" type="email" name="email" placeholder="Email"
                                                        required="required">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group mb-30">
                                                    <input id="form_subject" type="text" name="subject"
                                                        placeholder="Subject">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <textarea id="form_message" name="message" placeholder="Message"
                                                        rows="4" required="required"></textarea>
                                                </div>
                                                <div class="mt-30">
                                                    <button type="submit" class="butn butn-md butn-bord butn-rounded">
                                                        <div class="d-flex align-items-center">
                                                            <span>Let's Talking</span>
                                                            <span class="icon ml-10">
                                                                <img src="../common/imgs/icons/arrow-top-right.svg"
                                                                    alt="">
                                                            </span>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ==================== End Contact ==================== -->


            </main>


            <!-- ==================== Start Footer ==================== -->

            <footer class="footer-sa pb-80">
                <div class="container section-padding bord-thin-top-light">
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-lg-5">
                                <a href="#" class="logo md-mb50">
                                    <img src="assets/imgs/Logo-light.svg" alt="Connect Everest">
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="item">
                                            <span class="sub-color">location</span>
                                            <p>1417a London Road, London, England, SW16 4AH</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end justify-end">
                                        <div class="item">
                                            <span class="sub-color">contact</span>
                                            <p>info@connecteverest.co.uk</p>
                                            <p>+44 7464430200</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 offset-lg-5">
                                <div class="social-icon">
                                    <a href="#0">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                    <a href="#0">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    <a href="#0">
                                        <i class="fa-brands fa-dribbble"></i>
                                    </a>
                                    <a href="#0">
                                        <i class="fa-brands fa-behance"></i>
                                    </a>
                                    <a href="#0">
                                        <i class="fa-brands fa-github"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-footer">
                    <div class="container bord-thin-top-light pt-50">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="copy sub-color md-mb30">
                                    <p>© 2025 Developed By <a href="https://endeavourdigital.in">Endeavour Digital</a>. All Rights Reserved</p>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex justify-content-end">
                                <div class="links sub-color d-flex justify-content-between">
                                    <a href="#0" class="active">Home</a>
                                    <a href="#0">Works</a>
                                    <a href="#0">Studio</a>
                                    <a href="#0">News</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- ==================== End Footer ==================== -->


        </div>

    </div>










    <!-- jQuery -->
    <script src="../common/js/lib/jquery-3.6.0.min.js"></script>
    <script src="../common/js/lib/jquery-migrate-3.4.0.min.js"></script>

    <!-- plugins -->
    <script src="../common/js/lib/plugins.js"></script>

    <!-- GSAP -->
    <script src="../common/js/gsap_lib/gsap.min.js"></script>
    <script src="../common/js/gsap_lib/ScrollSmoother.min.js"></script>
    <script src="../common/js/gsap_lib/ScrollTrigger.min.js"></script>
    <script src="../common/js/gsap_lib/SplitText.min.js"></script>
    <script src="../common/js/gsap_lib/matter.js"></script>
    <script src="../common/js/gsap_lib/throwable.js"></script>

    <!-- common scripts -->
    <script src="../common/js/common_scripts.js"></script>

    <!-- custom scripts -->
    <script src="assets/js/inner_pages.js"></script>

</body>

</html>