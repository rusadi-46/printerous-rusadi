const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true
})

function setState(el, state) {
    state = typeof state !== 'undefined' ? state : false;

    if (state) {
        $(el).addClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light')
        $(el).prop('disabled', 'disabled')
    } else {
        $(el).removeClass('kt-spinner kt-spinner--right kt-spinner--md kt-spinner--light')
        $(el).prop('disabled', false)
    }
}

function setText(text, target) {
    $('#'+target).html(text)
}

function goto(url) {
    window.location.href = url
}

function setStateForm(form_id, state) {
    form_id = typeof form_id !== 'undefined' ? form_id : 'post_form';
    state = typeof state !== 'undefined' ? state : false;

    if (state) {
        $(':button').prop('disabled', 'disabled');
        $(':input').prop('readonly', 'readonly');
    } else {
        $(':button').prop('disabled', false);
        $(':input').prop('readonly', false);
    }
}

function submitForm(form_id, button_id) {
    form_id = typeof form_id !== 'undefined' ? form_id : 'post_form';
    button_id = typeof button_id !== 'undefined' ? button_id : 'submit_btn';

    setStateForm(form_id, button_id)

    $('#' + button_id).addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light')
    $('#' + form_id).submit();
}

function deleteForm(form_id, button_id, title, text, confirm_text, cancel_text) {
    form_id = typeof form_id !== 'undefined' ? form_id : 'delete_form';
    button_id = typeof button_id !== 'undefined' ? button_id : 'delete_btn';
    title = typeof title !== 'undefined' ? title : 'delete_btn';
    text = typeof text !== 'undefined' ? text : 'delete_btn';
    confirm_text = typeof confirm_text !== 'undefined' ? confirm_text : 'Submit';
    cancel_text = typeof cancel_text !== 'undefined' ? cancel_text : 'Cancel';

    Swal.fire({
      title: title,
      text: text,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: confirm_text,
      cancelButtonText: cancel_text
    }).then((result) => {
        if (result.value) {
            submitForm(form_id, button_id)
        }
    })
}

function postFormValidation(form_id, button_id, validation_url, appended_data) {
    setStateForm(form_id, true)
    $('#' + button_id).addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light')

    var formData = new FormData(document.getElementById(form_id));
    formData.delete("_method")
    _.forEach(appended_data, (value) => {
        formData.append(value, $('#'+value).val())
    });

    return $.ajax({
        type: "POST",
        url: validation_url,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: (response) => {
            if (response.success) {
                return true
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response.message,
                    onClose: () => {
                       setStateForm(form_id, false)
                       $('#' + button_id).removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light')
                       return false
                    }
                })
            }
        },
        error: (error) => {
            Toast.fire({
                icon: 'error',
                title: error.responseJSON.message,
                onClose: () => {
                   setStateForm(form_id, false)
                   $('#' + button_id).removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light')
                   return false
                }
            })
        }
    })
}

$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });

    $("#show_hide_password_confirm a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password_confirm input').attr("type") == "text"){
            $('#show_hide_password_confirm input').attr('type', 'password');
            $('#show_hide_password_confirm i').addClass( "fa-eye-slash" );
            $('#show_hide_password_confirm i').removeClass( "fa-eye" );
        }else if($('#show_hide_password_confirm input').attr("type") == "password"){
            $('#show_hide_password_confirm input').attr('type', 'text');
            $('#show_hide_password_confirm i').removeClass( "fa-eye-slash" );
            $('#show_hide_password_confirm i').addClass( "fa-eye" );
        }
    });
});
