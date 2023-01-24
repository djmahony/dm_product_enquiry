<div class="es_enquiry_form">
    <div class="es_enquiry_form__close">
        <div class="es_enquiry_form__close--icon"></div>
    </div>
    <div class="es_enquiry_form__title">
        Enquire about <?php echo $args['name']; ?>
    </div>
    <form id="#es_enquiry_form__form" action="<?php echo admin_url('admin-ajax.php'); ?>">
        <div class="es_enquiry_form__input-container">
            <label for="name">Name:</label>
            <input type="text" name="name" />
        </div>
        <div class="es_enquiry_form__input-container">
            <label for="email">Email:</label>
            <input type="text" name="email" />
        </div>
        <div class="es_enquiry_form__input-container">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" />
        </div>
        <div class="es_enquiry_form__input-container">
            <label for="enquiry">Enquiry:</label>
            <textarea name="enquiry"></textarea>
        </div>
        <input type="hidden" name="product_id" value="<?php echo $args['id']; ?>" />
        <button class="es_enquiry_form__button" type="submit" form="#es_enquiry_form__form">Send Enquiry</button>
    </form>
</div>
<div class="es_enquiry_form_overlay"></div>