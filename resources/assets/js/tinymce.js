// Import TinyMCE
import tinymce from 'tinymce/tinymce';

// A theme is also required
import 'tinymce/themes/silver/theme';
import 'tinymce/themes/mobile/theme';

// Any plugins you want to use has to be imported
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/link';

// Initialize the app
tinymce.init({
  selector: '#tiny',
  branding: false,
  menubar: 'edit insert view format',
  plugins: ['autosave', 'lists', 'paste', 'link'],
  mobile: {
    theme: 'mobile',
    plugins: [ 'autosave', 'lists', 'paste', 'autolink' ],
    toolbar: [ 'undo', 'bold', 'italic', 'styleselect' ]
  }
});
