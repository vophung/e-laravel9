const emailEl = document.getElementById('email');
const nameEl = document.getElementById('name');
const passwordEl = document.getElementById('password');
const confirmPasswordEl = document.getElementById('confirm_password');

const form = document.querySelector('#signup');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let regexPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/
let regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

const isRequired =  value => value === '' ? false : true
const isBetween = (length, min, max) => length < min || length > max ? false : true
const isEmail = (email) => regexEmail.test(String(email).toLowerCase()); 
const isPassword = (password) => password.match(regexPassword) ? true : false
const matchPassword = (password, confirm_password) => password != confirm_password ? false : true
const emptyPassword = (password) => password === '' ? false : true 
const duplicateEmail = function checkEmailExist(email) {
    var res = false;

    $.ajax({
        type: "POST",
        url: "/check-email",
        async: false,
        data: {
            email : email,
        },
        success: function(data) {
            data.exists ? res = true : res = false;
        },
        error: function(data) {
            console.log('error');
        }
    });

    return res;
}

const checkEmail = () => {
    let valid = false;
    const email = emailEl.value.trim();

    if(!isRequired(email)){
        showError(emailEl, 'Please enter your email')
    }else if(!isEmail(email)){
        showError(emailEl, 'Please enter a valid email address')
    }else if(duplicateEmail(email)){
        showError(emailEl, 'Email already exists');
    }else {
        showSuccess(emailEl);
        valid = true;
    }

    return valid;
}

const checkName = () => {
    let valid = false;
    const min = 8, max = 25;
    const name = nameEl.value.trim();

    if(!isRequired(name)){
        showError(nameEl, 'Please enter your name')
    }else if(!isBetween(name.length, min, max)){
        showError(nameEl, `Please enter more than ${min} characters`)
    }else {
        showSuccess(nameEl);
        valid = true;
    }

    return valid;
}

const checkPassword = () => {
    let valid = false;
    const min = 8, max = 20;
    const password = passwordEl.value.trim();

    if(!isRequired(password)){
        showError(passwordEl, 'Please enter your password')
    }else if(!isBetween(password.length, min, max)){
        showError(passwordEl, `Please enter a password between ${min} and ${max} characters`)
    }else if(!isPassword(password)){
        showError(passwordEl, 'Please enter a password with 0 to 9, upper and lower case characters')
    }else {
        showSuccess(passwordEl);
        valid = true;
    }

    return valid;
}

const checkConfirmPassword = () => {
    let valid = false; 
    const password = passwordEl.value;
    const confirmPassword = confirmPasswordEl.value.trim();

    if(!isRequired(confirmPassword)){
        showError(confirmPasswordEl, 'Please enter confirm password')
    }else if(!emptyPassword(password)){
        showError(confirmPasswordEl, 'Please enter your password');
    }else if(!matchPassword(password, confirmPassword)){
        showError(confirmPasswordEl, 'Password does not match')
    }else {
        showSuccess(confirmPasswordEl);
        valid = true;
    }

    return valid;
}

const showError = (input, message) => {
    const formField = input;

    formField.classList.remove('is-valid');
    formField.classList.add('is-invalid');

    const error = formField.parentElement.querySelector('p');

    error.textContent = message;
}

const showSuccess = (input, message) => {
    const formField = input;

    formField.classList.remove('is-invalid');
    formField.classList.add('is-valid');

    const success = formField.parentElement.querySelector('p');

    success.textContent = message;
}

const debounce = (fn, delay = 500) => {
    let timeoutId;

    return (...args) => {
        if(timeoutId) {
            clearTimeout(timeoutId);
        }

        timeoutId = setTimeout(() => {
            fn.apply(null, args);
        }, delay);
    }
}

form.addEventListener('input', debounce(function (e){
    switch (e.target.id) {
        case 'email':
            checkEmail();
            break;
        case 'name':
            checkName();
            break;
        case 'password':
            checkPassword();
            break;
        case 'confirm_password':
            checkConfirmPassword();
            break;
    }
}));