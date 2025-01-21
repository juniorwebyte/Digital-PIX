/**
 *
 * EditableRows
 *
 * Interface.Plugins.Datatables.EditableRows page content scripts. Initialized from scripts.js file.
 *
 *
 */

class EditableRows {
    constructor() {
        if (!jQuery().DataTable) {
            console.log('DataTable is null!');
            return;
        }

        if (!jQuery().validate) {
            console.log('validate is undefined!');
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
        this._staticHeight = 62;

        this._createInstance();
        this._addListeners();
        this._extend();
        this._initBootstrapModal();
    }

    // Creating datatable instance
    _createInstance() {
        const _this = this;
        this._datatable = jQuery('#datatableRows').DataTable({
            scrollX: true,
            buttons: ['copy', 'excel', 'csv', 'print'],
            info: false,
            order: [], // Clearing default order
            sDom: '<"row"<"col-sm-12"<"table-container"t>r>><"row"<"col-12"p>>', // Hiding all other dom elements except table and pagination
            pageLength: 10,
            // columns: [{ data: 'id' }, { data: 'titulo' }, { data: 'estoque' }, { data: 'valor1' }, { data: 'valor2' }, { data: 'valor3' }, { data: 'valor3' }],
            language: {
                zeroRecords: "Nenhum registro encontrado",
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
                // // Adding checkbox for Check column
                // {
                //     targets: 6,
                //     render: function (data, type, row, meta) {
                //         return '<div class="form-check float-end mt-1"><input type="checkbox" class="form-check-input"></div>';
                //     },
                // },
            ],
        });
        _this._setInlineHeight();
    }

    _addListeners() {
        // Modal Add New Produto
        document.getElementById('exampleForm').addEventListener('submit', function(e){
            e.preventDefault();
        });

        // Listener for confirm button on the edit/add modal
        document.getElementById('addEditConfirmButton').addEventListener('click', this._addEditFromModalClick.bind(this));

        // Listener for add buttons
        document.querySelectorAll('.detalhes').forEach((el) => el.addEventListener('click', this._detalhes.bind(this)));

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
        // this._datatableExtend = new DatatableExtend({
        //     datatable: this._datatable,
        //     editRowCallback: this._onDetalhesRowClick.bind(this),
        //     singleSelectCallback: this._onSingleSelect.bind(this),
        //     multipleSelectCallback: this._onMultipleSelect.bind(this),
        //     anySelectCallback: this._onAnySelect.bind(this),
        //     noneSelectCallback: this._onNoneSelect.bind(this),
        // });
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
        document.querySelector('.dataTables_scrollBody').style.height = this._staticHeight * pageLength + 'px';
    }

    async _validateForm() {
        var form = document.getElementById('exampleForm');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return false;
        }
        return true;
    }



    // Add or edit button inside the modal click
    _addEditFromModalClick(event) {
        if (this._currentState === 'add') {
            this._addNewRowFromModal();
        } else {
            this._editRowFromModal();
        }
        //this._addEditModal.hide();
    }

    _detalhes(event){
        if (event.currentTarget.classList.contains('disabled')) {
            return;
        }

        const selected = this._datatableExtend.getSelectedRows();
        this._onDetalhesRowClick(this._datatable.row(selected[0][0]))
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
        const data = this._rowToEdit.data();
        //window.location.href = 'produtos/detalhes/' + data.id;

        this._showModal('edit', 'Editar Produto', 'Salvar');
        this._setForm();
    }

    _onDetalhesRowClick(rowToEdit) {
        this._rowToEdit = rowToEdit; // Passed from DatatableExtend via callback from settings
        const data = this._rowToEdit.data();
        window.location.href = 'produtos/detalhes/' + data.id;

        // this._showModal('edit', 'Editar Produto', 'Salvar');
        // this._setForm();
    }

    // Edit button inside th modal click
    async _editRowFromModal() {
        const data = this._rowToEdit.data();

        if (!await this._validateForm()) return false;

        const formData = Object.assign(data, this._getFormData());
        var responseAjax = null;
        await $.ajax({
            url: "/editarProduto/" + data.id,
            type: 'PUT',
            dataType: 'json',
            data: data,
            success: function (response) {
                responseAjax = response;
            }
        })

        this._addEditModal.hide();
        if (responseAjax.success) {
            jQuery.notify({ title: 'Sucesso!', message: responseAjax.success }, { type: 'success', showProgressbar: true, delay: 2000 });
            data.id = responseAjax.id;
            this._datatable.row(this._rowToEdit).data(formData).draw();
            this._datatableExtend.unCheckAllRows();
            this._datatableExtend.controlCheckAll();
        }
        else {
            jQuery.notify({ title: 'Erro!', message: responseAjax.error }, { type: 'danger', showProgressbar: true, delay: 2000 });
        }
    }

