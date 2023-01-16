(function () {

    document.addEventListener('click', (event) => {

        console.log(event);
        if (!event.target.matches('#es_product_enquiry_btn, .es_enquiry_form_overlay')) return;

        const addClass = (el, className) => {
            el.classList.toggle(className);
        }

        const overlay = document.querySelector('.es_enquiry_form_overlay');
        const enquiry_form = document.querySelector('.es_enquiry_form');

        addClass(overlay, 'active');
        addClass(enquiry_form, 'active');
    })


})();