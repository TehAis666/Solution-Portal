 // Function to apply dark mode
 function applyDarkMode(isDark) {
    const body = document.body;
    const icon = document.getElementById("themeIcon");
  
    if (isDark) {
      body.classList.add("dark-mode"); // Add dark mode class
      body.style.backgroundColor = "#121212"; // Set background color
      icon.classList.remove("ri-contrast-2-line");
      icon.classList.add("ri-contrast-2-fill"); // Change icon for light mode
    } else {
      body.classList.remove("dark-mode"); // Remove dark mode class
      body.style.backgroundColor = ""; // Reset background color
      icon.classList.remove("ri-contrast-2-fill");
      icon.classList.add("ri-contrast-2-line"); // Change icon for dark mode
    }
  }
  
  // Check user's preference in localStorage
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme) {
    applyDarkMode(savedTheme === "dark");
  }
  
  document
    .getElementById("toggleTheme")
    .addEventListener("click", function () {
      const icon = document.getElementById("themeIcon");
      const isDarkMode = document.body.classList.contains("dark-mode");
  
      // Toggle between light and dark modes
      if (isDarkMode) {
        applyDarkMode(false);
        localStorage.setItem("theme", "light"); // Store preference
      } else {
        applyDarkMode(true);
        localStorage.setItem("theme", "dark"); // Store preference
      }
    });