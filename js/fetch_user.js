$(document).ready(function() {
    const rowsPerPage = 5;
    let activeData = [];
    let inactiveData = [];

    // Fetches data from the server and initializes the tables and pagination.
    function fetchData() {
        $.ajax({
            url: '/controllers/fetchUserStatus.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                activeData = data.active;
                inactiveData = data.inactive;

                // Initial render of the tables and pagination
                renderTablePage(activeData, '#activeTable', 1);
                renderTablePage(inactiveData, '#inactiveTable', 1);
                renderPagination(activeData, 'activePagination', '#activeTable');
                renderPagination(inactiveData, 'inactivePagination', '#inactiveTable');
            },
            error: function(err) {
                console.error('Error fetching data:', err);
            }
        });
    }

    // Renders the data for a specific page of a table.
    function renderTablePage(data, targetTable, page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = data.slice(start, end);
        renderTable(pageData, targetTable);
    }

    // Renders the table body with the provided data.
    function renderTable(data, targetTable) {
        const tbody = $(targetTable).find('tbody');
        tbody.empty();

        if (data.length === 0) {
            const colspan = $(targetTable).find('thead th').length;
            tbody.append(`<tr><td colspan="${colspan}" class="text-center text-muted">No records found.</td></tr>`);
            return;
        }

        const isActiveTable = targetTable === '#activeTable';
        const checkboxClass = isActiveTable ? 'userCheckbox' : 'userCheckbox1';

        data.forEach(user => {
            let actionButtons = '';
            if (isActiveTable) {
                actionButtons = `
                    <button type="button" class="btn btn-primary" onclick="openViewModal(${user.user_id})">View</button>
                    <button type="button" class="btn btn-secondary" onclick="openEditModal(${user.user_id})">Edit</button>
                    <form action="MngAccArchiveUser.php" method="GET" style="display:inline;">
                        <input type="hidden" name="user_id" value="${user.user_id}">
                        <button type="submit" class="btn btn-success">Archive</button>
                    </form>
                    <form action="/actions/deactivate_user.php" method="GET" style="display:inline;">
                        <input type="hidden" name="user_id" value="${user.user_id}">
                        <button type="submit" class="btn btn-danger" style="width: 100px;">Deactivate</button>
                    </form>
                `;
            } else {
                actionButtons = `
                    <button type="button" class="btn btn-primary" onclick="openViewModal(${user.user_id})">View</button>
                    <form action="/actions/deactivate_user.php" method="GET" style="display:inline;">
                        <input type="hidden" name="user_id" value="${user.user_id}">
                        <button type="submit" class="btn btn-success">Archive</button>
                    </form>
                    <form action="/actions/activate_user.php" method="GET" style="display:inline;">
                        <input type="hidden" name="user_id" value="${user.user_id}">
                        <button type="submit" class="btn btn-warning">Activate</button>
                    </form>
                `;
            }

            tbody.append(`
                <tr>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input ${checkboxClass}" value="${user.user_id}">
                        </div>
                    </td>
                    <td>${user.school_id}</td>
                    <td>${user.fullname}</td>
                    <td>${user.user_type}</td>
                    <td>${user.dept}</td>
                    <td>${user.status_}</td>
                    <td class="text-center">${actionButtons}</td>
                </tr>
            `);
        });
    }

    // Creates pagination links and handles click events.
    function renderPagination(data, paginationId, tableId) {
        const totalPages = Math.ceil(data.length / rowsPerPage);
        const pagination = $(`#${paginationId}`);
        pagination.empty();

        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            pagination.append(`
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${i}" data-table="${tableId}">${i}</a>
                </li>
            `);
        }

        // Click event for pagination links
        pagination.find('.page-link').on('click', function(e) {
            e.preventDefault();
            const page = parseInt($(this).data('page'));
            const table = $(this).data('table');
            const tableData = (table === '#activeTable') ? activeData : inactiveData;

            renderTablePage(tableData, table, page);
            pagination.find('li').removeClass('active');
            $(this).parent().addClass('active');
        });

        pagination.find('li:first').addClass('active');
    }

    // Sorts the data based on a column and order.
    function sortTable(data, column, order) {
        return [...data].sort((a, b) => {
            const valA = a[column] ? a[column].toString().toLowerCase() : '';
            const valB = b[column] ? b[column].toString().toLowerCase() : '';

            // Handle numeric values
            if (!isNaN(parseFloat(valA)) && !isNaN(parseFloat(valB))) {
                return (parseFloat(valA) - parseFloat(valB)) * (order === 'asc' ? 1 : -1);
            }

            if (valA < valB) return order === 'asc' ? -1 : 1;
            if (valA > valB) return order === 'asc' ? 1 : -1;
            return 0;
        });
    }

    // Event listener for sorting table headers.
    $('#activeTable th[data-column], #inactiveTable th[data-column]').on('click', function() {
        const $this = $(this);
        const column = $this.data('column');
        const tableId = $this.closest('table').attr('id');
        let currentOrder = $this.data('order') || 'asc';
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        $this.data('order', newOrder);

        // Reset arrows on all headers in the same table
        $(`#${tableId} th[data-column] .sort-arrow`).html('');

        // Update the arrow for the clicked header
        const arrow = newOrder === 'asc' ? '&#x25B2;' : '&#x25BC;';
        $this.find('.sort-arrow').html(arrow);

        const tableData = (tableId === 'activeTable') ? activeData : inactiveData;
        const sortedData = sortTable(tableData, column, newOrder);

        if (tableId === 'activeTable') {
            activeData = sortedData;
            renderTablePage(activeData, `#${tableId}`, 1);
            renderPagination(activeData, 'activePagination', `#${tableId}`);
        } else {
            inactiveData = sortedData;
            renderTablePage(inactiveData, `#${tableId}`, 1);
            renderPagination(inactiveData, 'inactivePagination', `#${tableId}`);
        }
    });

    fetchData();
});

