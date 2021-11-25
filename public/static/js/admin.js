var base = location.protocol+'//'+location.host;

$(document).ready(function(){
	editor_init('editor');
})

function editor_init(field){
	CKEDITOR.replace(field,{
		toolbar:[
		{name: 'clipboard', items:['Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo']},
		{name: 'basicstyles', items: ['Bold', 'Italic', 'BulltedList', 'Strike','image', 'Link', 'Unlink','Blockquote']},
		{name: 'document', items: ['CodeSnippet','EmojiPanel', 'Previw', 'Source']}
		]
	})
}