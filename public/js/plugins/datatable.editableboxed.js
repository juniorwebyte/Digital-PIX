/**
 *
 * EditableBoxed
 *
 * Interface.Plugins.Datatables.EditableBoxed page content scripts. Initialized from scripts.js file.
 *
 *
 */

class EditableBoxed {
  constructor() {
    if (!jQuery().DataTable) {
      console.log('DataTable is null!');
      return;
    }

    // Selected single row which will be edited
    this._rowToEdit;

    // Datatable instance
    this._datatable;

    // Edit or add state of the modal
    this._currentState;

    // Controls and select helper
    this._datatableExtend;

    // Add or edit modal
    this._addEditModal;

    // Datatable single item height
    this._staticHeight = 42;

    this._createInstance();
    this._addListeners();
    this._extend();
    this._initBootstrapModal();
    this._setInlineHeight();
  }

  // Creating datatable instance
  _createInstance() {
    const _this = this;
    this._datatable = jQuery('#datatableBoxed').DataTable({
      buttons: ['copy', 'excel', 'csv', 'print'],
      responsive: true,
      info: false,
      order: [], // Clearing default order
      sDom: '<"row"<"col-sm-12"<"table-container"<"card"<"card-body half-padding"t>>>>><"row"<"col-12 mt-3"p>>', // Hiding all other dom elements except table and pagination
      pageLength: 15,
      columns: [{data: 'Name'}, {data: 'Sales'}, {data: 'Stock'}, {data: 'Category'}, {data: 'Tag'}, {data: 'Check'}],
      language: {
        paginate: {
          previous: '<i class="cs-chevron-left"></i>',
          next: '<i class="cs-chevron-right"></i>',
        },
      },
      initComplete: function (settings, json) {
        _this._setInlineHeight();
      },
      drawCallback: function (settings) {
        _this._setInlineHeight();
      },
      columnDefs: [
        // Adding Name content as an anchor with a target #
        {
          targets: 0,
          render: function (data, type, row, meta) {
            return '<a class="list-item-heading body" href="#">' + data + '</a>';
          },
        },
        // Adding Tag content as a span with a badge class
        {
          targets: 4,
          render: function (data, type, row, meta) {
            return '<span class="badge bg-outline-primary">' + data + '</span>';
          },
        },
        // Adding checkbox for Check column
        {
          targets: 5,
          render: function (data, type, row, meta) {
            return '<div class="form-check float-end mt-1"><input type="checkbox" class="form-check-input"></div>';
          },
        },
      ],
    });
  }

  _addListeners() {
    // Listener for confirm button on the edit/add modal
    document.getElementById('addEditConfirmButton').addEventListener('click', this._addEditFromModalClick.bind(this));

    // Listener for add buttons
    document.querySelectorAll('.add-datatable').forEach((el) => el.addEventListener('click', this._onAddRowClick.bind(this)));

    // Listener for delete buttons
    document.querySelectorAll('.delete-datatable').forEach((el) => el.addEventListener('click', this._onDeleteClick.bind(this)));

    // Listener for edit button
    document.querySelectorAll('.edit-datatable').forEach((el) => el.addEventListener('click', this._onEditButtonClick.bind(this)));

    // Calling a function to update tags on click
    document.querySelectorAll('.tag-done').forEach((el) => el.addEventListener('click', () => this._updateTag('Done')));
    document.querySelectorAll('.tag-new').forEach((el) => el.addEventListener('click', () => this._updateTag('New')));
    document.querySelectorAll('.tag-sale').forEach((el) => el.addEventListener('click', () => this._updateTag('Sale')));

    // Calling clear form when modal is closed
    document.getElementById('addEditModal').addEventListener('hidden.bs.modal', this._clearModalForm);
  }

  // Extending with DatatableExtend to get search, select and export working
  _extend() {
    this._datatableExtend = new DatatableExtend({
      datatable: this._datatable,
      editRowCallback: this._onEditRowClick.bind(this),
      singleSelectCallback: this._onSingleSelect.bind(this),
      multipleSelectCallback: this._onMultipleSelect.bind(this),
      anySelectCallback: this._onAnySelect.bind(this),
      noneSelectCallback: this._onNoneSelect.bind(this),
    });
  }

  // Keeping a reference to add/edit modal
  _initBootstrapModal() {
    this._addEditModal = new bootstrap.Modal(document.getElementById('addEditModal'));
  }

  // Setting static height to datatable to prevent pagination movement when list is not full
  _setInlineHeight() {
    if (!this._datatable) {
      return;
    }
    const pageLength = this._datatable.page.len();
    document.querySelector('.data-table-boxed .table-container .card').style.height = this._staticHeight * pageLength + 80 + 'px';
  }

