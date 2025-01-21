/**
 *
 * Select2Controls
 *
 * Interface.Forms.Controls.Select2 page content scripts. Initialized from scripts.js file.
 *
 *
 */

class Select2Controls {
  constructor() {
    // Initialization of the page plugins
    if (!jQuery().select2) {
      console.log('select2 is null!');
      return;
    }

    this._initSelect2Basic();
    this._initSelect2Multiple();
    this._initTags();
    this._initSearchHidden();
    this._initAjax();
    this._initDataApi();
    this._initTemplating();
    this._initTopLabel();
    this._initFilled();
    this._initFloatingLabel();
  }

  // Basic single select2
  _initSelect2Basic() {
    jQuery('.select2Basic').select2({placeholder: ''});
  }

  // Basic multiple select2
  _initSelect2Multiple() {
    jQuery('#select2Multiple').select2({});
  }

  // Basic select2 tags
  _initTags() {
    jQuery('#select2Tags').select2({});
  }

  // No search field
  _initSearchHidden() {
    jQuery('#select2SearchHidden').select2({minimumResultsForSearch: Infinity, placeholder: ''});
  }

  // Ajax api connection
  _initAjax() {
    jQuery('#select2Ajax').select2({
      ajax: {
        url: 'https://node-api.coloredstrategies.com/products',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            search: {value: params.term},
            page: params.page,
          };
        },
        processResults: function (data, page) {
          return {
            results: data.data,
          };
        },
        cache: true,
      },
      placeholder: 'Search',
      escapeMarkup: function (markup) {
        return markup;
      },
      minimumInputLength: 1,
      templateResult: function formatResult(result) {
        if (result.loading) return result.text;
        var markup = '<div class="clearfix"><div>' + result.Name + '</div>';
        if (result.Description) {
          markup += '<div class="text-muted">' + result.Description + '</div>';
        }
        return markup;
      },
      templateSelection: function formatResultSelection(result) {
        return result.Name;
      },
    });
  }

  // Using data- attributes
  _initDataApi() {
    jQuery('#selectDataApi').select2({minimumResultsForSearch: Infinity, placeholder: ''});
  }

  // Basic templating with circles
  _initTemplating() {
    jQuery('#selectTemplating').select2({
      minimumResultsForSearch: Infinity,
      placeholder: '',
      templateSelection: function formatText(item) {
        if (jQuery(item.element).val()) {
          return jQuery(
            '<div><span class="align-middle d-inline-block option-circle me-2 rounded-xl ' +
              jQuery(item.element).data('class') +
              '"></span> <span class="align-middle d-inline-block lh-1">' +
              item.text +
              '</span></div>',
          );
        }
      },
      templateResult: function formatText(item) {
        if (jQuery(item.element).val()) {
          return jQuery(
            '<div><span class="align-middle d-inline-block option-circle me-2 rounded-xl ' +
              jQuery(item.element).data('class') +
              '"></span> <span class="align-middle d-inline-block lh-1">' +
              item.text +
              '</span></div>',
          );
        }
      },
    });
  }

  // Top label input select2
  _initTopLabel() {
    jQuery('#selectTopLabel').select2({minimumResultsForSearch: Infinity, placeholder: ''});
  }

  // Filled input select2
  _initFilled() {
    jQuery('#selectFilled').select2({minimumResultsForSearch: Infinity});
  }

  // Floating label input select2
  _initFloatingLabel() {
    const _this = this;
    jQuery('#selectFloating')
      .select2({minimumResultsForSearch: Infinity, placeholder: ''})
      .on('select2:open', function (e) {
        jQuery(this).addClass('show');
      })
      .on('select2:close', function (e) {
        _this._addFullClassToSelect2(this);
        jQuery(this).removeClass('show');
      });
    this._addFullClassToSelect2(jQuery('#selectFloating'));
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
