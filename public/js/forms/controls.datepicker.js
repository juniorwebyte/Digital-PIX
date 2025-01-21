/**
 *
 * DatePickerControls
 *
 * Interface.Forms.Controls.DatePicker page content scripts. Initialized from scripts.js file.
 *
 *
 */

class DatePickerControls {
  constructor() {
    // Initialization of the page plugins
    if (!jQuery().datepicker) {
      console.log('datepicker is null!');
      return;
    }

    this._initBasic();
    this._initAutoClose();
    this._initOrientation();
    this._initValue();
    this._initFormat();
    this._initLocale();
    this._initInputGroup();
    this._initRange();
    this._initEmbed();
    this._initTopLabel();
    this._initFilled();
    this._initFloatingLabel();
  }

  _initBasic() {
    jQuery('#datePickerBasic').datepicker();
  }

  _initAutoClose() {
    jQuery('#datePickerAutoClose').datepicker({
      autoclose: true,
    });
  }

  _initOrientation() {
    jQuery('.date-picker-orientation').each(function () {
      jQuery(this).datepicker({
        orientation: jQuery(this).data('orientation'),
        autoclose: true,
      });
    });
  }

  _initValue() {
    jQuery('#datePickerValue').datepicker({
      autoclose: true,
    });
  }

  _initFormat() {
    jQuery('#datePickerFormat').datepicker({
      format: 'dd.mm.yyyy',
      autoclose: true,
    });
  }

  _initLocale() {
    jQuery('#datePickerLocale').datepicker({
      language: 'pt-BR',
      format: 'dd/mm/yyyy',
      autoclose: true,
    });
  }

  _initInputGroup() {
    jQuery('#datePickerInputGroup').datepicker({
      autoclose: true,
    });
  }

  _initRange() {
    jQuery('#datePickerRange').datepicker({
      weekStart: 1,
    });
  }

  _initEmbed() {
    jQuery('#datePickerEmbed').datepicker();
  }

  _initTopLabel() {
    jQuery('#datePickerTopLabel').datepicker({
      autoclose: true,
    });
  }

  _initFilled() {
    jQuery('#datePickerFilled').datepicker({
      autoclose: true,
    });
  }

  _initFloatingLabel() {
    jQuery('#datePickerFloatingLabel').datepicker({
      autoclose: true,
    });
  }
}