  // Add or edit button inside the modal click
  _addEditFromModalClick(event) {
    if (this._currentState === 'add') {
      this._addNewRowFromModal();
    } else {
      this._editRowFromModal();
    }
    this._addEditModal.hide();
  }

  // Top side edit icon click
  _onEditButtonClick(event) {
    if (event.currentTarget.classList.contains('disabled')) {
      return;
    }
    const selected = this._datatableExtend.getSelectedRows();
    this._onEditRowClick(this._datatable.row(selected[0][0]));
  }

  // Direct click from row title
  _onEditRowClick(rowToEdit) {
    this._rowToEdit = rowToEdit; // Passed from DatatableExtend via callback from settings
    this._showModal('edit', 'Edit', 'Done');
    this._setForm();
  }

  // Edit button inside th modal click
  _editRowFromModal() {
    const data = this._rowToEdit.data();
    const formData = Object.assign(data, this._getFormData());
    this._datatable.row(this._rowToEdit).data(formData).draw();
    this._datatableExtend.unCheckAllRows();
    this._datatableExtend.controlCheckAll();
  }

  // Add button inside th modal click
  _addNewRowFromModal() {
    const data = this._getFormData();
    this._datatable.row.add(data).draw();
    this._datatableExtend.unCheckAllRows();
  }

  // Delete icon click
  _onDeleteClick() {
    const selected = this._datatableExtend.getSelectedRows();
    selected.remove().draw();
    this._datatableExtend.controlCheckAll();
  }

  // + Add New or just + button from top side click
  _onAddRowClick() {
    this._showModal('add', 'Add New', 'Add');
  }

  // Showing modal for an objective, add or edit
  _showModal(objective, title, button) {
    this._addEditModal.show();
    this._currentState = objective;
    document.getElementById('modalTitle').innerHTML = title;
    document.getElementById('addEditConfirmButton').innerHTML = button;
  }

  // Filling the modal form data
  _setForm() {
    const data = this._rowToEdit.data();
    document.querySelector('#addEditModal input[name=Name]').value = data.Name;
    document.querySelector('#addEditModal input[name=Sales]').value = data.Sales;
    document.querySelector('#addEditModal input[name=Stock]').value = data.Stock;
    if (document.querySelector('#addEditModal ' + 'input[name=Category][value="' + data.Category + '"]')) {
      document.querySelector('#addEditModal ' + 'input[name=Category][value="' + data.Category + '"]').checked = true;
    }
    if (document.querySelector('#addEditModal ' + 'input[name=Tag][value="' + data.Tag + '"]')) {
      document.querySelector('#addEditModal ' + 'input[name=Tag][value="' + data.Tag + '"]').checked = true;
    }
  }

  // Getting form values from the fields to pass to datatable
  _getFormData() {
    const data = {};
    data.Name = document.querySelector('#addEditModal input[name=Name]').value;
    data.Sales = document.querySelector('#addEditModal input[name=Sales]').value;
    data.Stock = document.querySelector('#addEditModal input[name=Stock]').value;
    data.Category = document.querySelector('#addEditModal input[name=Category]:checked')
      ? document.querySelector('#addEditModal input[name=Category]:checked').value || ''
      : '';
    data.Tag = document.querySelector('#addEditModal input[name=Tag]:checked')
      ? document.querySelector('#addEditModal input[name=Tag]:checked').value || ''
      : '';
    data.Check = '';
    return data;
  }

  // Clearing modal form
  _clearModalForm() {
    document.querySelector('#addEditModal form').reset();
  }

  // Update tag from top side dropdown
  _updateTag(tag) {
    const selected = this._datatableExtend.getSelectedRows();
    const _this = this;
    selected.every(function (rowIdx, tableLoop, rowLoop) {
      const data = this.data();
      data.Tag = tag;
      _this._datatable.row(this).data(data).draw();
    });
    this._datatableExtend.unCheckAllRows();
    this._datatableExtend.controlCheckAll();
  }

  // Single item select callback from DatatableExtend
  _onSingleSelect() {
    document.querySelectorAll('.edit-datatable').forEach((el) => el.classList.remove('disabled'));
  }

  // Multiple item select callback from DatatableExtend
  _onMultipleSelect() {
    document.querySelectorAll('.edit-datatable').forEach((el) => el.classList.add('disabled'));
  }

  // One or more item select callback from DatatableExtend
  _onAnySelect() {
    document.querySelectorAll('.delete-datatable').forEach((el) => el.classList.remove('disabled'));
    document.querySelectorAll('.tag-datatable').forEach((el) => el.classList.remove('disabled'));
  }

  // Deselect callback from DatatableExtend
  _onNoneSelect() {
    document.querySelectorAll('.delete-datatable').forEach((el) => el.classList.add('disabled'));
    document.querySelectorAll('.tag-datatable').forEach((el) => el.classList.add('disabled'));
  }
}
