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
    }
});
