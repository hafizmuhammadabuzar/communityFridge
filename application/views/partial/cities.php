<select id="city" name="city">
    <option value="">City / Area</option>
    <?php foreach($cities as $ct): ?>
    <option value="<?php echo $ct['area']; ?>"><?php echo ucfirst($ct['area']); ?></option>
    <?php endforeach; ?>
</select>