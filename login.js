document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let errorMsg = document.getElementById("errorMsg");

    fetch("login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "dashboard.html"; // Redirect to dashboard
        } else {
            errorMsg.textContent = data.message; // Show error message
        }
    })
    .catch(error => {
        console.error("Error:", error);
        errorMsg.textContent = "An error occurred. Please try again.";
    });
});
