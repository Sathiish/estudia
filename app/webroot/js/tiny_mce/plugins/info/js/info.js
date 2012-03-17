//tinyMCEPopup.requireLangPack();

var InfoDialog = {
	init : function(ed) {
		tinyMCEPopup.resizeToInnerSize();
	},

	insert : function(file, title) {
		var ed = tinyMCEPopup.editor, dom = ed.dom;
                var el = ed.selection.getContent(); console.log(el);

//		tinyMCEPopup.execCommand('mceInsertContent', false, dom.createHTML('img', {
//			src : tinyMCEPopup.getWindowArg('plugin_url') + '/img/' + file,
//			alt : ed.getLang(title),
//			title : ed.getLang(title),
//			border : 0
//		}));

                var test = title.split("_");
                var test = test[0];

                tinyMCEPopup.execCommand('mceInsertContent', false, '<div class="rmq '+ test +'">' + el + '</div><p></p>');

		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(InfoDialog.init, InfoDialog);
