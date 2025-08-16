
function openModal() {
        document.getElementById('userModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('userModal').style.display = 'none';
        resetForm();
    }

    function switchForm() {
        const selected = document.getElementById('user_type').value;
        const sections = document.querySelectorAll('.form-section');
        sections.forEach(section => {
            if (section.id === `form-${selected}`) {
                section.classList.add('active');
                section.querySelectorAll('input, select').forEach(input => input.disabled = false);
            } else {
                section.classList.remove('active');
                section.querySelectorAll('input, select').forEach(input => input.disabled = true);
            }
        });
    }

    function resetForm() {
        document.getElementById('Register').reset();
        document.querySelectorAll('.form-section').forEach(section => {
            section.classList.remove('active');
            section.querySelectorAll('input, select').forEach(input => input.disabled = true);
        });
    }

    window.onload = resetForm;

    window.onclick = function(event) {
        if (event.target === document.getElementById('userModal')) {
            closeModal();
        }
    };

    function openEditModal(userId) {
    fetch(`/controllers/FetchUserDetails.php?user_id=${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch user details.');
            }
            return response.json();
        })
        .then(data => {
            const editModal = document.getElementById('editModal');
            editModal.querySelector('[name="user_id"]').value = data.user_id;
            editModal.querySelector('[name="school_id"]').value = data.school_id;
            editModal.querySelector('[name="email"]').value = data.kldemail;
            editModal.querySelector('[name="username"]').value = data.username;
            editModal.querySelector('[name="first_name"]').value = data.first_name;
            editModal.querySelector('[name="middle_name"]').value = data.middle_name;
            editModal.querySelector('[name="last_name"]').value = data.last_name;
            editModal.querySelector('[name="dept"]').value = data.dept;

            updateEditDeptLabel(data.user_type);

            editModal.style.display = 'block';
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('editForm').reset();
    }

    function openViewModal(userId) {
    fetch(`/controllers/FetchUserDetails.php?user_id=${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch user details.');
            }
            return response.json();
        })
        .then(data => {
            const viewModal = document.getElementById('viewModal');
            viewModal.querySelector('[name="user_id"]').value = data.user_id;
            viewModal.querySelector('[name="school_id"]').value = data.school_id;
            viewModal.querySelector('[name="email"]').value = data.email;
            viewModal.querySelector('[name="username"]').value = data.username;
            viewModal.querySelector('[name="first_name"]').value = data.first_name;
            viewModal.querySelector('[name="middle_name"]').value = data.middle_name;
            viewModal.querySelector('[name="last_name"]').value = data.last_name;
            viewModal.querySelector('[name="dept"]').value = data.dept;

            updateViewDeptLabel(data.user_type);

            viewModal.style.display = 'block';
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }

    function closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
        document.getElementById('viewForm').reset();
    }

    function updateEditDeptLabel(user_type) {
    const label = document.getElementById('editdeptLabel');
    if (user_type === 'Student') {
        label.textContent = 'Section:';
    } else {
        label.textContent = 'Department:';
    }
    }

    function updateViewDeptLabel(user_type) {
    const label = document.getElementById('viewdeptLabel');
    if (user_type === 'Student') {
        label.textContent = 'Section:';
    } else {
        label.textContent = 'Department:';
    }
}



