/**
 *
 * Shortcuts
 *
 * Interface.Plugins.Shortcuts page content scripts. Initialized from scripts.js file.
 *
 *
 */

class Shortcuts {
  constructor() {
    // Initialization of the page plugins
    if (typeof Mousetrap === 'undefined') {
      console.log('Mousetrap is null!');
      return;
    }

    this._initSingleKeys();
    this._initCombination();
    this._initOverride();
    this._initWrapping();
  }

  // Single key bindings
  _initSingleKeys() {
    Mousetrap.bind('s', function () {
      const searchModal = new bootstrap.Modal(document.getElementById('searchPagesModal'));
      searchModal.show();
    });

    Mousetrap.bind('o', function () {
      const settingshModal = new bootstrap.Modal(document.getElementById('settings'));
      settingshModal.show();
    });

    Mousetrap.bind(['d', 'l'], function () {
      const colorButton = document.getElementById('colorButton');
      if (colorButton) {
        colorButton.click();
      }
    });
  }

  // Combination of key bindings
  _initCombination() {
    Mousetrap.bind(['mod+shift+1'], function (event) {
      if (document.querySelector('#button1').classList.contains('active')) {
        document.querySelector('#button1').classList.remove('active');
      } else {
        document.querySelector('#button1').classList.add('active');
      }
    });
    Mousetrap.bind(['mod+shift+2'], function (event) {
      if (document.querySelector('#button2').classList.contains('active')) {
        document.querySelector('#button2').classList.remove('active');
      } else {
        document.querySelector('#button2').classList.add('active');
      }
    });
  }

  // Overriding browser default keys
  _initOverride() {
    if (document.querySelectorAll('#selectAllList li').length > 0) {
      Mousetrap.bind(['mod+a'], function (event) {
        event.preventDefault();
        document.querySelectorAll('#selectAllList li').forEach((el) => {
          el.classList.add('active');
        });
      });

      Mousetrap.bind(['mod+d'], function (event) {
        event.preventDefault();
        document.querySelectorAll('#selectAllList li').forEach((el) => {
          el.classList.remove('active');
        });
      });
    }
  }

  // Wrapping key bindings in a form
  _initWrapping() {
    if (document.querySelector('#wrapperForm')) {
      Mousetrap(document.querySelector('#wrapperForm')).bind(['mod+s'], function (event) {
        event.preventDefault();
        document.querySelector('#submitButton').setAttribute('disabled', true);
        document.querySelector('#submitButton .label').innerHTML = 'Saving...';
        document.querySelector('#submitButton .spinner-border').classList.remove('d-none');

        setTimeout(() => {
          document.querySelector('#submitButton').removeAttribute('disabled');
          document.querySelector('#submitButton .label').innerHTML = 'Save';
          document.querySelector('#submitButton .spinner-border').classList.add('d-none');
        }, 1000);
      });
    }
  }
}