    // Add button inside th modal click
    async _addNewRowFromModal() {
        const data = this._getFormData();
        if (!await this._validateForm()) return false;



        var responseAjax = null;
        await $.ajax({
            url: "/novoProduto",
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (response) {
                responseAjax = response;
            }
        })

        this._addEditModal.hide();
        if (responseAjax.success) {
            jQuery.notify({ title: 'Sucesso!', message: responseAjax.success }, { type: 'success', showProgressbar: true, delay: 2000 });
            data.id = responseAjax.id;
            data.Check = false;
            data.acao = '';
            data.estoque = responseAjax.estoque;
            this._datatable.row.add(data).draw();
            this._datatableExtend.unCheckAllRows();

            //window.open('produtos/detalhes/' + data.id, "_blank");

        }
        else {
            jQuery.notify({ title: 'Erro!', message: responseAjax.error }, { type: 'danger', showProgressbar: true, delay: 2000 });
        }
    }

    // Delete icon click
    _onDeleteClick() {
        const selected = this._datatableExtend.getSelectedRows();
        const rows = selected[0];
        const produtosDelete = [];
        var produtosJson = {};
        for (let i = 0; i < rows.length; i = i + 1) {
            produtosDelete.push(this._datatable.row(rows[i]).data().id)
        }

        produtosJson.produtos = produtosDelete;

        $.ajax({
            url: "/deletarProduto",
            type: 'POST',
            dataType: 'json',
            data: produtosJson,
            success: function (response) {
                if (response.error) {
                    jQuery.notify({ title: 'Erro!', message: response.error }, { type: 'danger', showProgressbar: true, delay: 2000 });
                    return false;
                }

                if (response.success) {
                    jQuery.notify({ title: 'Sucesso!', message: response.success }, { type: 'success', showProgressbar: true, delay: 2000 });
                }
            }
        })
        selected.remove().draw();
        this._datatableExtend.controlCheckAll();
    }

    // + Add New or just + button from top side click
    _onAddRowClick() {
        this._showModal('add', 'Novo Produto', 'Adicionar');
    }

    // Showing modal for an objective, add or edit
    _showModal(objective, title, button) {
        this._addEditModal.show();
        this._currentState = objective;
        document.getElementById('modalTitle').innerHTML = title;
        document.getElementById('addEditConfirmButton').innerHTML = button;
    }

    // Filling the modal form data
    async _setForm() {
        const data = this._rowToEdit.data();
        console.log(data);

        await $.ajax({
            url: "/getProduto",
            type: 'POST',
            dataType: 'json',
            data: {
                id: data.id
            },
            success: function (response) {
                data.descricao = response.descricao;
            }
        })

        document.querySelector('#addEditModal input[name=titulo]').value = data.titulo;
        document.querySelector('#addEditModal textarea[name=descricao]').value = data.descricao;
        document.querySelector('#addEditModal input[name=valor1]').value = data.valor1;
        document.querySelector('#addEditModal input[name=valor2]').value = data.valor2;
        document.querySelector('#addEditModal input[name=valor3]').value = data.valor3;
    }

    // Getting form values from the fields to pass to datatable
    _getFormData() {
        const data = {};
        data.titulo = document.querySelector('#addEditModal input[name=titulo]').value;
        data.descricao = document.querySelector('#addEditModal textarea[name=descricao]').value;
        data.valor1 = document.querySelector('#addEditModal input[name=valor1]').value;
        data.valor2 = document.querySelector('#addEditModal input[name=valor2]').value ? document.querySelector('#addEditModal input[name=valor2]').value : 0.00;
        data.valor3 = document.querySelector('#addEditModal input[name=valor3]').value ? document.querySelector('#addEditModal input[name=valor3]').value : 0.00;
        return data;
    }

    // Clearing modal form
    _clearModalForm() {
        document.querySelector('#addEditModal form').reset();
        var form = document.getElementById('exampleForm');
        form.classList.remove('was-validated');
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
        document.querySelectorAll('.detalhes').forEach((el) => el.classList.remove('disabled'));
    }

    // Multiple item select callback from DatatableExtend
    _onMultipleSelect() {
        document.querySelectorAll('.edit-datatable').forEach((el) => el.classList.add('disabled'));
        document.querySelectorAll('.detalhes').forEach((el) => el.classList.add('disabled'));
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
