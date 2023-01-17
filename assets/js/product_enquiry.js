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

        const format_data = (form) => {
            let data_obj = {};
            const form_data = new FormData(form);
            for(let key of form_data.keys()) {
                data_obj[key] = form_data.get(key);
            }

            return data_obj;
        }

        let submit_data = format_data(event.target);
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
                console.log(errorThrown);
            }
        });
    });
})();