<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Community Fridge</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Community Fridge">
        <meta name="keywords" content="Community Fridge">
        <meta name="author" content="Synergistics FZ LLC">
        <!--<meta property="og:url" content="http://www.communityfridge.org"/>
        <meta property="og:title" content="Community Fridge" />
        <meta property="og:description" content="Community Fridge" />
        <meta property="og:image" content="<?php echo base_url(); ?>assets/images/facebooklogo.JPG" />-->
        
        <meta property="og:type" content="website"/>
	<meta property="og:url" content="http://www.communityfridge.org/"/>
	<meta property="og:title" content="Community Fridge"/>
	<meta property="og:description" content="Community Fridge"/>
	<meta property="og:site_name" content="Community Fridge" />
	<meta property="og:image" content="http://communityfridge.org/assets/images/facebookimg.jpg"/>
        <meta name = "format-detection" content = "telephone=no">
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
        <script type="application/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <script type="application/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script> 
        <?php echo $map['js']; ?>
    </head>
    <body>
        <div id="wrapper">
            <header id="header">
                <div class="head-bottom">
                    <div class="holder">
                        <div class="logo">
                            <a href="#"><img src="<?php echo base_url(); ?>assets/images/logo.png"></a>
                        </div>
                        <div class="main-menu">
                            <ul>
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li><a href="#resource">Resource</a></li>
                                <li><a href="#app">App</a></li>
                                <li><a href="#contact">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>  
                <div class="map">
                    <?php echo $map['html']; ?>
                </div>
                <div class="search-area">
                    <div class="holder">
                        <form action="<?php echo base_url() . 'search'; ?>" method="post">
                            <div class="input-wrap">
                                <select id="country" name="country">
                                    <option selected>Country</option>
                                    <?php foreach ($countries as $cnt): ?>
                                        <option value="<?php echo $cnt['country']; ?>"><?php echo $cnt['country']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-wrap">
                                <select id="city" name="city" disabled="disabled">
                                    <option selected>City / Area</option>
                                </select>
                            </div>
                            <input type="submit" value="Search" class="btn-submit">
                        </form>
                    </div>
                </div>
            </header>
            <div id="main">
                <section id="services">
                    <div class="holder">
                        <h2 class="section-head">About Us</h2>
                        <div class="boxes">
                            <div class="box">
                                <img src="<?php echo base_url(); ?>assets/images/icon1.png" alt="icon">
                                <div class="text-area">
                                    <h3>How Does it Work  </h3>
                                    <p>There are many wonderful community sharing fridge / shelve initiatives around the word.</p>
                                    <p class="more-text">  We just provide an easy platform for them to list their locations with some basic information; so community members can easy know where the locations are.   </p>
                                    <a href="#" class="read-more">Read More >></a>
                                </div>
                            </div>
                            <div class="box">
                                <img src="<?php echo base_url(); ?>assets/images/icon2.png" alt="icon">
                                <div class="text-area">
                                    <h3>How Can You Use It </h3>
                                    <p>If you are part of an organization or group of volunteers, just drop us an email or give us a call, we will setup the system for you to use. </p>
                                    <p class="more-text">Apps are both on Google and Apple store, the community can download and start using it.  </p>
                                    <a href="#" class="read-more">Read More >></a>
                                </div>
                            </div>
                            <div class="box">
                                <img src="<?php echo base_url(); ?>assets/images/icon3.png" alt="icon">
                                <div class="text-area">
                                    <h3>What If… </h3>
                                    <p>Who is responsible regarding the food quality, fridge status and such; well the organization and individual who owns the fridge are. </p>
                                    <p class="more-text">We simply provide a mapping platform and have to direct involvement into the operation of the fridges.</p>
                                    <a href="#" class="read-more">Read More >></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="resource">
                    <div class="holder">
                        <h2 class="section-head">Resources for fridge sharing</h2>
                        <span class="text">Download and print Quote for motivate peoples to help improve community fridge idea</span>
                        <ul>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-1.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-1.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-2.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-2.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-3.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-3.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-4.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-4.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-5.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-5.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-6.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-6.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-7.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-7.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-8.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-8.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-9.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-9.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-10.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-10.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-11.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-11.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-12.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-12.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/thumb-img-13.jpg" alt="quote image">
                                <a href="<?php echo base_url(); ?>assets/images/poster-img-13.jpg" class="link-download" download>Download</a>
                            </li>
                        </ul>
                    </div>
                </section>
                <section id="contact">
                    <div class="holder">
                        <div class="boxes">
                            <div class="box">
                                <h3>Community Fridge</h3>
                                <p>We started out a need to contribute to such wonderful initiatives around the world. We are a non-profit setup with a simple aim; to provide an easy to use mapping platform.</p>
                                <p> If you a corporate and wish to support us, please drop us an email.</p>
                                <!--<a href="#">Read More ></a>-->
                            </div>
                            <div class="box">
                                <h3>Contact Info</h3>
                                
								<!--<span class="phone">+971(000) 123-4567</span>-->
                                
                                <address>Delaware, USA</address>
                                <a href="mailto:hello@example.com">info@communityfridge.org</a>
                            </div>
                            <div class="box socialLink">
                                <h3>Social Links</h3>
                                <a href="http://facebook.com/communityfridge/" class="facebook" target="_blank"></a>
                                <a href="http://twitter.com/FridgeCommunity" class="twitter" target="_blank"></a>
                                <a href="http://instagram.com/communityfridge/" class="insta" target="_blank"></a>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="app">
                    <div class="holder">
                        <h3>Download Our Mobile Apps</h3>
                        <h4>To Keep track of every thing which happens around you</h4>
                        <ul>
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=com.synergistics.ramadanfridge" target="_blank"><img src="<?php echo base_url(); ?>assets/images/playstore.png" alt="googple play link"></a>
                            </li>
                            <li>
                                <a href="https://appsto.re/pk/pX2Sdb.i" target="_blank"><img src="<?php echo base_url(); ?>assets/images/appstore.png" alt="Apple store link"></a>
                            </li>
                        </ul>
                        <img src="<?php echo base_url(); ?>assets/images/img7.png" alt="mobile image" class="mobile-img">
                    </div>
                </section>
            </div>
            <footer id="footer">
                <div class="holder">
                    <p>&copy Synergistics.ae All rights reserved.</p>
                </div>
            </footer>
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
                ga('create', 'UA-84743339-1', 'auto');
                ga('send', 'pageview');

                $('#country').change(function () {
                    $.ajax({
                        type: 'POST',
                        data: {country: $(this).val()},
                        url: "<?php echo base_url() . 'getCities' ?>",
                        success: function (response) {
                            $('#city').replaceWith(response);
                        }
                    })
                });
            </script>
        </div>
    </body>
</html>