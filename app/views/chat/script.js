yii.dChat = (function () {
    var local = {
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
            $.post(pub.newAccountUrl,
                {
                    name: $('#inp-account').val()
                },
            function (r) {
                if (r.id != local.id) {
                    if (local.sseObj !== undefined) {
                        local.sseObj.close();
                        local.sseObj = undefined;
                    }
                    local.id = r.id;
                    $('#inp-account').val('').hide();
                    $('#my-info').show();
                    $('#my-name').text(r.name);
                    local.myName = r.name;
                    local.sseObj = new EventSource(r.url);
                    local.sseObj.addEventListener('account', local.onAccount);
                    local.sseObj.addEventListener('chat', local.onChat);
                    local.sseObj.addEventListener('notif', local.onNotif);
                }
            });
        },
        close: function () {
            $('#inp-account').show();
            $('#my-info').hide();
            local.id = undefined;
            local.activeChat = undefined;
            if (local.sseObj !== undefined) {
                local.sseObj.close();
                local.sseObj = undefined;
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
                if (acc.id == local.activeChat) {
                    $li.addClass('active');
                }
                $li.appendTo($ul);
            }
        },
        onChat: function (e) {
            var data = JSON.parse(e.data);
            var msgs = data.msgs;
            local.time = data.time;
            for (var accId in msgs) {
                if (local.msgs[accId] === undefined) {
                    local.msgs[accId] = [];
                }
                for (var i in msgs[accId]) {
                    var row = msgs[accId][i];
                    local.msgs[accId].push(row);
                    if (local.activeChat == accId) {
                        var sender = row[0] ? local.myName : local.activeChatName;
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
                local.notif[row.from] = true;
            }
        },
        markRead: function () {
            if (!local.onMarkRead && local.notif[local.activeChat] !== undefined) {
                local.onMarkRead = true;
                $.post(pub.markReadUrl, {
                    from: local.activeChat,
                    to: local.id,
                    time: local.time
                }, function () {
                    local.notif[local.activeChat] = undefined;
                }).done(function () {
                    local.onMarkRead = false;
                });
            }
        },
        selectChat: function () {
            var $li = $(this);
            if (local.activeChat != $li.data('id')) {
                local.activeChat = $li.data('id');
                local.activeChatName = $li.children('a').text();
                $('#list-account li').removeClass('active');
                $li.addClass('active');
                $li.removeClass('new-message');
                $('#messages').html('');
                local.markRead();
                if (local.msgs[local.activeChat] === undefined) {
                    local.msgs[local.activeChat] = [];
                }
                for (var i in local.msgs[local.activeChat]) {
                    var row = local.msgs[local.activeChat][i];
                    var sender = row[0] ? local.myName : local.activeChatName;
                    $('<div>').append($('<strong>').text(sender + ' : '))
                        .append($('<span>').text(row[1]))
                        .appendTo('#messages');
                }
                $("#messages").scrollTop($("#messages")[0].scrollHeight);
            }
        },
        sendMessage: function () {
            if (local.id == undefined || local.activeChat == undefined || $('#inp-chat').val() == '') {
                return;
            }
            $.post(pub.chatUrl, {
                from: local.id,
                to: local.activeChat,
                message: $('#inp-chat').val(),
            }, function () {
                $('#inp-chat').val('');
            });
        }
    };

    var pub = {
        chatUrl: undefined,
        markReadUrl: undefined,
        newAccountUrl: undefined,
        initProperty: function (props) {
            for (var i in props) {
                pub[i] = props[i];
            }
        },
        init: function () {
            $('#inp-account').keypress(function (e) {
                if (e.keyCode == 13) {
                    local.newAccount();
                }
            });
            $('#list-account').on('click', 'li', local.selectChat);
            $('#send-chat').click(local.sendMessage);
            $('#inp-chat').keypress(function (e) {
                if (e.keyCode == 13) {
                    local.sendMessage();
                }
            });
            $('#inp-chat').on('focus click keypress', function (e) {
                local.markRead();
            });
            $('#btn-close').click(local.close);
        }
    };
    return pub;
})();