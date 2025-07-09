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