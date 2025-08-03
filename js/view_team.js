
const td = document.getElementById('td').value;

function fetchTeamById(td) {
    
    $.ajax({
        url: '/controllers/getTeamById.php',
        method: 'GET',
        data: { td: td },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const team = response.data;

                $('.data-cell-title').text(team.capstone_title);
                $('.data-cell-adviser').text(team.adviser_name);
                $('.data-cell-technical').text(team.technical_name);
                $('.data-cell-chairman').text(team.chairman_name);
                $('.data-cell-major').text(team.major_name);
                $('.data-cell-minor').text(team.minor_name);
                $('.data-cell-panelist').text(team.panelist_name);

                const memberList = $('.team-members-list');
                memberList.empty();
                team.members.forEach(member => {
                    memberList.append(`<li>${member}</li>`);
                });

            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('An error occurred while fetching team data.');
        }
    });
}

