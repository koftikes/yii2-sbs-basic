jQuery(function () {
    let modalContainer = $('#modal');
    let modalHeader = modalContainer.find('.modal-header');
    const close_button = modalHeader.html();
    let modalBody = modalContainer.find('.modal-body');

    $(document).on('click', '.showModal', function (e) {
        e.preventDefault();
        loadAdd();
        $.ajax({
            url: $(this).attr('href'),
            type: 'get',
            success: function (data) {
                if (is_json(data)) {
                    let response = JSON.parse(data);
                    modalHeader.html('<h3>' + response.header + '</h3>' + close_button);
                    modalBody.html(response.content);
                } else {
                    modalBody.html(data);
                }
                modalContainer.modal('show');
                loadRemove();
            }
        });
    });

    $(document).on('submit', '.modalForm', function (e) {
        e.preventDefault();
        loadAdd();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (data) {
                modalBody.html(data);
                loadRemove();
            }
        });
    });

    $(document).on('submit', '.ajaxForm', function (e) {
        e.preventDefault();
        loadAdd();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (data) {
                form.parent().html(data);
                loadRemove();
                scrollToError();
            }
        });
    });
});

function scrollToError() {
    let error = $('.has-error').first().offset();
    if (typeof error !== 'undefined') {
        $('html, body').animate({
            scrollTop: error.top
        }, 1000);
    }
}

function loadAdd() {
    $('<div class="overlay"></div>').appendTo('body');
    $('<div class="loading-img"><div></div></div>').appendTo('body');
}

function loadRemove() {
    $('.loading-img').remove();
    $('.overlay').remove();
}

function is_json(str) {
    try {
        JSON.parse(str);
        return true;
    } catch (e) {
        return false;
    }
}
