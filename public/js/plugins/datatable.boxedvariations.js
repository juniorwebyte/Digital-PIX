/**
 *
 * BoxedVariations
 *
 * Interface.Plugins.Datatables.BoxedVariations page content scripts. Initialized from scripts.js file.
 *
 *
 */

class BoxedVariations {
  constructor() {
    if (!jQuery().DataTable) {
      console.log('DataTable is null!');
      return;
    }

    this._dataTableScroll = null;

    this._initBoxedWithScrollbar();
    this._initBoxedWithPagination();
    this._extendDatatables();
  }

  // Boxed variation with scrollbar
  _initBoxedWithScrollbar() {
    const _this = this;
    jQuery('.data-table-scrollable').DataTable({
      destroy: true,
      paging: false,
      buttons: ['copy', 'excel', 'csv', 'print'],
      columnDefs: [
        // Adding Name content as an anchor with a target #
        {
          targets: 0,
          render: function (data, type, row, meta) {
            return '<a class="list-item-heading body" href="#">' + data + '</a>';
          },
        },
      ],
      sDom: '<"row"<"col-sm-12"<"table-container"t>r>><"row"<"col-12"p>>',
      responsive: true,
      scrollY: '100%',
      scrollCollapse: !0,
      fnInitComplete: function () {
        _this._dataTableScroll = OverlayScrollbars(document.querySelectorAll('.dataTables_scrollBody'), {
          scrollbars: {autoHideDelay: 300},
          overflowBehavior: {x: 'hidden', y: 'scroll'},
        });
      },
    });
  }

  // Boxed variation for pagination, hover and stripe examples
  _initBoxedWithPagination() {
    jQuery('.data-table-standard').DataTable({
      destroy: true,
      paging: true,
      buttons: ['copy', 'excel', 'csv', 'print'],
      length: 10,
      columnDefs: [
        // Adding Name content as an anchor with a target #
        {
          targets: 0,
          render: function (data, type, row, meta) {
            return '<a class="list-item-heading body" href="#">' + data + '</a>';
          },
        },
      ],
      sDom: '<"row"<"col-sm-12"<"table-container"t>r>><"row"<"col-12"p>>',
      responsive: true,
      language: {
        paginate: {
          previous: '<i class="cs-chevron-left"></i>',
          next: '<i class="cs-chevron-right"></i>',
        },
      },
    });
  }

  // Calling extend makes search, page length, print and export work
  _extendDatatables() {
    new DatatableExtend();
  }
}
