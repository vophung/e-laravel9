$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const titleEl = document.getElementById('title');

const create_form = document.querySelector('#create-category-form');

const isRequired = value => value === '' ? false : true
const isBetween = (length, min, max) => length < min || length > max ? false : true

const checkTitle = () => {
    let valid = false;
    const min = 3, max = 25;
    const title = titleEl.value.trim();

    if(!isRequired(title)){
        showError(titleEl, 'Please enter title');
    }else if(!isBetween(title.length, min, max)){
        showError(titleEl, `Please enter more than ${min} characters`);
    }else {
        showSuccess(titleEl);
        valid = true;
    }

    return valid;
}

const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if(timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args);
        }, delay);
    }
} 

const showError = (input, message) => {
    const formField = input;

    formField.classList.remove('is-valid');
    formField.classList.add('is-invalid');

    const error = formField.parentElement.querySelector('p');

    error.textContent = message;
}

const showSuccess = (input) => {
    const formField = input;

    formField.classList.remove('is-invalid');
    formField.classList.add('is-valid');

    const success = formField.parentElement.querySelector('p');

    success.textContent = '';
}

create_form.addEventListener('submit', function (e){
    e.preventDefault();

    let isTitleValid = checkTitle();

    var formData = new FormData(this);

    let isFormValid = isTitleValid;

    if(isFormValid) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: config.routes.store,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#exampleModalScrollable').modal('hide');
                console.log(data);
            },
            error: function (data) {
                console.log('error');
            }
        });
    }
});

const freshModalCreateCategory = $(document).on("hidden.bs.modal", "#exampleModalScrollable", function () {
    $(this).find('.modal-body input').val('');
    $(this).find('.modal-body input').parent().find('p').text('')
    $(this).find('.modal-body input').removeClass().addClass('form-control');
});

