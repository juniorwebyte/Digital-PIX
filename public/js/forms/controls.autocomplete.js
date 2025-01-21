/**
 *
 * AutocompleteControls
 *
 * Interface.Forms.Controls.Autocomplete page content scripts. Initialized from scripts.js file.
 *
 *
 */

class AutocompleteControls {
  constructor() {
    // Initialization of the page plugins
    if (typeof AutocompleteCustom === 'undefined') {
      console.log('AutocompleteCustom is undefined!');
      return;
    }
    this._initStrictArray();
    this._initLooseArray();
    this._initArrayOfObjects();
    this._initJson();
    this._initTopLabel();
    this._initFilled();
    this._initFloatingLabel();
  }

  _initStrictArray() {
    if (document.getElementById('strictArray') !== null) {
      new AutocompleteCustom('strictArray', 'strictArrayResults', {
        data: {
          src: [
            'Anpan',
            'Basler Brot',
            'Cheesymite Scroll',
            'Dorayaki',
            'Fougasse',
            'Guernsey Gâche',
            'Kalach',
            'Lefse',
            'Matzo',
            'Naan',
            'Paratha',
            'Pistolet',
            'Rewena',
            'Shirmal',
            'Teacake',
            'Vienna Bread',
            'Zopf',
          ],
        },
        placeHolder: 'Search',
        searchEngine: 'strict',
        highlight: true,
      });
    }
  }

  _initLooseArray() {
    if (document.getElementById('looseArray') !== null) {
      new AutocompleteCustom('looseArray', 'looseArrayResults', {
        data: {
          src: [
            'Anpan',
            'Basler Brot',
            'Cheesymite Scroll',
            'Dorayaki',
            'Fougasse',
            'Guernsey Gâche',
            'Kalach',
            'Lefse',
            'Matzo',
            'Naan',
            'Paratha',
            'Pistolet',
            'Rewena',
            'Shirmal',
            'Teacake',
            'Vienna Bread',
            'Zopf',
          ],
        },
        placeHolder: 'Search',
        searchEngine: 'loose',
        highlight: true,
      });
    }
  }

  _initArrayOfObjects() {
    if (document.getElementById('arrayOfObjects') !== null) {
      new AutocompleteCustom('arrayOfObjects', 'arrayOfObjectsResults', {
        data: {
          src: [
            {id: 1, name: 'Anpan'},
            {id: 2, name: 'Basler Brot'},
            {id: 3, name: 'Cheesymite Scroll'},
            {id: 4, name: 'Dorayaki'},
            {id: 5, name: 'Fougasse'},
            {id: 6, name: 'Guernsey Gâche'},
            {id: 7, name: 'Kalach'},
            {id: 8, name: 'Lefse'},
            {id: 9, name: 'Matzo'},
            {id: 10, name: 'Naan'},
            {id: 11, name: 'Paratha'},
            {id: 12, name: 'Pistolet'},
            {id: 13, name: 'Rewena'},
            {id: 14, name: 'Shirmal'},
            {id: 15, name: 'Teacake'},
            {id: 16, name: 'Vienna Bread'},
            {id: 17, name: 'Anpan'},
            {id: 18, name: 'Zopf'},
          ],
          key: ['name'],
        },
        placeHolder: 'Search',
        searchEngine: 'strict',
        onSelection: (feedback) => {
          document.getElementById('arrayOfObjects').value = feedback.selection.value['name'];
          document.getElementById('arrayOfObjects').blur();
        },
      });
    }
  }

  _initJson() {
    if (document.getElementById('jsonData') !== null) {
      new AutocompleteCustom('jsonData', 'jsonDataResults', {
        data: {
          src: async () => {
            const source = await fetch('json/search.json');
            const data = await source.json();
            return data;
          },
          key: ['label'],
          cache: false,
        },
        placeHolder: 'Search',
        searchEngine: 'loose',
        onSelection: (feedback) => {
          document.getElementById('jsonData').value = feedback.selection.value['label'];
          document.getElementById('jsonData').blur();
        },
      });
    }
  }

  _initFloatingLabel() {
    if (document.getElementById('floatingLabelInput') !== null) {
      new AutocompleteCustom('floatingLabelInput', 'floatingLabelInputResults', {
        data: {
          src: [
            'Anpan',
            'Basler Brot',
            'Cheesymite Scroll',
            'Dorayaki',
            'Fougasse',
            'Guernsey Gâche',
            'Kalach',
            'Lefse',
            'Matzo',
            'Naan',
            'Paratha',
            'Pistolet',
            'Rewena',
            'Shirmal',
            'Teacake',
            'Vienna Bread',
            'Zopf',
          ],
        },
        placeHolder: 'Search',
        searchEngine: 'strict',
        highlight: true,
      });
    }
  }

  _initTopLabel() {
    if (document.getElementById('topLabelInput') !== null) {
      new AutocompleteCustom('topLabelInput', 'topLabelInputResults', {
        data: {
          src: [
            'Anpan',
            'Basler Brot',
            'Cheesymite Scroll',
            'Dorayaki',
            'Fougasse',
            'Guernsey Gâche',
            'Kalach',
            'Lefse',
            'Matzo',
            'Naan',
            'Paratha',
            'Pistolet',
            'Rewena',
            'Shirmal',
            'Teacake',
            'Vienna Bread',
            'Zopf',
          ],
        },
        placeHolder: '',
        searchEngine: 'strict',
        highlight: true,
      });
    }
  }

  _initFilled() {
    if (document.getElementById('filledInput') !== null) {
      new AutocompleteCustom('filledInput', 'filledInputResults', {
        data: {
          src: [
            'Anpan',
            'Basler Brot',
            'Cheesymite Scroll',
            'Dorayaki',
            'Fougasse',
            'Guernsey Gâche',
            'Kalach',
            'Lefse',
            'Matzo',
            'Naan',
            'Paratha',
            'Pistolet',
            'Rewena',
            'Shirmal',
            'Teacake',
            'Vienna Bread',
            'Zopf',
          ],
        },
        placeHolder: 'Search',
        searchEngine: 'strict',
        highlight: true,
      });
    }
  }
}
