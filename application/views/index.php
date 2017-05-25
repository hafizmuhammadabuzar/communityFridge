<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Community Fridge</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Community Fridge">
        <meta name="keywords" content="Community Fridge">
        <meta name="author" content="Synergistics FZ LLC">
        <meta property="og:url" content="http://www.mygpacalc.com"/>
        <meta property="og:title" content="Community Fridge" />
        <meta property="og:description" content="Community Fridge" />
        <meta property="og:image" content="<?php echo base_url(); ?>assets/images/fb-logo.png" />
        <meta name = "format-detection" content = "telephone=no">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/images/favicon.png">
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
                        <h2 class="section-head">Our Services</h2>
                        <div class="boxes">
                            <div class="box">
                                <img src="<?php echo base_url(); ?>assets/images/icon1.png" alt="icon">
                                <div class="text-area">
                                    <h3>Active Communities</h3>
                                    <p>Initiatives in Spain, London, USA, India have sprung up in addition to a huge movement in in the UAE. </p>
                                    <p class="more-text"> This past Ramadan, the UAE Ramadan Fridge Initiative peaked at around 140 shared fridges around the UAE. Post Ramadan, many have kept the fridges going, with about 70 currently operational.</p>
                                    <a href="#" class="read-more">Read More >></a>
                                </div>
                            </div>
                            <div class="box">
                                <img src="<?php echo base_url(); ?>assets/images/icon2.png" alt="icon">
                                <div class="text-area">
                                    <h3>Volunteers for Your Help</h3>
                                    <p>These initiatives, having started at the grass roots level have no formal structure or support; it is entirely volunteer run.</p>
                                    <p class="more-text"> The most basic requirement is simply to know where there are active fridges; so volunteers can re-stock them.</p>
                                    <a href="#" class="read-more">Read More >></a>
                                </div>
                            </div>
                            <div class="box">
                                <img src="<?php echo base_url(); ?>assets/images/icon3.png" alt="icon">
                                <div class="text-area">
                                    <h3>24/7 Help</h3>
                                    <p>For 24/7 help download our app and update and see status of fridge. By using app user can know and track the status of fridge details. </p>
                                    <p class="more-text">User can also report fridge if it's empty or broken. Not only tracking & reporting but also user can find near by fridges.</p>
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
                                <img src="<?php echo base_url(); ?>assets/images/img1.jpg" alt="quote image">
                                <a href="images/img1.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img2.jpg" alt="quote image">
                                <a href="images/img2.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img9.jpg" alt="quote image">
                                <a href="images/img9.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img1.jpg" alt="quote image">
                                <a href="images/img1.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img2.jpg" alt="quote image">
                                <a href="images/img2.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img9.jpg" alt="quote image">
                                <a href="images/img9.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img1.jpg" alt="quote image">
                                <a href="images/img1.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img2.jpg" alt="quote image">
                                <a href="images/img2.jpg" class="link-download" download>Download</a>
                            </li>
                            <li>
                                <img src="<?php echo base_url(); ?>assets/images/img9.jpg" alt="quote image">
                                <a href="images/img9.jpg" class="link-download" download>Download</a>
                            </li>
                        </ul>
                    </div>
                </section>
                <section id="contact">
                    <div class="holder">
                        <div class="boxes">
                            <div class="box">
                                <h3>About Us</h3>
                                <p>Synergistics FZ LLC is an innovative and young software development house based in Dubai, United Arab Emirates, with the objective of becoming the region's leading mobile application developer. </p>
                                <p>An objective that we seek to achieve by being committed to our three principles of design: creativity, functionality and usability.</p>
                                <!--<a href="#">Read More ></a>-->
                            </div>
                            <div class="box">
                                <h3>Contact Us</h3>
                                <address>Synergistics FZ LLC <br><br> P.O.Box. 51999, <br><br> Dubai, United Arab Emirates.</address><br>
<!--                        <span class="phone">+971(000) 123-4567</span>-->
                                <a href="mailto:hello@example.com">info@synergistis.ae</a>
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
                                <a href="#"><img src="<?php echo base_url(); ?>assets/images/playstore.png" alt="googple play link"></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?php echo base_url(); ?>assets/images/appstore.png" alt="Apple store link"></a>
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