<?php 
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');

	if(!isset($shortcodesAnyGuide))
		$shortcodesAnyGuide = new Anyguide_TinyMCESelector();
	
	global $wpdb;

$anyguide_snippets_arr=$wpdb->get_results($wpdb->prepare( "SELECT id,title FROM ".$wpdb->prefix."anyguide_short_code WHERE status=%d  ORDER BY id DESC",1),ARRAY_A );
// 		print_r($anyguide_snippets_arr);
if(count($anyguide_snippets_arr)==0)
die;

if(floatval(get_bloginfo('version'))>=3.9) {
	?>
	(function() {
 	tinymce.PluginManager.add('<?php echo $shortcodesAnyGuide->buttonName; ?>', function( editor, url ) {
		editor.addButton( '<?php echo $shortcodesAnyGuide->buttonName; ?>', {
			title: 'Insert Anyguide Snippet',
			type: 'menubutton',
			icon: 'icon anyguide-icon',
			menu: [
				<?php foreach ($anyguide_snippets_arr as $key=>$val) { ?>            
				{
					text: '<?php echo addslashes($val['title']); ?>',
					value: '[anyguide snippet="<?php echo addslashes($val['title']); ?>"]',
					onclick: function() {
						editor.insertContent(this.value());
					}
				},
				<?php } ?>           		
			]
		});
  });
})();

<?php } else { 
	$anyguide_snippets = array(
		'title'   =>'Insert Anyguide Snippet',
		'url'	    => plugins_url('assets/images/logo.png', dirname(__FILE__)),
		'anyguide_snippets' => $anyguide_snippets_arr
	);
?>

var tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?> =<?php echo json_encode($anyguide_snippets) ?>;


(function() {
	//******* Load plugin specific language pack

	tinymce.create('tinymce.plugins.<?php echo $shortcodesAnyGuide->buttonName; ?>', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {

			tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.insert = function(){
				if(this.v && this.v != ''){
					tinymce.execCommand('mceInsertContent', false, '[anyguide snippet="'+tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.anyguide_snippets[this.v]['title']+'"]');
				}
			};
			
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			if(n=='<?php echo $shortcodesAnyGuide->buttonName; ?>'){
				var c = cm.createSplitButton('<?php echo $shortcodesAnyGuide->buttonName; ?>', {
					title : tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.title,
					image :  tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.url,
					onclick : tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.insert
				});

				// Add some values to the list box
				c.onRenderMenu.add(function(c, m){
					for (var id in tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.anyguide_snippets){
						m.add({
							v : id,
							title : tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.anyguide_snippets[id]['title'],
							onclick : tinymce_<?php echo $shortcodesAnyGuide->buttonName; ?>.insert
						});
					}
				});


				// Return the new listbox instance
				return c;
			}

			return null;
		},
	});

	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesAnyGuide->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesAnyGuide->buttonName; ?>);
})();

<?php } ?>