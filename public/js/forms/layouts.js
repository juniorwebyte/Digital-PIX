/**
 *
 * FormLayouts
 *
 * Interface.Forms.Layouts page content scripts. Initialized from scripts.js file.
 *
 *
 */

class FormLayouts {
  constructor() {
    // Initialization of the page plugins

    this._initBasicForm();
    this._initTopLabelForm();
    this._initFloatingLabelForm();
    this._initFilledForm();
  }

  // Basic form initialization
  _initBasicForm() {
    if (jQuery().select2) {
      jQuery('#selectBasic').select2({minimumResultsForSearch: Infinity, placeholder: ''});
    }
    if (typeof Tagify !== 'undefined') {
      if (document.querySelector('#tagBasic') !== null) {
        new Tagify(document.querySelector('#tagBasic'));
      }
    }
    if (jQuery().datepicker) {
      jQuery('#datePickerBasic').datepicker({
        autoclose: true,
      });
    }
  }

  // Top label form initialization
  _initTopLabelForm() {
    if (jQuery().select2) {
      jQuery('#select2TopLabel').select2({minimumResultsForSearch: Infinity, placeholder: ''});
    }
    if (typeof Tagify !== 'undefined') {
      if (document.querySelector('#tagsTopLabel') !== null) {
        new Tagify(document.querySelector('#tagsTopLabel'));
      }
    }
    if (jQuery().datepicker) {
      jQuery('#dateTopLabel').datepicker({
        autoclose: true,
      });
    }
  }

  // Floating label form initialization
  _initFloatingLabelForm() {
    const _this = this;
    if (jQuery().select2) {
      jQuery('#select2FloatingLabel')
        .select2({minimumResultsForSearch: Infinity, placeholder: ''})
        .on('select2:open', function (e) {
          jQuery(this).addClass('show');
        })
        .on('select2:close', function (e) {
          _this._addFullClassToSelect2(this);
          jQuery(this).removeClass('show');
        });
      this._addFullClassToSelect2(jQuery('#select2FloatingLabel'));
    }
    if (typeof Tagify !== 'undefined') {
      if (document.querySelector('#tagsFloatingLabel') !== null) {
        new Tagify(document.querySelector('#tagsFloatingLabel'));
      }
    }
    if (jQuery().datepicker) {
      jQuery('#datePickerFloatingLabel')
        .datepicker({
          autoclose: true,
        })
        .on('show', function (e) {
          jQuery(this).addClass('show');
        });
    }
  }

  // Filled form initialization
  _initFilledForm() {
    if (jQuery().select2) {
      jQuery('#select2Filled').select2({minimumResultsForSearch: Infinity});
    }
    if (typeof Tagify !== 'undefined') {
      if (document.querySelector('#tagsFilled') !== null) {
        new Tagify(document.querySelector('#tagsFilled'));
      }
    }
    if (jQuery().datepicker) {
      jQuery('#datePickerFilled').datepicker({
        autoclose: true,
      });
    }
  }

  // Helper method for floating label Select2
  _addFullClassToSelect2(el) {
    if (jQuery(el).val() !== '' && jQuery(el).val() !== null) {
      jQuery(el).parent().find('.select2.select2-container').addClass('full');
    } else {
      jQuery(el).parent().find('.select2.select2-container').removeClass('full');
    }
  }
}
