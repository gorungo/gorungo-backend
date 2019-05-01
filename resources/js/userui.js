let showNotification = function (text, msg_type) {

    var auto_hide = true;

    // сообщение о результате операции

    var result_message_wnd = $("<div>", {
        "id": "result_message",
        "class": "result_message"
    });

    //result_message_wnd = $("#result_message");
    res_msg_class = '';

    switch (msg_type) {
        case 'red':
            // красное сообщение
            res_msg_class = "res_msg_red";

            break;
        case 'green':
            // зеленое сообщение
            res_msg_class = "res_msg_green";
            text = '<img src="/images/svg/checkmark.svg" width="64px" height="64px"/><br/>' + text;

            break;

        case 'modal':
            // красное сообщение
            res_msg_class = "res_msg_modal";
            auto_hide = false;

            break;
        default :

            break;


    }
    if (text != '') {

        text_lenght = text.length; // длина сообщения
        msg_time = 30 * text_lenght;


        if (res_msg_class != '') {
            $(result_message_wnd).addClass(res_msg_class);
        }

        $(result_message_wnd).html(text);

        $("body").append(result_message_wnd);

        $(result_message_wnd).css("top", ($(window).height() / 2) - ($(result_message_wnd).height() / 2)).css("left", ($(document).width() / 2) - ($(result_message_wnd).width() / 2)-($(result_message_wnd).width()*0.07));

        if (auto_hide) {
            $(result_message_wnd).fadeIn(200).delay(msg_time).fadeOut(200);

        } else {
            $(result_message_wnd).fadeIn(200).delay(4 * msg_time).fadeOut(200);

        }

    }


    $(result_message_wnd).click(function () {
        $(result_message_wnd).hide();
        $(result_message_wnd).detach();
    });


};

let showProgress = function() {
    // show loading progress
    var loading = $("<div>", {
        "class": "ds-loading"
    });
    //выравним div по центру страницы
    $(loading).css("top", (($(window).height() / 2))).css("left", ($(document).width() / 2) - 110);
    //добавляем созданный div в конец документа
    $("body").append(loading);
};

let hideProgress = function() {
    // hide loading progress
    $(".ds-loading").detach();
};

let showNoInternetNotification = function() {
    this.showNotification('Нет связи с сетью, повторите попытку', 'red', 'center');
};

module.exports.showProgress = showProgress;
module.exports.hideProgress = hideProgress;
module.exports.showNotification = showNotification;
module.exports.showNoInternetNotification = showNoInternetNotification;