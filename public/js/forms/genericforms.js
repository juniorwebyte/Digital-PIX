/**
 *
 * GenericForms
 *
 * Interface.Forms.GenericForms page content scripts. Initialized from scripts.js file.
 *
 *
 */

class GenericForms {
  constructor() {
    // Initialization of the page plugins
    if (!jQuery().validate) {
      console.log('validate is undefined!');
      return;
    }
    this._initLogin();
    this._initSignUp();
    this._initContact();
    this._initPersonal();
    this._initAddress();
    this._initReservation();
  }

  // Filled stye login form with validation
  _initLogin() {
    const form = document.getElementById('loginForm');
    if (!form) {
      console.log('loginForm is null');
      return;
    }
    const validateOptions = {
      rules: {
        loginEmail: {
          required: true,
          email: true,
        },
        loginPassword: {
          required: true,
          minlength: 6,
          regex: /[a-z].*[0-9]|[0-9].*[a-z]/i,
        },
      },
      messages: {
        loginEmail: {
          email: 'Your email address must be in correct format!',
        },
        loginPassword: {
          minlength: 'Password must be at least {0} characters!',
          regex: 'Password must contain a letter and a number!',
        },
      },
    };
    jQuery(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (jQuery(form).valid()) {
        const formValues = {
          loginEmail: form.querySelector('[name="loginEmail"]').value,
          loginPassword: form.querySelector('[name="loginPassword"]').value,
        };
        console.log(formValues);
      }
    });
  }

  // Filled style signup form with a checkbox and validation
  _initSignUp() {
    const form = document.getElementById('signUpForm');
    if (!form) {
      console.log('signUpForm is null');
      return;
    }
    const validateOptions = {
      rules: {
        signUpName: {
          required: true,
          regex: /^[a-z\s]+$/i,
        },
        signUpEmail: {
          required: true,
          email: true,
        },
        signUpPassword: {
          required: true,
          minlength: 6,
          regex: /[a-z].*[0-9]|[0-9].*[a-z]/i,
        },
        signUpCheck: {
          required: true,
        },
      },
      messages: {
        signUpName: {
          regex: 'Only letters are accepted!',
        },
        signUpEmail: {
          email: 'Your email address must be in correct format!',
        },
        signUpPassword: {
          minlength: 'Password must be at least {0} characters!',
          regex: 'Password must contain a letter and a number!',
        },
        signUpCheck: {
          required: 'Please read and accept terms!',
        },
      },
    };
    jQuery(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (jQuery(form).valid()) {
        const formValues = {
          signUpName: form.querySelector('[name="signUpName"]').value,
          signUpEmail: form.querySelector('[name="signUpEmail"]').value,
          signUpPassword: form.querySelector('[name="signUpPassword"]').value,
          signUpCheck: form.querySelector('[name="signUpCheck"]').value,
        };
        console.log(formValues);
      }
    });
  }

  // Filled style contact form with a select2 and validation
  _initContact() {
    const form = document.getElementById('contactForm');
    if (!form) {
      console.log('contactForm is null');
      return;
    }

    // Department select2
    if (jQuery().select2) {
      jQuery('#contactDepartment').select2({minimumResultsForSearch: Infinity, placeholder: ''});
      jQuery('#contactDepartment').on('change', function () {
        jQuery(this).valid();
      });
    }

    const validateOptions = {
      rules: {
        contactName: {
          required: true,
          regex: /^[a-z\s]+$/i,
        },
        contactEmail: {
          required: true,
          email: true,
        },
        contactPhone: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10,
        },
        contactDepartment: {
          required: true,
        },
        contactMessage: {
          required: true,
        },
      },
      messages: {
        contactName: {
          regex: 'Only letters are accepted!',
        },
        contactEmail: {
          email: 'Your email address must be in correct format!',
        },
        contactPhone: {
          number: 'Only numbers are accepted!',
          minlength: 'Phone must be {0} characters!',
          maxlength: 'Phone must be {0} characters!',
        },
      },
    };
    jQuery(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (jQuery(form).valid()) {
        const formValues = {
          contactName: form.querySelector('[name="contactName"]').value,
          contactEmail: form.querySelector('[name="contactEmail"]').value,
          contactPhone: form.querySelector('[name="contactPhone"]').value,
          contactDepartment: form.querySelector('[name="contactDepartment"]').value,
          contactMessage: form.querySelector('[name="contactMessage"]').value,
        };
        console.log(formValues);
      }
    });
  }

  // Top label style personal detail form with gender select2, filling select2 and birthday date picker with validation
  _initPersonal() {
    const form = document.getElementById('personalForm');
    if (!form) {
      console.log('personalForm is null');
      return;
    }

    // Gender and filling select2
    if (jQuery().select2) {
      jQuery('#personalGender').select2({minimumResultsForSearch: Infinity, placeholder: ''});
      jQuery('#personalGender').on('change', function () {
        jQuery(this).valid();
      });

      jQuery('#personalFiling').select2({minimumResultsForSearch: Infinity, placeholder: ''});
      jQuery('#personalFiling').on('change', function () {
        jQuery(this).valid();
      });
    }

    // Birthday date picker
    if (jQuery().datepicker) {
      jQuery('#personalBirthday').datepicker({
        autoclose: true,
      });
      jQuery('#personalBirthday').on('change', function () {
        jQuery(this).valid();
      });
    }

    const validateOptions = {
      rules: {
        personalName: {
          required: true,
          regex: /^[a-z\s]+$/i,
        },
        personalEmail: {
          required: true,
          email: true,
        },
        personalPhone: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10,
        },
        personalGender: {
          required: true,
        },
        personalFiling: {
          required: true,
        },
        personalBirthday: {
          required: true,
        },
        personalSocialSecurityNumber: {
          required: true,
          regex: /^(?!000|666)[0-8][0-9]{2}-(?!00)[0-9]{2}-(?!0000)[0-9]{4}$/,
        },
      },
      messages: {
        personalName: {
          regex: 'Only letters are accepted!',
        },
        personalEmail: {
          email: 'Your email address must be in correct format!',
        },
        personalPhone: {
          number: 'Only numbers are accepted!',
          minlength: 'Id must be {0} characters!',
          maxlength: 'Id must be {0} characters!',
        },
        personalSocialSecurityNumber: {
          regex: 'Must be in correct format with dashes!',
        },
      },
    };
    jQuery(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (jQuery(form).valid()) {
        const formValues = {
          personalName: form.querySelector('[name="personalName"]').value,
          personalEmail: form.querySelector('[name="personalEmail"]').value,
          personalPhone: form.querySelector('[name="personalPhone"]').value,
          personalGender: form.querySelector('[name="personalGender"]').value,
          personalFiling: form.querySelector('[name="personalFiling"]').value,
          personalBirthday: form.querySelector('[name="personalBirthday"]').value,
          personalSocialSecurityNumber: form.querySelector('[name="personalSocialSecurityNumber"]').value,
        };
        console.log(formValues);
      }
    });
  }

  _initAddress() {
    const form = document.getElementById('addressForm');
    if (!form) {
      console.log('addressForm is null');
      return;
    }

    // State and city select2 initializations
    if (jQuery().select2) {
      this._initStateSelect();
      this._initCitySelectEmpty();
    }

    const validateOptions = {
      rules: {
        addressFirstName: {
          required: true,
          regex: /^[a-z\s]+$/i,
        },
        addressLastName: {
          required: true,
          regex: /^[a-z\s]+$/i,
        },
        addressCompany: {
          required: false,
        },
        addressPhone: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10,
        },
        addressState: {
          required: true,
        },
        addressCity: {
          required: true,
        },
        addressZipCode: {
          required: true,
        },
        addressDetail: {
          required: true,
        },
      },
      messages: {
        addressFirstName: {
          regex: 'Only letters are accepted!',
        },
        addressLastName: {
          regex: 'Only letters are accepted!',
        },
        addressPhone: {
          number: 'Only numbers are accepted!',
          minlength: 'Id must be {0} characters!',
          maxlength: 'Id must be {0} characters!',
        },
      },
    };
    jQuery(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (jQuery(form).valid()) {
        const formValues = {
          addressFirstName: form.querySelector('[name="addressFirstName"]').value,
          addressLastName: form.querySelector('[name="addressLastName"]').value,
          addressCompany: form.querySelector('[name="addressCompany"]').value,
          addressPhone: form.querySelector('[name="addressPhone"]').value,
          addressCountry: form.querySelector('[name="addressState"]').value,
          addressCity: form.querySelector('[name="addressCity"]').value,
          addressZipCode: form.querySelector('[name="addressZipCode"]').value,
          addressDetail: form.querySelector('[name="addressDetail"]').value,
        };
        console.log(formValues);
      }
    });
  }

  // State select with ajax data
  _initStateSelect() {
    var _this = this;
    this.stateSelect = jQuery('#addressState')
      .select2({
        ajax: {
          url: 'https://node-api.coloredstrategies.com/products',
          dataType: 'json',
          delay: 50,
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
        language: {
          searching: function () {
            return 'Retrieving...';
          },
        },
        theme: 'bootstrap4',
        placeholder: 'Search',
        escapeMarkup: function (markup) {
          return markup;
        },
        minimumInputLength: 0,
        minimumResultsForSearch: Infinity,
        templateResult: _this._formatResult,
        templateSelection: _this._formatResultSelection,
        dropdownCssClass: 'hide-search-searching',
      })
      .on('select2:select', function (e) {
        // Calling city select upon state change
        _this._initCitySelect();
      })
      .on('change', function () {
        jQuery(this).valid();
      });
  }

  // City select with ajax data
  _initCitySelect() {
    var _this = this;
    let stateValue = this.stateSelect.val();
    this.citySelect.select2('destroy');
    this.citySelect = jQuery('#addressCity')
      .select2({
        ajax: {
          url: 'https://node-api.coloredstrategies.com/products',
          dataType: 'json',
          delay: 50,
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
        language: {
          searching: function () {
            return 'Retrieving...';
          },
        },
        placeholder: 'Search',
        escapeMarkup: function (markup) {
          return markup;
        },
        minimumInputLength: 0,
        minimumResultsForSearch: Infinity,
        dropdownCssClass: 'hide-search-searching',
        templateResult: _this._formatResult,
        templateSelection: _this._formatResultSelection,
        disabled: false,
      })
      .on('change', function () {
        jQuery(this).valid();
      });
  }

  _initCitySelectEmpty() {
    // Calling city select empty for the first init
    this.citySelect = jQuery('#addressCity').select2({
      minimumResultsForSearch: Infinity,
      language: {
        searching: function () {
          return 'Retrieving...';
        },
        noResults: function () {
          return 'Please select your state!';
        },
      },
      minimumResultsForSearch: Infinity,
    });
  }

  // Formatting the select2 results
  _formatResult(result) {
    if (result.loading) return result.text;
    var markup = "<div class='clearfix'><div>" + result.Name + '</div>';
    return markup;
  }

  // Formatting the select2 selection
  _formatResultSelection(result) {
    return result.Name;
  }

  _initReservation() {
    const form = document.getElementById('reservationForm');
    if (!form) {
      return;
    }

    // Date range picker
    if (jQuery().datepicker) {
      jQuery('#reservationRangePicker').datepicker({
        weekStart: 1,
        autoclose: true,
      });
      jQuery('#reservationRangePicker input').on('change', function () {
        jQuery(this).valid();
      });
    }

    // Room, adult count and child count select2
    if (jQuery().select2) {
      jQuery('#reservationRoom').select2({minimumResultsForSearch: Infinity, placeholder: ''});
      jQuery('#reservationRoom').on('change', function () {
        jQuery(this).valid();
      });

      jQuery('#reservationAdults').select2({minimumResultsForSearch: Infinity, placeholder: ''});
      jQuery('#reservationAdults').on('change', function () {
        jQuery(this).valid();
      });

      jQuery('#reservationChildren').select2({minimumResultsForSearch: Infinity, placeholder: ''});
      jQuery('#reservationChildren').on('change', function () {
        jQuery(this).valid();
      });
    }

    const validateOptions = {
      rules: {
        reservationCheckIn: {
          required: true,
        },
        reservationCheckOut: {
          required: true,
        },
        reservationRoom: {
          required: true,
        },
        reservationAdults: {
          required: true,
        },
        reservationChildren: {
          required: true,
        },
      },
      messages: {},
    };
    jQuery(form).validate(validateOptions);
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      event.stopPropagation();
      if (jQuery(form).valid()) {
        const formValues = {
          reservationCheckIn: form.querySelector('[name="reservationCheckIn"]').value,
          reservationCheckOut: form.querySelector('[name="reservationCheckOut"]').value,
          reservationRoom: form.querySelector('[name="reservationRoom"]').value,
          reservationAdults: form.querySelector('[name="reservationAdults"]').value,
          reservationChildren: form.querySelector('[name="reservationChildren"]').value,
        };
        console.log(formValues);
      }
    });
  }
}
