/*
* Use to generate buttons
* tinyMCe 4.0 update and wordpre 3.9
* @since 1.0.0
* @return shortcoder buttons 
*/
(function() {

    tinymce.PluginManager.add('hcshortcodes', function( editor, url )
    {
        // Add a button that opens a window
        editor.addButton( 'hcshortcodes', {
            title : 'Truncate Content', // title of the button
            text : '',
            icon: '',
			classes: 'btn hc-shortcode-button',
            onclick: function() {
                // triggers the thickbox
				var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
				W = W - 80;
				H = H - 115;
				tb_show( 'Truncate Content Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=hc-insert-form' );
            }

        } );

    });

    // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		var form = jQuery('<div id="hc-insert-form"><table id="hc-insert-table" class="form-table">\
			<tr>\
				<td width="20%"><label for="hc-insert-speed">Speed</label></td>\
				<td width="20%"><input type="text" name="hc-speed" id="hc-insert-speed" value="100" /> </td>\
                <td width="60%"><small>This option determines how much speed will the content toggles.</small></td>\
			</tr>\
            <tr>\
				<td width="20%"><label for="hc-insert-maxheight">Height</label></td>\
				<td width="20%"><input type="text" name="hc-maxheight" id="hc-insert-maxheight" value="320" /> </td>\
                <td width="60%"><small>This option display the visible content for readers.</small></td>\
			</tr>\
            <tr>\
				<td width="20%"><label for="hc-insert-morelink">Open Toggle</label></td>\
				<td width="20%"><input type="text" name="hc-morelink" id="hc-insert-morelink" value="Read More" /> </td>\
                <td width="60%"><small>This option display the text to toggle all visible content</small></td>\
			</tr>\
            <tr>\
				<td width="20%"><label for="hc-insert-lesslink">Close Toggle</label></td>\
                <td width="20%"><input type="text" name="hc-lesslink" id="hc-insert-lesslink" value="Close" /> </td>\
                <td width="60%"><small>This option display the text to close toggle all visible content</small></td>\
			</tr>\
            <tr>\
				<td width="20%"><label for="hc-insert-embedcss">Embed CSS</label></td>\
                <td width="80%" colspan=2><textarea name="hc-embedcss" id="hc-insert-embedcss" style="width:100%;font-size:12px;padding:5px;" rows=10></textarea>\
                <small>The CSS intended for the content which is visible to the readers.</small>\
                <br/><small>sample : border:1px solid #ececec; padding:10px; border-radius:10px;</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="hc-insert-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

		var table = form.find('table');
		form.appendTo('body').hide();

		// handles the click event of the submit button
		form.find('#hc-insert-submit').on('click', function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
				'speed' : 100,
                'maxheight' : 320, 
                'morelink' : 'Read More',
                'lesslink' : 'Close', 
                'embedcss' : ''              
			};
			var shortcode = '[truncate_content';

			for( var index in options) {
			    
				var value = table.find('#hc-insert-' + index).val();
                console.log(options[index] + ' == ' + value)
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
                else
                    if ( options[index] !== '' )
                    shortcode += ' ' + index + '="' + options[index] + '"';    
			}

			shortcode += '][/truncate_content]';

			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

			// closes Thickbox
			tb_remove();
		});
    });
})();