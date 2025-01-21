/**
 *
 * SliderControls
 *
 * Interface.Forms.Controls.Slider page content scripts. Initialized from scripts.js file.
 *
 *
 */

class SliderControls {
  constructor() {
    // Initialization of the page plugins
    if (typeof noUiSlider === 'undefined') {
      console.log('noUiSlider is undefined!');
      return;
    }
    this._initHorizontalBasic();
    this._initSliderDisabled();
    this._initSliderVerticalBasic();
    this._initSliderTooltip();
    this._initSliderTooltipVertical();
    this._initSliderSteps();
    this._initSliderRound();
    this._initPips();
    this._initPipsVertical();
    this._initTopLabel();
    this._initFilled();
    this._initFloatingLabel();
  }

  // Basic horizontal slider
  _initHorizontalBasic() {
    if (document.getElementById('sliderHorizontalBasic')) {
      noUiSlider.create(document.getElementById('sliderHorizontalBasic'), {
        start: [20],
        connect: [true, false],
        range: {min: 0, max: 100},
      });
    }
  }

  // Disabled horizontal slider
  _initSliderDisabled() {
    if (document.getElementById('sliderDisabled')) {
      noUiSlider.create(document.getElementById('sliderDisabled'), {
        start: [20],
        connect: [true, false],
        range: {min: 0, max: 100},
      });
    }
  }

  // Basic vertical slider
  _initSliderVerticalBasic() {
    if (document.getElementById('sliderVerticalBasic')) {
      noUiSlider.create(document.getElementById('sliderVerticalBasic'), {
        start: [20],
        orientation: 'vertical',
        connect: [true, false],
        direction: 'rtl',
        range: {
          min: 0,
          max: 100,
        },
      });
    }
  }

  // Horizontal slider with tooltips
  _initSliderTooltip() {
    if (document.getElementById('sliderTooltip')) {
      noUiSlider.create(document.getElementById('sliderTooltip'), {
        start: [20, 80],
        connect: true,
        tooltips: [true, true],
        range: {
          min: 0,
          max: 100,
        },
      });
    }
  }

  // Vertical slider with tooltips
  _initSliderTooltipVertical() {
    if (document.getElementById('sliderTooltipVertical')) {
      noUiSlider.create(document.getElementById('sliderTooltipVertical'), {
        start: [20, 80],
        connect: true,
        orientation: 'vertical',
        tooltips: [true, true],
        direction: 'rtl',
        range: {
          min: 0,
          max: 100,
        },
      });
    }
  }

  // Slider with steps and range
  _initSliderSteps() {
    if (document.getElementById('sliderStep')) {
      noUiSlider.create(document.getElementById('sliderStep'), {
        start: [4000],
        step: 1000,
        tooltips: true,
        connect: [true, false],
        range: {
          min: [1000],
          max: [10000],
        },
      });
    }
  }

  // Slider with rounded numbers
  _initSliderRound() {
    if (document.getElementById('sliderRound')) {
      noUiSlider.create(document.getElementById('sliderRound'), {
        start: [4000],
        step: 1000,
        tooltips: true,
        connect: [true, false],
        range: {
          min: [1000],
          max: [10000],
        },
        format: {
          // 'to' the formatted value. Receives a number.
          to: function (value) {
            return Math.round(value);
          },
          // 'from' the formatted value.
          // Receives a string, should return a number.
          from: function (value) {
            return Number(value);
          },
        },
      });
    }
  }

  // Horizontal slider with pips
  _initPips() {
    if (document.getElementById('sliderPips')) {
      noUiSlider.create(document.getElementById('sliderPips'), {
        start: [10, 90],
        step: 10,
        tooltips: true,
        connect: true,
        range: {
          min: 0,
          max: 100,
        },
        pips: {
          mode: 'steps',
          density: 5,
          format: {
            // 'to' the formatted value. Receives a number.
            to: function (value) {
              return '$ ' + value;
            },
            // 'from' the formatted value.
            // Receives a string, should return a number.
            from: function (value) {
              return Number(value.replace('$', ''));
            },
          },
        },
        format: {
          // 'to' the formatted value. Receives a number.
          to: function (value) {
            return '$ ' + value;
          },
          // 'from' the formatted value.
          // Receives a string, should return a number.
          from: function (value) {
            return Number(value.replace('$', ''));
          },
        },
      });
    }
  }

  // Vertical slider with pips
  _initPipsVertical() {
    if (document.getElementById('sliderPips')) {
      noUiSlider.create(document.getElementById('sliderPipsVertical'), {
        start: [10, 90],
        step: 10,
        tooltips: true,
        connect: true,
        orientation: 'vertical',
        range: {
          min: 0,
          max: 100,
        },
        pips: {
          mode: 'steps',
          density: 5,
          format: {
            // 'to' the formatted value. Receives a number.
            to: function (value) {
              return '$ ' + value;
            },
            // 'from' the formatted value.
            // Receives a string, should return a number.
            from: function (value) {
              return Number(value.replace('$', ''));
            },
          },
        },
        format: {
          // 'to' the formatted value. Receives a number.
          to: function (value) {
            return '$ ' + value;
          },
          // 'from' the formatted value.
          // Receives a string, should return a number.
          from: function (value) {
            return Number(value.replace('$', ''));
          },
        },
      });
    }
  }

  // Top label input slider
  _initTopLabel() {
    if (document.getElementById('sliderHorizontalTopLabel')) {
      noUiSlider.create(document.getElementById('sliderHorizontalTopLabel'), {
        start: [20],
        connect: [true, false],
        range: {min: 0, max: 100},
      });
    }
  }

  // Filled input slider
  _initFilled() {
    if (document.getElementById('sliderHorizontalFilled')) {
      noUiSlider.create(document.getElementById('sliderHorizontalFilled'), {
        start: [20],
        connect: [true, false],
        range: {min: 0, max: 100},
      });
    }
  }

  // Floating label input slider
  _initFloatingLabel() {
    if (document.getElementById('sliderHorizontalFloatingLabel')) {
      noUiSlider.create(document.getElementById('sliderHorizontalFloatingLabel'), {
        start: [20],
        connect: [true, false],
        range: {min: 0, max: 100},
      });
    }
  }
}
