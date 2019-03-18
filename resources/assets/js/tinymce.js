// Import TinyMCE
import tinymce from 'tinymce/tinymce';

// A theme is also required
import 'tinymce/themes/silver/theme';
import 'tinymce/themes/mobile/theme';

// Any plugins you want to use has to be imported
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/textpattern';
import 'tinymce/plugins/textcolor';

// Initialize the app
tinymce.init({
  selector: '#tiny',
  branding: false,
  menubar: 'file edit view format textcolor',
	plugins: ['autosave', 'lists', 'paste', 'fullscreen', 'textpattern', 'textcolor'],
	toolbar: [ 'undo', 'bold', 'italic', 'styleselect', '|', 'align', 'forecolor' ],
  mobile: {
    theme: 'mobile',
    plugins: [ 'autosave', 'lists', 'paste' ],
    toolbar: [ 'undo', 'bold', 'italic', 'styleselect', 'textpattern' ]
  },
  style_formats: [
	  {
		title: 'Headings', items: [
		  { title: 'Heading 1', format: 'h1' },
		  { title: 'Heading 2', format: 'h2' },
		  { title: 'Heading 3', format: 'h3' },
		  { title: 'Heading 4', format: 'h4' },
		  { title: 'Heading 5', format: 'h5' },
		  { title: 'Heading 6', format: 'h6' }
		]
	  },

	  {
		title: 'Inline', items: [
		  { title: 'Bold', icon: 'bold', format: 'bold' },
		  { title: 'Italic', icon: 'italic', format: 'italic' },
		  { title: 'Underline', icon: 'underline', format: 'underline' },
		  { title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough' },
		  { title: 'Superscript', icon: 'superscript', format: 'superscript' },
		  { title: 'Subscript', icon: 'subscript', format: 'subscript' }
		]
	  },

	  {
		title: 'Blocks', items: [
		  { title: 'Paragraph', format: 'p' },
		  { title: 'Pre', format: 'pre' }
		]
	  },

	  {
		title: 'Alignment', items: [
		  { title: 'Left', icon: 'alignleft', format: 'alignleft' },
		  { title: 'Center', icon: 'aligncenter', format: 'aligncenter' },
		  { title: 'Right', icon: 'alignright', format: 'alignright' },
		  { title: 'Justify', icon: 'alignjustify', format: 'alignjustify' }
		]
	  }
	],
	init_instance_callback : function(editor) {
		console.log("Editor: " + editor.id + " is now initialized.");
	},
  textpattern_patterns: [
		{start: '{{$', end: '}}', styles: {color: 'blue'}, format:['bold'] },
		{start: '[[', end: ']]', styles: {color: 'blue'}, format:['bold'] }
  ]
});
