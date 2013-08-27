
addComment = {
	moveForm : function(commId, parentId, respondId, postId,  commentId) {

        var disA = '';
        var disB = '';

        if(respondId == 'redaktor'){
            disA = '';
            disB = 'none';
        } else if(respondId == 'respond'){
            disA = 'none';
            disB = '';
        }

		var t = this, div, comm = t.I(commId), respond = t.I(respondId), redaktor = t.I('redaktor'), respondR = t.I('respond'),
            cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID'), comment = t.I('news_id'),
            parentR = t.I('comment_parent_r'), postR = t.I('comment_post_ID_r'), commentR = t.I('news_id_r');

		if ( ! comm || ! respond || ! cancel || ! parent )
			return;

		t.respondId = respondId;
		postId = postId || false;

		if ( ! t.I('wp-temp-form-div') ) {
			div = document.createElement('div');
			div.id = 'wp-temp-form-div';
			div.style.display = 'none';
			respond.parentNode.insertBefore(div, respond);
		}

		comm.parentNode.insertBefore(respond, comm.nextSibling);
		if ( post && postId )
		post.value = postId;
		parent.value = parentId;
        comment.value = commentId;

        postR.value = postId;
        parentR.value = parentId;
        commentR.value = commentId;

		cancel.style.display = '';

        redaktor.style.display = disA;
        respondR.style.display = disB;


		cancel.onclick = function() {
			var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

			if ( ! temp || ! respond )
				return;

			t.I('comment_parent').value = '0';
			temp.parentNode.insertBefore(respond, temp);
			temp.parentNode.removeChild(temp);
			this.style.display = 'none';
			this.onclick = null;
			return false;
		};

		try { t.I('comment').focus(); }
		catch(e) {}

		return false;
	},

	I : function(e) {
		return document.getElementById(e);
	}
};
