/**
 *
 * TimePickerControls
 *
 * Interface.Forms.Controls.TimePicker page content scripts. Initialized from scripts.js file.
 *
 *
 */

class TimePickerControls {
  constructor() {
    // Initialization of the page plugins
    if (typeof TimePicker === 'undefined') {
      console.log('TimePicker is undefined!');
      return;
    }

    this._initTimePicker24();
    this._initTimePicker12();
    this._initTimePickerInitialValue();
    this._initTimePickerWorkHours();
    this._initTimePickerUpdate();
    this._initTimePickerOutput();
    this._initTimePickerSetTime();
    this._initTimePickerFilled();
    this._initTimePickerTopLabel();
    this._initTimePickerFloatingLabel();
  }

  // Time picker for 24 hours
  _initTimePicker24() {
    if (document.querySelector('#timePicker24')) {
      new TimePicker(document.querySelector('#timePicker24'));
    }
  }

  // Time picker for 12 hours with AM-PM
  _initTimePicker12() {
    if (document.querySelector('#timePicker12')) {
      new TimePicker(document.querySelector('#timePicker12'));
    }
  }

  // Time picker with an initial value
  _initTimePickerInitialValue() {
    if (document.querySelector('#timePickerInitialValue')) {
      new TimePicker(document.querySelector('#timePickerInitialValue'));
    }
  }

  // Time picker for work hours
  _initTimePickerWorkHours() {
    if (document.querySelector('#timePickerWorkHours')) {
      new TimePicker(document.querySelector('#timePickerWorkHours'));
    }
  }

  // Time picker update event
  _initTimePickerUpdate() {
    if (document.getElementById('timeUpdate')) {
      const timeUpdate = new TimePicker(document.getElementById('timeUpdate'));
      timeUpdate.element.addEventListener('UPDATE', (event) => {
        console.log(event.target.value);
      });
    }
  }

  // Time picker update event with date output via data-output="date" attribute
  _initTimePickerOutput() {
    if (document.getElementById('timeOutput')) {
      const timeOutput = new TimePicker(document.getElementById('timeOutput'));
      timeOutput.element.addEventListener('UPDATE', (event) => {
        console.log(event.target.value);
      });
    }
  }

  // Setting time with button click
  _initTimePickerSetTime() {
    if (document.getElementById('timeSet')) {
      const timeSet = new TimePicker(document.getElementById('timeSet'));
      document.querySelectorAll('.time-set-button').forEach((el) => {
        el.addEventListener('click', (event) => {
          timeSet.setTime(event.target.innerHTML);
        });
      });
    }
    if (document.getElementById('timeSet12Hour')) {
      const timeSet = new TimePicker(document.getElementById('timeSet12Hour'));
      document.querySelectorAll('.time-set-button-12Hour').forEach((el) => {
        el.addEventListener('click', (event) => {
          timeSet.setTime(event.target.innerHTML);
        });
      });
    }
  }

  // Filled input time picker
  _initTimePickerFilled() {
    if (document.querySelector('#timePickerFilled')) {
      new TimePicker(document.querySelector('#timePickerFilled'), {dropdownClassname: 'time-filled-dropdown'});
    }
  }

  // Top label input time picker
  _initTimePickerTopLabel() {
    if (document.querySelector('#timePickerTopLabel')) {
      new TimePicker(document.querySelector('#timePickerTopLabel'), {dropdownClassname: 'time-top-label-dropdown'});
    }
  }

  // Floating label input time picker
  _initTimePickerFloatingLabel() {
    if (document.querySelector('#timePickerFloatingLabel')) {
      new TimePicker(document.querySelector('#timePickerFloatingLabel'), {dropdownClassname: 'time-top-label-dropdown'});
    }
  }
}
