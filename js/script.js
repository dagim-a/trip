document.addEventListener('DOMContentLoaded', function() {
    // Tab logic
    const createTripTab = document.getElementById('createTripTab');
    const myTripsTab = document.getElementById('myTripsTab');
    const tripFormContainer = document.getElementById('tripFormContainer');
    const tripListContainer = document.getElementById('tripListContainer');
    createTripTab.addEventListener('click', function() {
        createTripTab.classList.add('active');
        myTripsTab.classList.remove('active');
        tripFormContainer.style.display = '';
        tripListContainer.style.display = 'none';
    });
    myTripsTab.addEventListener('click', function() {
        myTripsTab.classList.add('active');
        createTripTab.classList.remove('active');
        tripFormContainer.style.display = 'none';
        tripListContainer.style.display = '';
    });
    // Trip list tab switching logic
    const upcomingTab = document.getElementById('upcomingTab');
    const personalTab = document.getElementById('personalTab');
    const closedTab = document.getElementById('closedTab');
    const upcomingSection = document.getElementById('upcomingSection');
    const personalSection = document.getElementById('personalSection');
    const closedSection = document.getElementById('closedSection');
    function showTripSection(tab, section) {
        // Remove active from all
        upcomingTab.classList.remove('trip-list-tab-active');
        personalTab.classList.remove('trip-list-tab-active');
        closedTab.classList.remove('trip-list-tab-active');
        upcomingSection.style.display = 'none';
        personalSection.style.display = 'none';
        closedSection.style.display = 'none';
        // Add active to selected
        tab.classList.add('trip-list-tab-active');
        section.style.display = '';
    }
    upcomingTab.addEventListener('click', function() {
        showTripSection(upcomingTab, upcomingSection);
    });
    personalTab.addEventListener('click', function() {
        showTripSection(personalTab, personalSection);
    });
    closedTab.addEventListener('click', function() {
        showTripSection(closedTab, closedSection);
    });
    // Modal popup logic for trip details (event delegation for dynamic content)
    var modal = document.getElementById('descModal');
    var descContent = document.getElementById('descContent');
    var closeModal = document.getElementById('closeModal');
    if (modal && descContent && closeModal) {
        document.body.addEventListener('click', function(e) {
            var btn = e.target.closest('.view-btn');
            if (btn) {
                e.preventDefault();
                // Get all data attributes
                var img = btn.getAttribute('data-img') || '';
                var title = btn.getAttribute('data-title') || '';
                var destination = btn.getAttribute('data-destination') || '';
                var start = btn.getAttribute('data-start') || '';
                var end = btn.getAttribute('data-end') || '';
                var desc = btn.getAttribute('data-desc') || '';
                var email = btn.getAttribute('data-email') || '';
                var transportation = btn.getAttribute('data-transportation') || '';
                var travelers = btn.getAttribute('data-travelers') || '';
                var cost = btn.getAttribute('data-cost') || '';
                var status = btn.getAttribute('data-status') || '';
                // Build HTML (use classes, not inline styles)
                var html = '<div class="trip-detail-modal-flex">';
                html += '<img src="' + img + '" alt="Trip Cover" class="trip-detail-modal-img">';
                html += '<div class="trip-detail-modal-info">';
                html += '<h2>' + title + '</h2>';
                html += '<p><b>Destination:</b> ' + destination + '</p>';
                html += '<p><b>Start Date:</b> ' + start + '</p>';
                html += '<p><b>End Date:</b> ' + end + '</p>';
                html += '<p><b>Description:</b><br>' + desc.replace(/\n/g, '<br>') + '</p>';
                html += '<p><b>Email:</b> ' + email + '</p>';
                html += '<p><b>Transportation:</b> ' + transportation + '</p>';
                html += '<p><b>Number of Travelers:</b> ' + travelers + '</p>';
                html += '<p><b>Trip Cost:</b> $' + cost + '</p>';
                html += '<p><b>Status:</b> ' + status + '</p>';
                html += '<div class="invite-section">';
                html += '<input type="email" class="invite-input" placeholder="Invite by email..." />';
                html += '<button class="invite-btn">Invite</button>';
                html += '<div class="invite-message" style="margin-top:8px;"></div>';
                html += '</div>';
                html += '</div>';
                descContent.innerHTML = html;
                modal.style.display = 'flex';
            }
        });
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
        // Invite logic
        descContent.addEventListener('click', function(e) {
            if (e.target.classList.contains('invite-btn')) {
                var input = descContent.querySelector('.invite-input');
                var message = descContent.querySelector('.invite-message');
                var email = input.value.trim();
                var tripId = descContent.querySelector('.view-btn')?.getAttribute('data-trip-id') || modal.getAttribute('data-trip-id');
                if (!email) {
                    message.textContent = 'Please enter an email.';
                    message.style.color = 'red';
                    return;
                }
                // AJAX request to invite_user.php
                fetch('invite_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: email, trip_id: tripId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = 'Invitation sent!';
                        message.style.color = '#1a7f37';
                        input.value = '';
                    } else {
                        message.textContent = data.error || 'Failed to send invitation.';
                        message.style.color = 'red';
                    }
                })
                .catch(() => {
                    message.textContent = 'Network error.';
                    message.style.color = 'red';
                });
            }
        });
    }
    // Family search action buttons logic
    if (document.querySelector('.family-list')) {
        document.querySelector('.family-list').addEventListener('click', function(e) {
            // Add Friend
            if (e.target.closest('.add-friend-btn')) {
                const btn = e.target.closest('.add-friend-btn');
                const userId = btn.getAttribute('data-user-id');
                let errorMsg = btn.parentElement.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.style.color = 'red';
                    errorMsg.style.fontSize = '0.95rem';
                    errorMsg.style.marginTop = '8px';
                    btn.parentElement.appendChild(errorMsg);
                }
                btn.disabled = true;
                fetch('add_friend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'friend_id=' + encodeURIComponent(userId)
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    if (data.success) {
                        window.location.href = 'friend_trips.php?userId=' + encodeURIComponent(userId);
                    } else {
                        btn.title = data.message;
                        btn.style.background = '#dc3545';
                        btn.style.color = '#fff';
                        errorMsg.textContent = data.message;
                    }
                });
            }
            // Join Group
            if (e.target.closest('.join-group-btn')) {
                const btn = e.target.closest('.join-group-btn');
                const userId = btn.getAttribute('data-user-id');
                let errorMsg = btn.parentElement.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.style.color = 'red';
                    errorMsg.style.fontSize = '0.95rem';
                    errorMsg.style.marginTop = '8px';
                    btn.parentElement.appendChild(errorMsg);
                }
                btn.disabled = true;
                fetch('join_group.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'group_id=' + encodeURIComponent(userId)
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    if (data.success) {
                        window.location.href = 'group_trips.php?groupId=' + encodeURIComponent(userId);
                    } else {
                        btn.title = data.message;
                        btn.style.background = '#dc3545';
                        btn.style.color = '#fff';
                        errorMsg.textContent = data.message;
                    }
                });
            }
            // View Profile
            if (e.target.closest('.view-profile-btn')) {
                const link = e.target.closest('.view-profile-btn');
                window.location.href = link.getAttribute('href');
            }
        });
    }
});
