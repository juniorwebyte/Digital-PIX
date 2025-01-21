/**
 *
 * SpinnerControls
 *
 * Interface.Forms.Controls.InputSpinner page content scripts. Initialized from scripts.js file.
 *
 *
 */

class SpinnerControls {
  constructor() {
    // Initialization of the page plugins
    if (!jQuery().spinner) {
      console.log('spinner is null!');
      return;
    }

    this._initQuantitySpinner();
    this._initRest();
  }

  // An example to call from js, rest of the examples and settings provided via data attributes
  _initQuantitySpinner() {
    $('#spinnerQuantity').spinner();
  }

  _initRest() {
    // Rest of the examples are initialized via data-trigger="spinner" attribute.
  }
}
