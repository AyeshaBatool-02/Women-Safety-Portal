// Function to initialize the map
function initMap() {
    // Check if geolocation is available
    if (navigator.geolocation) {
        // Get the user's current location
        navigator.geolocation.getCurrentPosition(function(position) {
            // Create a map centered on the user's location
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                zoom: 15
            });
            // Add a marker at the user's location
            var marker = new google.maps.Marker({
                position: {lat: position.coords.latitude, lng: position.coords.longitude},
                map: map,
                title: 'Your Location'
            });
        });
    } else {
        // If geolocation is not available, display an error message
        alert('Geolocation is not supported by your browser.');
    }
}
