/**
 * Permet d'ajouter des infobulles à l'éditeur visuel
 * Author: cayoul
 */

(function() {
	tinymce.create('tinymce.plugins.infoPlugin', {
		init : function(ed, url) {
			ed.addCommand('ajout_infobulle', function(){
                            ed.windowManager.open({
					file : url + '/info.htm',
					width : 250 + parseInt(ed.getLang('info.delta_width', 0)),
					height : 160 + parseInt(ed.getLang('info.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
                        });
                        
                        ed.addButton('infobulle', {
                            title   :   'Ajouter une infobulle',
                            image   :   '/js/tiny_mce/plugins/info/img/information_tn.png',
                            cmd     :   'ajout_infobulle'
                        });
                        
                        
		},

		getInfo : function() {
			return {
				longname : 'Info',
				author : 'cayoul',
				authorurl : 'http://zeschool.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('info', tinymce.plugins.infoPlugin);
})();