
$(document).on('click', '.open-modal-btn', function () {
    const teamId = $(this).data('team-id');

    $.ajax({
        url: '/controllers/fetchTeamgroup.php',
        method: 'GET',
        data: { team_id: teamId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const team = response.data;
                $('#adviserName').val(team.adviser_name);
                $('#technicalName').val(team.technical_name);
                $('#chairName').val(team.chairman_name);
                $('#majorName').val(team.major_name);
                $('#minorName').val(team.minor_name);
                $('#panelistName').val(team.panelist_name);
                $('#projectTitle').val(team.capstone_title);
                $('#members').val(team.members);
            } else {
                alert(response.error);
            }
        },
        error: function(xhr, status, error) {
            alert('Failed to fetch team info.');
            console.error(error);
        }
    });
});

