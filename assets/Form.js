import axios from "axios";

function Form(
    formName,
    url,
    contentType = 'application/json',
    flashMessageId = 'messages'
) {
    function clearErrors()
    {
        setFlashMessage('');
        const errors = document.querySelectorAll('.error');
        for (const el of errors) {
            el.parentNode.removeChild(el);
        }
    }

    function createErrorElement(message, classes = ['error'])
    {
        const error = document.createElement('span');
        error.className = classes.join(' ');
        error.innerText = message;
        return error;
    }

    function setInputErrors(field, errors)
    {
        const input = document.querySelector(`form[name="${formName}"] [name="${field}"]`);
        for (const message of errors) {
            const error = createErrorElement(message)
            input.parentNode.appendChild(error);
        }
    }

    function errorHandler(response)
    {
        setFlashMessage(`Error: ${response.response.data.message}`);
        const children = response.response.data.errors.children;
        for (const key in children) {
            if (children.hasOwnProperty(key) && 'errors' in children[key]) {
                setInputErrors(key, children[key].errors);
            }
        }
    }

    function successHandler(response)
    {
        setFlashMessage('Success');
        form.reset();
    }

    function submitForm(form, url)
    {
        clearErrors();
        axios({
            method: 'post',
            url,
            data: new FormData(form),
            headers: { 'Content-Type': contentType }
        })
            .then(successHandler)
            .catch(errorHandler);
    }

    function setFlashMessage(message)
    {
        if (messageContainer) {
            messageContainer.innerText = message;
        }
    }

    const form = document.forms[formName];
    const messageContainer = document.getElementById(flashMessageId);

    if (!form) {
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        setFlashMessage('');
        submitForm(form, url);
    })
}

export default Form
