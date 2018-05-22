layui.use(['form', 'layer', 'jquery', 'element', 'util'], function() {
    var form = layui.form,
        layer = layui.layer,
        element = layui.element,
        util = layui.util,
        $ = layui.jquery;
    $('.login_logout').click(function() {
        loading = layer.load(2, {
            shade: [0.2, '#000']
        });
        var url = $(this).data('url');
        var locationUrl = $(this).attr('location-url');
        $.getJSON(url, function(data) {
            if (data.code == 200) {
                layer.close(loading);
                layer.msg(data.msg, { icon: 1, time: 1000 }, function() {
                    location.href = locationUrl;
                });
            } else {
                layer.close(loading);
                layer.msg(data.msg, { icon: 2, anim: 6, time: 1000 });
            }
        });
    });

    $(window).on('scroll',function() {
        var scroll = $(window).scrollTop();
        if (scroll > 5) {
            $(".fly-header").addClass("shadow");
        }else{
            $(".fly-header").removeClass("shadow");
        }
    });

    //返回顶部图标
    util.fixbar({
        bar1: '&#xe642;',
        bgcolor: '#42c1f1',
        click: function(type) {
            if (type === 'bar1') {
                location.href = '/forum/post/add.html';
                //layer.msg('打开 index.js，开启发表新帖的路径');

            }
        }
    });
})