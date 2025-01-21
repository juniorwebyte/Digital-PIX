/**
 *
 * FormWizards
 *
 * Interface.Forms.Wizard page content scripts. Initialized from scripts.js file.
 *
 *
 */

class FormWizards {
  constructor() {
    // Initialization of the page plugins
    if (typeof Wizard === 'undefined') {
      console.log('Wizard is undefined!');
      return;
    }
    this._initBasicWizard();
    this._initNoTopNavWizard();
    this._initLastStepEndWizard();
    this._initValidation();
  }

  _initBasicWizard() {
    if (document.getElementById('wizardBasic') !== null) {
      new Wizard(document.getElementById('wizardBasic'));
    }
  }

  _initNoTopNavWizard() {
    if (document.getElementById('wizardNoTopNav') !== null) {
      new Wizard(document.getElementById('wizardNoTopNav'), {topNav: false});
    }
  }

  _initLastStepEndWizard() {
    if (document.getElementById('wizardLastStepEnd') !== null) {
      new Wizard(document.getElementById('wizardLastStepEnd'), {lastEnd: true, topNav: false});
    }
  }

  _initValidation() {
    if (document.getElementById('wizardValidation') !== null) {
      this.wizardValidation = new Wizard(document.getElementById('wizardValidation'), {
        topNav: false,
        handleButtonClicks: false,
        lastEnd: true,
        onNextClick: this._validationNext.bind(this),
        onPrevClick: this._validationPrev.bind(this),
      });
    }
  }

  _validationNext() {
    const content = this.wizardValidation.getCurrentContent();
    const form = content.querySelector('form');

    if (this._checkValidation(form)) {
      this.wizardValidation.gotoNext();
    }
  }

  _validationPrev() {
    this.wizardValidation.gotoPrev();
  }

  _checkValidation(form) {
    if (jQuery().validate) {
      if (jQuery(form).valid()) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}
