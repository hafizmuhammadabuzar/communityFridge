
</header>
<div id="main">
    <section id="contact">
        <div class="holder">
            <h2 class="section-head">Contact us</h2>
            <span class="contact-msg"></span>
            <div class="LeftBox">
                <form action="<?php echo base_url('contact-form'); ?>" id="contact-form" method="post">
                    <div class="inputbox">
                        <label>Name:</label>
                        <input type="text" name="username" required="required" />
                    </div>
                    <div class="inputbox last">
                        <label>Phone:</label>
                        <input type="text" name="phone" required="required" />
                    </div>
                    <div class="inputbox">
                        <label>Email:</label>
                        <input type="text" name="email" required="required" />
                    </div>
                    <div class="inputbox last">
                        <label>Subject:</label>
                        <input type="text" name="subject" required="required" />
                    </div>
                    <div class="inputbox message">
                        <label>Message:</label>
                        <textarea cols="0" rows="" name="message" required="required"></textarea>
                    </div>
                <input type="submit" value="submit" />
                </form>
            </div>

            <div class="RightBox">
                <div class="box">
                    <h3>Contact Info</h3>                                
                    <address class="address">Delaware, USA</address>
                    <p class="email"><a href="mailto:info@communityfridge.org">info@communityfridge.org</a></p>
                </div>
                <div class="socialLink">
                    <h3>Social Links</h3>
                    <a href="http://facebook.com/communityfridge/" class="facebook" target="_blank"></a>
                    <a href="http://twitter.com/FridgeCommunity" class="twitter" target="_blank"></a>
                    <a href="http://instagram.com/communityfridge/" class="insta" target="_blank"></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </section>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        var form = $('#contact-form');
        form.submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $('#contact-form').serialize(),
                success:function(data){
                    if(data == 1){
                        $('.contact-msg').css("color", "green").text('Email Sent');
                        form[0].reset();
                    }
                    else{
                        $('.contact-msg').css("color", "red").val(data);
                    }
                }
            });
        });
    });

</script>