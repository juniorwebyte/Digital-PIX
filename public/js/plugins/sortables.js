/**
 *
 * Sortables
 *
 * Interface.Plugins.Sortable page content scripts. Initialized from scripts.js file.
 *
 *
 */

class Sortables {
  constructor() {
    // Initialization of the page plugins
    if (typeof Sortable === 'undefined') {
      console.log('Sortable is null!');
      return;
    }

    this._initBasic();
    this._initColumns();
    this._initClass();
    this._initMoving();
    this._initStore();
    this._initAnimation();
  }

  // Standard sortable
  _initBasic() {
    if (document.getElementById('sortableBasic')) {
      Sortable.create(document.getElementById('sortableBasic'));
    }
  }

  // Sortable bootstrap columns
  _initColumns() {
    if (document.getElementById('sortableColumns')) {
      Sortable.create(document.getElementById('sortableColumns'));
    }
  }

  // Class initialization
  _initClass() {
    if (document.querySelectorAll('.sortable-init').length > 0) {
      document.querySelectorAll('.sortable-init').forEach((el) => {
        Sortable.create(el);
      });
    }
  }

  // Moving from a group to another
  _initMoving() {
    if (document.getElementById('sortableGroupFirst')) {
      Sortable.create(document.getElementById('sortableGroupFirst'), {
        animation: 100,
        group: {
          name: 'groupFirst',
          put: ['groupSecond'],
        },
      });
    }
    if (document.getElementById('sortableGroupSecond')) {
      Sortable.create(document.getElementById('sortableGroupSecond'), {
        animation: 100,
        group: {
          name: 'groupSecond',
          put: ['groupFirst'],
        },
      });
    }
  }

  // Stores sortable list in local storage
  _initStore() {
    if (document.getElementById('sortableStore')) {
      Sortable.create(document.getElementById('sortableStore'), {
        group: 'localStorage-example',
        store: {
          get: function (sortable) {
            var order = localStorage.getItem(sortable.options.group.name);
            return order ? order.split('|') : [];
          },
          set: function (sortable) {
            var order = sortable.toArray();
            localStorage.setItem(sortable.options.group.name, order.join('|'));
          },
        },
      });
    }
  }

  // Sortable with animation
  _initAnimation() {
    if (document.getElementById('sortableAnimation')) {
      Sortable.create(document.getElementById('sortableAnimation'), {animation: 200});
    }
  }
}
