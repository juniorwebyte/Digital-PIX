/**
 *
 * EditorControls
 *
 * Interface.Forms.Controls.Editor page content scripts. Initialized from scripts.js file.
 *
 *
 */

class EditorControls {
  constructor() {
    // Initialization of the page plugins
    if (typeof Quill === 'undefined') {
      console.log('Quill is undefined!');
      return;
    }

    this.quillToolbarOptions = [
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote', 'code-block'],
      [{list: 'ordered'}, {list: 'bullet'}],
      [{indent: '-1'}, {indent: '+1'}],
      [{size: ['small', false, 'large', 'huge']}],
      [{header: [1, 2, 3, 4, 5, 6, false]}],
      [{font: []}],
      [{align: []}],
      ['clean'],
    ];

    this.quillBubbleToolbarOptions = [
      ['bold', 'italic', 'underline', 'strike'],
      [{header: [1, 2, 3, 4, 5, 6, false]}],
      [{list: 'ordered'}, {list: 'bullet'}],
      [{align: []}],
    ];

    this._initStandardEditor();
    this._initQuillBubble();
    this._initQuillFilled();
    this._initQuillTopLabel();
    this._initQuillFloatingLabel();
  }

  _initStandardEditor() {
    if (document.getElementById('quillEditor')) {
      new Quill('#quillEditor', {
        modules: {
          toolbar: this.quillToolbarOptions,
          active: {},
        },
        theme: 'snow',
      });
    }
  }

  _initQuillBubble() {
    if (document.getElementById('quillEditorBubble')) {
      new Quill('#quillEditorBubble', {
        modules: {toolbar: this.quillBubbleToolbarOptions, active: {}},
        theme: 'bubble',
      });
    }
  }

  _initQuillFilled() {
    if (document.getElementById('quillEditorFilled')) {
      new Quill('#quillEditorFilled', {
        modules: {toolbar: this.quillBubbleToolbarOptions, active: {}},
        theme: 'bubble',
        placeholder: 'Editor',
      });
    }
  }

  _initQuillTopLabel() {
    if (document.getElementById('quillEditorTopLabel')) {
      new Quill('#quillEditorTopLabel', {
        modules: {toolbar: this.quillBubbleToolbarOptions, active: {}},
        theme: 'bubble',
      });
    }
  }

  _initQuillFloatingLabel() {
    if (document.getElementById('quillEditorFloatingLabel')) {
      const floatingQuill = new Quill('#quillEditorFloatingLabel', {
        modules: {toolbar: this.quillBubbleToolbarOptions, active: {}},
        theme: 'bubble',
      });
      floatingQuill.on('editor-change', function (eventName, ...args) {
        if (floatingQuill.getLength() > 1) {
          document.getElementById('quillEditorFloatingLabel').classList.add('full');
        } else {
          document.getElementById('quillEditorFloatingLabel').classList.remove('full');
        }
      });
    }
  }
}
