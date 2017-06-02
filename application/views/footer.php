<footer id="footer">
    <div class="holder">
        <!--<ul>
            <li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
            <li><a href="<?php echo base_url('faq'); ?>">FAQ's</a></li>
            <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
        </ul>-->
        <p class="copyright">&copy; Copyright Community Fridge 2017 - Developed by <a href="http://synergistics.ae" target="_blank">Synergistics FZ LLC</a></p>
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