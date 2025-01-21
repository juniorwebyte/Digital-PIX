/**
 *
 * DropzoneControls
 *
 * Interface.Forms.Controls.Dropzone page content scripts. Initialized from scripts.js file.
 *
 *
 */

class DropzoneControls {
  constructor() {
    // Initialization of the page plugins
    if (typeof Dropzone === 'undefined') {
      console.log('Dropzone is undefined!');
      return;
    }

    this._initImage();
    this._initTextFiles();
    this._initColumns();
    this._initFilled();
    this._initTopLabel();
    this._initFloatingLabel();
    this._initSingleImageUpload();
    this._initUploadedFiles();
  }

  // Basic image example
  _initImage() {
    if (document.querySelector('#dropzoneImage')) {
      new Dropzone('#dropzoneImage', {
        url: 'https://httpbin.org/pos',
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });
        },
        acceptedFiles: 'image/*',
        thumbnailWidth: 160,
        previewTemplate: DropzoneTemplates.previewTemplate,
      });
    }
  }

  // Only text files
  _initTextFiles() {
    if (document.querySelector('#dropzoneText')) {
      new Dropzone('#dropzoneText', {
        url: 'https://httpbin.org/post',
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });
        },
        acceptedFiles: '.txt, .doc, .pdf, .odt',
        thumbnailWidth: 160,
        previewTemplate: DropzoneTemplates.previewTemplate,
      });
    }
  }

  // Bootstrap columns
  _initColumns() {
    if (document.querySelector('#dropzoneColumns')) {
      new Dropzone('#dropzoneColumns', {
        url: 'https://httpbin.org/pos',
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });
        },
        acceptedFiles: 'image/*',
        thumbnailWidth: 600,
        thumbnailHeight: 430,
        previewTemplate: DropzoneTemplates.columnPreviewImageTemplate,
      });
    }
  }

  // Filled form example
  _initFilled() {
    if (document.querySelector('#dropzoneFilled')) {
      new Dropzone('#dropzoneFilled', {
        url: 'https://httpbin.org/post',
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });
        },
        thumbnailWidth: 160,
        previewTemplate: DropzoneTemplates.previewTemplate,
      });
    }
  }

  // Top label form example
  _initTopLabel() {
    if (document.querySelector('#dropzoneTopLabel')) {
      new Dropzone('#dropzoneTopLabel', {
        url: 'https://httpbin.org/post',
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });
        },
        thumbnailWidth: 160,
        previewTemplate: DropzoneTemplates.previewTemplate,
      });
    }
  }

  // Floating label form example
  _initFloatingLabel() {
    if (document.querySelector('#dropzoneFloatingLabel')) {
      new Dropzone('#dropzoneFloatingLabel', {
        url: 'https://httpbin.org/post',
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });
        },
        thumbnailWidth: 160,
        dictDefaultMessage: '',
        previewTemplate: DropzoneTemplates.previewTemplate,
      });
    }
  }

  // A single image uploader that is not dependant to Dropzone
  _initSingleImageUpload() {
    if (typeof SingleImageUpload !== 'undefined' && document.getElementById('singleImageUploadExample')) {
      const singleImageUpload = new SingleImageUpload(document.getElementById('singleImageUploadExample'), {
        fileSelectCallback: (image) => {
          console.log(image);
          // Upload the file with fetch method
          // let formData = new FormData();
          // formData.append("file", image.file);
          // fetch('/upload/image', { method: "POST", body: formData });
        },
      });
    }
  }

  // Showing earlier uploaded as mock files
  _initUploadedFiles() {
    if (document.querySelector('#dropzoneServerFiles')) {
      new Dropzone('#dropzoneServerFiles', {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 160,
        previewTemplate: DropzoneTemplates.previewTemplate,
        init: function () {
          this.on('success', function (file, responseText) {
            console.log(responseText);
          });

          this.on('addedfile', (file) => {
            // Showing file preview if it is not image
            if (file.type && !file.type.match(/image.*/)) {
              if (!file.documentPrev) {
                file.previewTemplate.classList.remove('dz-image-preview');
                file.previewTemplate.classList.add('dz-file-preview');
                file.previewTemplate.classList.add('dz-complete');
                file.documentPrev = true;
                this.emit('addedfile', file);
                this.removeFile(file);
              }
            }
          });

          // If you only have access to the original image sizes on your server,
          // and want to resize them in the browser:
          let mockFile1 = {name: 'bread.webp', size: 12842};
          this.displayExistingFile(mockFile1, 'img/product/small/product-1.webp');

          // Setting extra type parameter to show icon instead of thumbnail. It still needs to have a image for some reason.
          let mockFile2 = {name: 'cake.webp', size: 22354};
          this.displayExistingFile(mockFile2, 'img/product/small/product-2.webp');

          // Adding dz-started class to remove drop message
          this.element.classList.add('dz-started');

          // // If the thumbnail is already in the right size on your server:
          // let mockFile = { name: "Filename", size: 12345 };
          // let callback = null; // Optional callback when it's done
          // let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
          // let resizeThumbnail = false; // Tells Dropzone whether it should resize the image first
          // this.displayExistingFile(mockFile, "https://i.picsum.photos/id/959/120/120.jpg", callback, crossOrigin, resizeThumbnail);

          // If you use the maxFiles option, make sure you adjust it to the
          // correct amount:
          // let fileCountOnServer = 2; // The number of files already uploaded
          // this.options.maxFiles = myDropzone.options.maxFiles - fileCountOnServer;
        },
      });
    }
  }
}
