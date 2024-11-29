import './style.css';

console.log('Hello, world!!!!');

// Function to initialize the application
export function init() {
    // Export the openTab function for use in other modules
    window.openTab = openTab;

    // Optionally, open the first tab by default
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector(".tab").click();
    });
}

// Your existing openTab function
export function openTab(evt, tabName) {
    // Hide all tab content
    const tabContents = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
    }

    // Remove the "active" class from all tabs
    const tabs = document.getElementsByClassName("tab");
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].className = tabs[i].className.replace(" active", "");
    }

    // Show the current tab and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Call the init function to set everything up
init();

