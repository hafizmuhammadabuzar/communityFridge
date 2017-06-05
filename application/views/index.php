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
<div id="main">
    <section id="app">
        <div class="holder">
            <h3>DOWNLOAD MOBILE APPS</h3>
            <h4>MAPPING SHARING POINTS GLOBALLY</h4>
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
    <section id="Disclaimer">
        <div class="holder">
            <p><strong>DISCLAIMER:</strong> Community Fridge is not responsible for the food, drinks or any content placed in the fridge / shelf. Additionally, Community Fridge does not take any responsibility of the fridge. We only provide a platform that enables community sourced mapping. </p>
            <img src="<?php echo base_url(); ?>assets/images/qr-code.png" alt="QR Code">
        </div>
    </section>
</div>