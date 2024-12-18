import setupSlideshow from './slideshow.js';
import setupRoomEvents from './setupRoomEvents.js';
import setupDatePicker from './datePicker.js';
import setupViewMore from './viewMore.js';

// Initialize the app
document.addEventListener('DOMContentLoaded', () => {
    setupSlideshow(); // Initialize the slideshow
    setupRoomEvents(); // Set up event listeners for room interactions
    setupDatePicker(); // Initialize date pickers for all rooms
    setupViewMore(); // Initialize the "View More" functionality
});
