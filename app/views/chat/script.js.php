<?php

use yii\web\View;
use yii\helpers\Url;

/* @var $this View */
?>
<?php if (false): ?>
    <script>
    <?php endif; ?>
    var deeChat = {
        id: undefined,
        myName: undefined,
        sseObj: undefined,
        activeChat: undefined,
        activeChatName: undefined,
        time: undefined,
        onMarkRead: false,
        msgs: {},
        notif: {},
        newAccount: function () {
            $.post('<?= Url::to(['new-account']) ?>',
                {
                    name: $('#inp-account').val()
                }, function (r) {
                if (r.id != deeChat.id) {
                    if (deeChat.sseObj !== undefined) {
                        deeChat.sseObj.close();
                        deeChat.sseObj = undefined;
                    }
                    deeChat.id = r.id;
                    $('#inp-account').val('').hide();
                    $('#my-info').show();
                    $('#my-name').text(r.name);
                    deeChat.myName = r.name;

                    deeChat.sseObj = new EventSource(r.url);

                    deeChat.sseObj.addEventListener('account', deeChat.onAccount);
                    deeChat.sseObj.addEventListener('chat', deeChat.onChat);
                    deeChat.sseObj.addEventListener('notif', deeChat.onNotif);
                }
            });
        },
        close: function () {
            $('#inp-account').show();
            $('#my-info').hide();
            deeChat.id = undefined;
            deeChat.activeChat = undefined;
            if (deeChat.sseObj !== undefined) {
                deeChat.sseObj.close();
                deeChat.sseObj = undefined;
            }
            $('#list-account').html('');
            $('#acc-name').text('');
            $('#messages').html('');
        },
        onAccount: function (e) {
            var accs = JSON.parse(e.data);
            var $ul = $('#list-account').html('');
            for (var i in accs) {
                var acc = accs[i];

                var $li = $('<li>').addClass(acc.idle ? 'idle' : 'online')
                    .attr('data-id', acc.id)
                    .append($('<a href="javascript:;">').text(acc.name));
                if (acc.id == deeChat.activeChat) {
                    $li.addClass('active');
                }
                $li.appendTo($ul);
            }
        },
        onChat: function (e) {
            var data = JSON.parse(e.data);
            var msgs = data.msgs;
            deeChat.time = data.time;
            for (var accId in msgs) {
                if (deeChat.msgs[accId] === undefined) {
                    deeChat.msgs[accId] = [];
                }
                for (var i in msgs[accId]) {
                    var row = msgs[accId][i];
                    deeChat.msgs[accId].push(row);

                    if (deeChat.activeChat == accId) {
                        var sender = row[0] ? deeChat.myName : deeChat.activeChatName;
                        $('<div>').append($('<strong>').text(sender + ' : '))
                            .append($('<span>').text(row[1]))
                            .appendTo('#messages');
                    }
                }
                $("#messages").scrollTop($("#messages")[0].scrollHeight);
            }
        },
        onNotif: function (e) {
            var notif = JSON.parse(e.data);
            $('#list-account li').removeClass('new-message');
            for (var i in notif) {
                var row = notif[i];
                $('#list-account li[data-id="' + row.from + '"]').addClass('new-message');
                deeChat.notif[row.from] = true;
            }
        },
        markRead: function () {
            if (!deeChat.onMarkRead && deeChat.notif[deeChat.activeChat] !== undefined) {
                deeChat.onMarkRead = true;
                $.post('<?= Url::to(['mark-read']) ?>', {
                    from: deeChat.activeChat,
                    to: deeChat.id,
                    time: deeChat.time
                }, function () {
                    deeChat.notif[deeChat.activeChat] = undefined;
                }).done(function(){
                    deeChat.onMarkRead = false;
                });
            }
        },
        selectChat: function () {
            var $li = $(this);
            if (deeChat.activeChat != $li.data('id')) {
                deeChat.activeChat = $li.data('id');
                deeChat.activeChatName = $li.children('a').text();

                $('#list-account li').removeClass('active');
                $li.addClass('active');
                $li.removeClass('new-message');
                $('#messages').html('');

                deeChat.markRead();

                if (deeChat.msgs[deeChat.activeChat] === undefined) {
                    deeChat.msgs[deeChat.activeChat] = [];
                }
                for (var i in deeChat.msgs[deeChat.activeChat]) {
                    var row = deeChat.msgs[deeChat.activeChat][i];
                    var sender = row[0] ? deeChat.myName : deeChat.activeChatName;
                    $('<div>').append($('<strong>').text(sender + ' : '))
                        .append($('<span>').text(row[1]))
                        .appendTo('#messages');
                }
                $("#messages").scrollTop($("#messages")[0].scrollHeight);
            }
        },
        sendMessage: function () {
            if (deeChat.id == undefined || deeChat.activeChat == undefined || $('#inp-chat').val() == '') {
                return;
            }
            $.post('<?= Url::to(['chat']) ?>', {
                from: deeChat.id,
                to: deeChat.activeChat,
                message: $('#inp-chat').val(),
            }, function () {
                $('#inp-chat').val('');
            });
        }
    };

    $('#inp-account').keypress(function (e) {
        if (e.keyCode == 13) {
            deeChat.newAccount();
        }
    });
    $('#list-account').on('click', 'li', deeChat.selectChat);
    $('#send-chat').click(deeChat.sendMessage);
    $('#inp-chat').keypress(function (e) {
        if (e.keyCode == 13) {
            deeChat.sendMessage();
        }
    });
    $('#inp-chat').on('focus click keypress',function (e) {
        deeChat.markRead();
    });

    $('#btn-close').click(deeChat.close);