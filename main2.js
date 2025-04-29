
function checkLoginStatus() {
   
    fetch('check_session.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (!data.logged_in) {
            window.location.href = 'login.html'; 
        }
    })
    .catch(error => {
        console.error('Error checking login status:', error);
        window.location.href = 'login.html'; 
    });
}

if (window.location.pathname === '/dashboard.html') {
    checkLoginStatus();  
}

function updateClock() {
    const now = new Date();
    document.getElementById("clock").innerText = now.toLocaleString();
}
setInterval(updateClock, 1000);
updateClock();

function fetchUserProfile() {
    fetch("profile.php")
        .then(response => response.json())
        .then(data => {
            if (data.student_name) {
                document.getElementById("Student").textContent = data.student_name;
            }
            if (data.profile_image) {
                document.getElementById("profileImage").src = "./" + data.profile_image;
            }
        })
        .catch(error => console.error("Error fetching user profile:", error));
}

function fetchVerifiedUsers() {
    fetch("verified_users.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.count !== undefined) {
                document.getElementById("verifiedUsersCount").innerText =
                    data.count;
            } else {
                console.error("Error:", data.error);
            }
        })
        .catch((error) =>
            console.error("Error fetching verified users:", error)
        );
}

document.getElementById("editButton").addEventListener("click", function () {
    document.querySelectorAll("#editProfileForm input, #editProfileForm select").forEach(input => input.removeAttribute("disabled"));
    document.getElementById("editButton").classList.add("d-none");
    document.getElementById("saveButton").classList.remove("d-none");
});

fetch("profile.php")
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text(); 
    })
    .then(text => {
        try {
            const data = JSON.parse(text); 
            document.getElementById("editStudentName").value = data.student_name || "";
            document.getElementById("editSchool").value = data.school || "";
            document.getElementById("editSchoolAddress").value = data.school_address || "";
            document.getElementById("editContact").value = data.contact || "";
            if (data.profile_image) {
                document.getElementById("editProfileImagePreview").src = "./" + data.profile_image;
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
        }
    })
    .catch(error => {
        console.error("Error fetching profile:", error);
    });

// Handle Profile Picture Preview
document.getElementById("editProfileImage").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("editProfileImagePreview").src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Handle Save Profile
document.getElementById("editProfileForm").addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData();
    formData.append("student_name", document.getElementById("editStudentName").value);
    formData.append("school", document.getElementById("editSchool").value);
    formData.append("school_address", document.getElementById("editSchoolAddress").value);
    formData.append("contact", document.getElementById("editContact").value);
    const profileImage = document.getElementById("editProfileImage").files[0];
    if (profileImage) {
        formData.append("profile_image", profileImage);
    }

    fetch("updates.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Profile updated successfully!");
                location.reload();
            } else {
                alert("Error updating profile.");
            }
        })
        .catch(error => console.error("Error:", error));
});

// Fetch Students
function fetchStudents() {
    fetch("fetch_students.php")
        .then(response => response.json())
        .then(data => {
            console.log("Fetched students:", data);

            if (data.error) {
                console.error("Server Error:", data.error);
                return;
            }

            const tableBody = document.getElementById("tableBody");
            tableBody.innerHTML = "";

            data.forEach(student => {
                const isVerified = parseInt(student.is_verified) === 1;
                const statusClass = isVerified ? "status-verified" : "status-not-verified";
                const statusText = isVerified ? "Verified" : "Not Verified";

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${student.assign_id}</td>
                    <td>${student.student_name}</td>
                    <td>${student.school}</td>
                    <td>${student.school_address}</td>
                    <td>${student.contact}</td>
                    <td class="${statusClass}">${statusText}</td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching students:", error));
}

// Fetch student data on page load
fetchStudents();

// Fetch user profile on page load
fetchUserProfile();

// Fetch verified users on page load and update every 5 seconds
fetchVerifiedUsers();
setInterval(fetchVerifiedUsers, 5000);
