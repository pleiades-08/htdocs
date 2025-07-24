// custom_modal.js

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('customTeamDetailsModal');
    const modalBody = document.getElementById('customTeamDetailsBody');
    const closeButtons = document.querySelectorAll('.custom-close-button'); // Select all close buttons
    const openModalButtons = document.querySelectorAll('.open-custom-modal-btn');

    // Function to open the modal
    function openModal() {
        modal.style.display = 'flex'; // Use flex to center the modal content
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
        modalBody.innerHTML = '<p>Loading team details...</p>'; // Reset content on close
    }

    // Add event listeners for closing the modal
    closeButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });

    // Close modal when clicking outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            closeModal();
        }
    });

    // Function to fetch team details via AJAX
    async function fetchTeamDetails(teamId) {
        modalBody.innerHTML = '<p>Loading team details...</p>'; // Show loading message
        openModal(); // Open modal immediately with loading message

        try {
            // Adjust the path to your new PHP endpoint
            const response = await fetch('/repository-kld/actions/fetch_team_details.php', {
                method: 'POST', // Use POST to send data securely
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'team_id=' + encodeURIComponent(teamId)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.team) {
                const team = data.team;
                let htmlContent = `
                    <div class="detail-row"><div class="detail-label">Team Name:</div><div class="detail-value">${team.team_name ? team.team_name : 'N/A'}</div></div>
                    <div class="detail-row"><div class="detail-label">Capstone Title:</div><div class="detail-value">${team.capstone_title ? team.capstone_title : 'N/A'}</div></div>
                    <div class="detail-row"><div class="detail-label">Capstone Type:</div><div class="detail-value">${team.capstone_type ? team.capstone_type : 'N/A'}</div></div>
                    <div class="detail-row"><div class="detail-label">Adviser:</div><div class="detail-value">${team.adviser_name ? team.adviser_name : 'No Adviser'}</div></div>
                    <div class="detail-row"><div class="detail-label">Technical:</div><div class="detail-value">${team.technical_name ? team.technical_name : 'No Technical'}</div></div>
                    <div class="detail-row"><div class="detail-label">Chairman:</div><div class="detail-value">${team.chairman_name ? team.chairman_name : 'No Chairperson'}</div></div>
                    <div class="detail-row"><div class="detail-label">Major Discipline:</div><div class="detail-value">${team.major_name ? team.major_name : 'No Major'}</div></div>
                    <div class="detail-row"><div class="detail-label">Minor Discipline:</div><div class="detail-value">${team.minor_name ? team.minor_name : 'No Minor'}</div></div>
                    <div class="detail-row"><div class="detail-label">Panelist:</div><div class="detail-value">${team.panelist_name ? team.panelist_name : 'No Panelist'}</div></div>
                    <div class="detail-row"><div class="detail-label">Members:</div><div class="detail-value">${team.members ? team.members : 'No Members'}</div></div>
                `;
                modalBody.innerHTML = htmlContent;
            } else {
                modalBody.innerHTML = '<p>Error: Team details not found or an issue occurred.</p>';
            }
        } catch (error) {
            console.error('Error fetching team details:', error);
            modalBody.innerHTML = '<p>Failed to load team details. Please try again.</p>';
        }
    }

    // Add event listeners to all "View" buttons
    openModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const teamId = this.getAttribute('data-team-id');
            fetchTeamDetails(teamId);
        });
    });
});
