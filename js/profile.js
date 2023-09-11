// // Links

const accountButton = document.getElementById("user-account--section--clicked");
const postButton = document.getElementById("post--clicked");
const usersButton = document.getElementById("users--section--clicked");
const messageButton = document.getElementById("message--clicked");
const sideNav = document.querySelector(".side-nav");

// Admin Post Section
const postSection = document.getElementById("post-section");

// User Section
const usersSection = document.getElementById("users-section");

// User account section
const accountSection = document.querySelector(".user-account--section-clicked");

// Message section
const messageSection = document.getElementById("message-section");

if (postButton) {
  // Add click event listeners
  postButton.addEventListener("click", function () {
    // Add the active class post button
    postButton.classList.add("side-nav--active");
    // remove active class from other buttons
    accountButton.classList.remove("side-nav--active");
    usersButton.classList.remove("side-nav--active");

    // Show the "Post" section
    postSection.style.display = "block";

    // Hide the "Users" section
    usersSection.style.display = "none";

    // Hide the User account section
    accountSection.style.display = "none";
    // Hide the Message section
    messageSection.style.display = "none";
  });
}

if (usersButton) {
  usersButton.addEventListener("click", function () {
    // Add the active class post button
    usersButton.classList.add("side-nav--active");
    // remove active class from other buttons
    accountButton.classList.remove("side-nav--active");
    postButton.classList.remove("side-nav--active");

    // Show the "Users" section
    usersSection.style.display = "block";

    // Hide the "Post" section
    postSection.style.display = "none";

    // Hide the User account section
    accountSection.style.display = "none";
    // Hide the Message section
    messageSection.style.display = "none";
  });
}

if (accountButton) {
  accountButton.addEventListener("click", function () {
    // Add the active class post button
    accountButton.classList.add("side-nav--active");
    // remove active class from other buttons
    postButton.classList.remove("side-nav--active");
    usersButton.classList.remove("side-nav--active");
    messageButton.classList.remove("side-nav--active");
    // Show the User account section
    accountSection.style.display = "block";

    // Hide the "Post" section
    postSection.style.display = "none";

    // Hide the "Users" section
    usersSection.style.display = "none";

    // Hide the Message section
    messageSection.style.display = "none";
  });
}

if (messageButton) {
  messageButton.addEventListener("click", function () {
    console.log("clicked");
    // Add the active class post button
    messageButton.classList.add("side-nav--active");

    // remove active class from other buttons
    accountButton.classList.remove("side-nav--active");
    postButton.classList.remove("side-nav--active");
    usersButton.classList.remove("side-nav--active");
    // Show the "Message" section
    messageSection.style.display = "block";

    // Hide the "Post" section
    postSection.style.display = "none";

    // Hide the "Users" section
    usersSection.style.display = "none";
    // Hide the User account section
    accountSection.style.display = "none";
  });
}
// User profile picture setup part

// Your JavaScript code here
document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("choose-photo-link")
    .addEventListener("click", function (e) {
      e.preventDefault();
      const fileInput = document.createElement("input");
      fileInput.type = "file";
      fileInput.name = "photo";
      fileInput.accept = "image/*";
      fileInput.style.display = "none";

      fileInput.addEventListener("change", function () {
        if (fileInput.files && fileInput.files[0]) {
          const reader = new FileReader();

          reader.onload = function (e) {
            document.getElementById("user-photo").src = e.target.result;
          };

          reader.readAsDataURL(fileInput.files[0]);
        }
        console.log(fileInput.files[0]);
      });

      // Trigger a click on the file input
      fileInput.click();

      // Append the file input to the parent element
      const parentElementImg = document.getElementById("img-input-container");
      parentElementImg.appendChild(fileInput);
    });
});
