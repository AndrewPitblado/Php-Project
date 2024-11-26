// Code responsible for auto-sliding navbar menu buttons for user
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector("nav");
  if (navbar) {
    const maxScrollLeft = navbar.scrollWidth - navbar.clientWidth;

    // Scroll to the end and then back to the start
    navbar.scrollTo({ left: maxScrollLeft, behavior: "smooth" });
    navbar.classList.add("scroll-animate"); // Add a class to trigger animation

    setTimeout(() => {
      navbar.scrollTo({ left: maxScrollLeft, behavior: "smooth" });
      setTimeout(() => {
        navbar.scrollTo({ left: 0, behavior: "smooth" });
        navbar.classList.remove("scroll-animate"); // Remove the class after animation
      }, 250); // Adjust this timing to ensure the last button is visible
    }, 1000); // Match this to the CSS animation duration
  }

    // Handle active class for sorting buttons
    const sortingForm = document.getElementById("sorting-form");
    if (sortingForm) {
      const defaultSortByButton = sortingForm.querySelector('button[name="sort_by"][value="patient.lastname"]');
      const defaultOrderButton = sortingForm.querySelector('button[name="order"][value="ASC"]');
      defaultSortByButton.classList.add("active");
      defaultOrderButton.classList.add("active");
  
      sortingForm.addEventListener("click", (event) => {
        if (event.target.tagName === "BUTTON") {
          event.preventDefault(); // Prevent the default form submission
  
          const group = event.target.getAttribute("data-group");
          const buttons = sortingForm.querySelectorAll(`button[data-group="${group}"]`);
          buttons.forEach((button) => button.classList.remove("active"));
          event.target.classList.add("active");
  
          // Perform AJAX request to sort data
          const formData = new FormData();
          formData.append(event.target.name, event.target.value);
  
          fetch("sort_patients.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.text())
            .then((data) => {
              const tableBody = document.querySelector("#patient-table tbody");
              tableBody.innerHTML = data;
            })
            .catch((error) => console.error("Error:", error));
        }
      });
    }
  // Add falling letters animation to h1 and h2 elements with the animate-heading class
  const headings = document.querySelectorAll(".animate-heading");
  headings.forEach((heading) => {
    const text = heading.textContent;
    heading.innerHTML = "";
    heading.classList.add("falling-letters");
    Array.from(text).forEach((letter, index) => {
      const span = document.createElement("span");
      span.textContent = letter;
      span.style.animationDelay = `${index * 0.1}s`;
      if (letter === " ") {
        span.style.marginRight = "0.25em"; // Adjust space between words
      }
      heading.appendChild(span);
    });
  });
  // Add slide-up or fade-in animation to content-container elements
  const contentContainers = document.querySelectorAll(".content-container");
  contentContainers.forEach((container) => {
    container.classList.add("slide-up"); // or "fade-in" for fade animation
  });
   

});

