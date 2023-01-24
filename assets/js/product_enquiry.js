(function () {

    const enquiry_form = document.querySelector('.es_enquiry_form');

    document.addEventListener('click', (event) => {

        if (!event.target.matches('#es_product_enquiry_btn, .es_enquiry_form_overlay, .es_enquiry_form__close--icon')) return;

        const addClass = (el, className) => {
            el.classList.toggle(className);
        }

        const overlay = document.querySelector('.es_enquiry_form_overlay');

        addClass(overlay, 'active');
        addClass(enquiry_form, 'active');
    });

    enquiry_form.addEventListener('submit', (event) => {
        event.preventDefault();

        const form = event.target;

        let has_error = es_validate_enquiry_form(form);

        if(!has_error) {
            jQuery('.es_loader').addClass('active');
            const format_data = (form) => {
                let data_obj = {};
                const form_data = new FormData(form);
                for(let key of form_data.keys()) {
                    data_obj[key] = form_data.get(key);
                }

                return data_obj;
            }

            let submit_data = format_data(form);
            submit_data.action = 'es_product_enquiry_submit';
            submit_data.nonce = ajax_object.nonce;

            jQuery.ajax({
                type: 'POST',
                cache: false,
                url: ajax_object.ajax_url,
                data: submit_data,
                success: function(data) {
                    let html = '<div class="es_enquiry_form__close"> ' +
                        '<div class="es_enquiry_form__close--icon"></div> ' +
                        '</div>' +
                        '<div class="success_message">Thank you for your enquiry, someone will be in touch soon</div>';
                    jQuery('.es_enquiry_form').html(html);
                },
                error: function(errorThrown){
                    jQuery('.es_loader').removeClass('active');
                    console.log(errorThrown);
                }
            });
        }
    });

    const es_validate_enquiry_form = (form) => {

        const name = jQuery(form).find('input[name="name"]');
        const email = jQuery(form).find('input[name="email"]');
        const enquiry = jQuery(form).find('textarea[name="enquiry"]');
        const required = [
            name,
            email,
            enquiry
        ];

        jQuery('.error_msg').remove();

        let has_error = false;

        required.forEach((el) => {

            if(el.val().length < 1) {
                el.after('<span class="error_msg">Please enter a value</span>');
                el.addClass('error');
                has_error = true;
            } else if(el.attr('name') === 'email') {
                const reg_ex = /^[a-zA-Z\d.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z\d-]+(?:\.[a-zA-Z\d-]+)*$/;
                const validEmail = reg_ex.test(el.val());
                if (!validEmail) {
                    el.after('<span class="error_msg">Enter a valid email</span>');
                    el.addClass('error');
                    has_error = true;
                }
            } else {
                if(el.hasClass('error')) {
                    el.removeClass('error');
                }
            }
        })

        return has_error;
    }

})();