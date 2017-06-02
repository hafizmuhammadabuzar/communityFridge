
</header>
<div class="holder">
    <section id="faq">
        <h2 class="section-head">FAQ's</h2>
        <div class="accordion vertical">
            <ul>
                <li>
                    <input type="checkbox" id="checkbox-1" name="checkbox-accordion" />
                    <label for="checkbox-1">What devices does the app work on?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <h3>iOS</h3>                                    
                            <p>Community Fridge works on all Apple iPhone devices running iOS8 and above.</p>
                            <h3>Android</h3>
                            <p>Community Fridge works on Android 4.0.3 (ICS) to 7.0 (Nougat). </p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-2" name="checkbox-accordion" />
                    <label for="checkbox-2">What are the benefits of signing up with Facebook?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>When you sign up with Facebook, you don’t have to fill out any of the required details and you will also not have to verify your account through your email.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-3" name="checkbox-accordion" />
                    <label for="checkbox-3">Who can add a Fridge to the app?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>The owner of a fridge or the organization responsible for a fridge can add it to the app.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-4" name="checkbox-accordion" />
                    <label for="checkbox-4">How do I add a Fridge to the app?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>Once you have downloaded the app, you can sign up using your Facebook account or create a new account from scratch. You can then proceed by tapping on the menu icon on the top-left corner of the screen and simply choosing ‘Add New Fridge’.</p>
                        </div>
                    </div>
<<<<<<< HEAD
                </section>
            </div>
            <footer id="footer">
                <div class="holder">
                	<ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li class="active"><a href="#">FAQ's</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                    <p class="copyright">&copy Synergistics.ae All rights reserved.</p>
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
=======
                </li>
                <li>
                    <input type="checkbox" id="checkbox-5" name="checkbox-accordion" />
                    <label for="checkbox-5">Is the app available in all countries?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>Yes, the app is available in every country through the App Store and Play Store.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-6" name="checkbox-accordion" />
                    <label for="checkbox-6">Can I use the app in landscape?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>The app is designed to work in portrait mode only on iPhone &amp; Android.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-7" name="checkbox-accordion" />
                    <label for="checkbox-7">Can I change location in the application?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>Yes, you can search for different locations by tapping on your current location in header of the application. </p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-8" name="checkbox-accordion" />
                    <label for="checkbox-8">How long does it take to activate a user’s fridge, shelf or water cooler?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>Fridge, Shelf or Water Cooler are added to the list within 24 hours after verification.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-9" name="checkbox-accordion" />
                    <label for="checkbox-9">How can a user report issues related to fridge, shelf or water cooler?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>On the details screen of every Fridge, there is an option to report issues relating to the Fridge, which are sent to the fridge owner.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <input type="checkbox" id="checkbox-10" name="checkbox-accordion" />
                    <label for="checkbox-10">How can a user contact the developer of the app?</label>
                    <div class="content">
                        <div class="paddingBox">
                            <p>You can contact us at info@synergistics.ae</p>
                        </div>
                    </div>
                </li>
            </ul>
>>>>>>> e1f9f97031600ce6cc1838dbc28acfdc8d5d5e82
        </div>
    </section>
</div>