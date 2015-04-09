var MSG_NONE = 0;
var MSG_OK = 1;
var MSG_ERR = 2;
var MSG_LOGIN = 3;
var MSG_REDIRECT = 4;

function upvote(id) {
    $.getJSON(vote_url, {'id':id, 't':Math.random()}, function(out) {
        if (out.ret == MSG_LOGIN) {
            window.location.href = login_url;
        } else if (out.ret == MSG_ERR) {
            alert(out.msg);
        } else {
            $('#upvote-' + id + ' > a').addClass('disabled');
            $('#upvote-' + id + ' > a > small').text(out.data.votes);
        }
    });
}