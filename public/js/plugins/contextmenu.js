/**
 *
 * ContextMenu
 *
 * Interface.Plugins.ContextMenu page content scripts. Initialized from scripts.js file.
 *
 *
 */

class ContextMenu {
  constructor() {
    // Initialization of the page plugins
    if (!jQuery().contextMenu) {
      console.log('contextMenu is null!');
      return;
    }

    this._initBasic();
    this._initIcons();
    this._initDisabledItem();
    this._initSubItems();
    this._initMenuLeft();
    this._initHover();
    this._initActive();
  }

  // Default context menu
  _initBasic() {
    jQuery.contextMenu({
      selector: '#contextMenuBasic',
      animation: {duration: 0},
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        copy: {name: 'Copy'},
        archive: {name: 'Archive'},
        delete: {name: 'Delete'},
      },
    });
  }

  // Context menu with icons
  _initIcons() {
    jQuery.contextMenu({
      selector: '#contextMenuIcons',
      animation: {duration: 0},
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        copy: {name: 'Copy', className: 'cs-duplicate'},
        archive: {name: 'Archive', className: 'cs-archive'},
        delete: {name: 'Delete', className: 'cs-bin'},
      },
    });
  }

  // Context menu with disabled item
  _initDisabledItem() {
    jQuery.contextMenu({
      selector: '#contextMenuDisabledItem',
      animation: {duration: 0},
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        copy: {name: 'Copy', className: 'cs-duplicate'},
        archive: {name: 'Archive', className: 'cs-archive'},
        delete: {name: 'Delete', className: 'cs-bin', disabled: true},
      },
    });
  }

  // Context menu with sub menus
  _initSubItems() {
    jQuery.contextMenu({
      selector: '#contextMenuSub',
      animation: {duration: 0},
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        edit: {name: 'Edit'},
        cut: {name: 'Cut'},
        move: {
          name: 'Move',
          items: {
            'fold1-key1': {name: 'Archive'},
            fold2: {
              name: 'Folders',
              items: {
                'fold2-key1': {name: 'Alpha'},
                'fold2-key2': {name: 'Bravo'},
                'fold2-key3': {name: 'Charlie'},
              },
            },
            'fold1-key3': {name: 'Spam'},
          },
        },
      },
    });
  }

  // Context menu with left mouse click
  _initMenuLeft() {
    jQuery.contextMenu({
      selector: '#contextMenuLeft',
      animation: {duration: 0},
      trigger: 'left',
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        copy: {name: 'Copy'},
        archive: {name: 'Archive'},
        delete: {name: 'Delete'},
      },
    });
  }

  // Context menu with hover
  _initHover() {
    jQuery.contextMenu({
      selector: '#contextMenuHover',
      animation: {duration: 0},
      trigger: 'hover',
      autoHide: true,
      delay: 200,
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        copy: {name: 'Copy'},
        archive: {name: 'Archive'},
        delete: {name: 'Delete'},
      },
    });
  }

  // Context menu that sets card active via "activatable" class
  _initActive() {
    jQuery.contextMenu({
      selector: '#contextActive .card',
      animation: {duration: 0},
      callback: function (key, options) {
        console.log('clicked: ' + key);
      },
      items: {
        copy: {name: 'Copy'},
        archive: {name: 'Archive'},
        delete: {name: 'Delete'},
      },
    });
  }
}
