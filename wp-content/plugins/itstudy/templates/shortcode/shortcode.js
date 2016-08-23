(function() {
	tinymce.create('tinymce.plugins.Addshortcodes', {
		init : function(ed, url) {
		
			//Add Itstudy shortcodes button
			ed.addButton('Itstudy', {
				title : 'Add Itstudy shortcodes',
				cmd : 'alc_itstudy',
				image : url + '/images/badge.png'
			});
			ed.addCommand('alc_itstudy', function() {
				ed.windowManager.open({file : url + '/ui.php?page=itstudy',  width : 604 ,	height : 520 ,	inline : 1});
			});	
		},
		getInfo : function() {
			return {
				longname : "Question Shortcode",
				author : 'Itstudy',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('ItstudyShortcodes', tinymce.plugins.Addshortcodes);	
	
})();

