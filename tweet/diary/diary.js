$('#text').keyup(function(){
	var count = document.getElementById('count');
	var len = twttr.txt.getTweetLength($('#text').val());

	if (len <= 280){
		count.innerHTML = len + ' / 280';
	}else{
		count.innerHTML = '<font color="orange">' + len + '</font> / 280';
	}
});

var sendform = document.getElementById('sendform');
var send = document.getElementById('send');
send.onclick = function(){
        if (confirm('投稿してもよろしいですか？')){
                var id = document.createElement('input');
                id.setAttribute('name', 'comm_ids');
                id.setAttribute('type', 'hidden');
                id.setAttribute('value', JSON.stringify(comm_ids));
                sendform.appendChild(id);

		send.setAttribute('disabled', 'disabled');
		send.setAttribute('value', '送信中…');
		sendform.submit();
	}
};
