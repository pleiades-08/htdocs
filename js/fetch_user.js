$(document).ready(function() {
    $.ajax({
        url: '/controllers/fetchUserStatus.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {

        // ✅ ACTIVE USERS
        if (data.active.length > 0) {
            data.active.forEach(function(user) {
            $('#activeTable tbody').append(`
                <tr>
                <td>${user.user_id}</td>
                <td>${user.fullname}</td>
                <td>${user.user_type}</td>
                <td>${user.dept}</td>
                <td>${user.status_}</td>
                <td>
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
                </td>
                </tr>
            `);
            });
        } else {
            $('#activeTable tbody').append(`
            <tr>
                <td colspan="6" class="text-center text-muted">No active accounts found.</td>
            </tr>
            `);
        }

        // ✅ INACTIVE USERS
        if (data.inactive.length > 0) {
            data.inactive.forEach(function(user) {
            $('#inactiveTable tbody').append(`
                <tr>
                <td>${user.user_id}</td>
                <td>${user.fullname}</td>
                <td>${user.user_type}</td>
                <td>${user.dept}</td>
                <td>${user.status_}</td>
                <td>
                    <button type="button" class="btn btn-primary" onclick="openViewModal(${user.user_id})">View</button>
                    <form action="/actions/deactivate_user.php" method="GET" style="display:inline;">
                    <input type="hidden" name="user_id" value="${user.user_id}">
                    <button type="submit" class="btn btn-success">Archive</button>
                    </form>
                    <form action="/actions/activate_user.php" method="GET" style="display:inline;">
                    <input type="hidden" name="user_id" value="${user.user_id}">
                    <button type="submit" class="btn btn-warning">Activate</button>
                    </form>
                </td>
                </tr>
            `);
            });
        } else {
            $('#inactiveTable tbody').append(`
            <tr>
                <td colspan="6" class="text-center text-muted">No inactive accounts found.</td>
            </tr>
            `);
        }

        },
        error: function(err) {
        console.error('Error:', err);
        }
    });
});

let activeData = [];
let inactiveData = [];

function renderTable(data, target) {
    const tbody = $(target).find('tbody');
    tbody.empty();

    const isActiveTable = target === '#activeTable';

    if (data.length === 0) {
        tbody.append(`<tr><td colspan="6" class="text-center text-muted">No records found.</td></tr>`);
        return;
    }

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
                <td>${user.user_id}</td>
                <td>${user.fullname}</td>
                <td>${user.user_type}</td>
                <td>${user.dept}</td>
                <td>${user.status_}</td>
                <td>${actionButtons}</td>
            </tr>
        `);
    });
}


function sortTable(data, column, order) {
    return data.sort((a, b) => {
        let valA = a[column] ? a[column].toString().toLowerCase() : '';
        let valB = b[column] ? b[column].toString().toLowerCase() : '';

        if (!isNaN(valA) && !isNaN(valB)) {
        valA = Number(valA);
        valB = Number(valB);
        }

        if (valA < valB) return order === 'asc' ? -1 : 1;
        if (valA > valB) return order === 'asc' ? 1 : -1;
        return 0;
    });
    }

    $(document).ready(function () {
    $.ajax({
        url: '/controllers/fetchUserStatus.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
        activeData = data.active;
        inactiveData = data.inactive;

        renderTable(activeData, '#activeTable');
        renderTable(inactiveData, '#inactiveTable');
        }
    });

    // Sorting for active and inactive tables
    $('#activeTable th[data-column], #inactiveTable th[data-column]').on('click', function () {
        const $this = $(this);
        const column = $this.data('column');
        const currentOrder = $this.data('order');
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        $this.data('order', newOrder);

        // Reset other headers in the row
        $this.closest('tr').find('th[data-column]').each(function () {
            const label = $(this).data('label');
            $(this).html(label + ' ▼'); // reset all to ▼
            $(this).data('order', 'desc'); // reset order
        });

        // Set the clicked header to the correct arrow
        const arrow = newOrder === 'asc' ? ' ▲' : ' ▼';
        const label = $this.data('label');
        $this.html(label + arrow);
        $this.data('order', newOrder);

        // Determine which table and sort
        const tableId = $this.closest('table').attr('id');
        let sortedData = [];

        if (tableId === 'activeTable') {
            sortedData = sortTable([...activeData], column, newOrder);
            renderTable(sortedData, '#activeTable');
        } else {
            sortedData = sortTable([...inactiveData], column, newOrder);
            renderTable(sortedData, '#inactiveTable');
        }
    });

});
