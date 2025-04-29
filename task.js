
function updateClock() {
    const now = new Date();
    document.getElementById("clock").innerText = now.toLocaleString();
}
setInterval(updateClock, 1000);
updateClock();

// This should be added to your task.js file or included in a script tag in taskmanager.html

document.addEventListener('DOMContentLoaded', function() {
  // Function to fetch verified students and populate the dropdown
  async function fetchVerifiedStudents() {
      try {
          const response = await fetch('fetch_students.php'); // Replace with your actual API endpoint
          const students = await response.json();
          
          const selectElement = document.getElementById('assignTo');
          
          // Clear existing options except the first one
          while (selectElement.options.length > 1) {
              selectElement.remove(1);
          }
          
          // Add new options
          students.forEach(student => {
              const option = document.createElement('option');
              // option.value = student.assign_id; // Using ID number as value
              option.textContent = `${student.student_name}`;
              selectElement.appendChild(option);
          });
      } catch (error) {
          console.error('Error fetching students:', error);
      }
  }
  
  // Call the function when the page loads
  fetchVerifiedStudents();
});

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById("taskForm").addEventListener("submit", function(e) {
    e.preventDefault();
    
    const taskData = {
        title: document.getElementById("taskTitle").value,
        description: document.getElementById("taskDescription").value,
        assigned_to: document.getElementById("assignTo").value,
        deadline: document.getElementById("deadline").value
    };
  
  fetch("save_task.php", {
      method: "POST",
      headers: {
          "Content-Type": "application/json",
      },
      body: JSON.stringify(taskData)
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          alert("Task saved successfully!");
          document.getElementById("taskForm").reset();
          fetchTasks(); // Refresh the task list
      } else {
          alert("Error saving task: " + data.error);
      }
  })
  .catch(error => {
      console.error("Error:", error);
      alert("An error occurred while saving the task.");
  });
});

// Fetch Tasks
function fetchTasks() {
  fetch("fetch_task.php")
      .then(response => response.json())
      .then(data => {
          const tableBody = document.getElementById("taskTableBody");
          tableBody.innerHTML = "";

          if (data.error) {
              console.error("Server Error:", data.error);
              return;
          }

          data.forEach(task => {
              const row = document.createElement("tr");
              row.innerHTML = `
                  <td>${task.title}</td>
                  <td>${task.description}</td>
                  <td>${task.assigned_name}</td>
                  <td>${new Date(task.deadline).toLocaleString()}</td>
                  <td>${task.status}</td>
                  <td>
                      <button class="btn btn-sm btn-primary edit-btn" data-id="${task.title}">Edit</button>
                      <button class="btn btn-sm btn-danger delete-btn" data-id="${task.title}">Delete</button>
                  </td>
              `;
              tableBody.appendChild(row);
          });
      })
      .catch(error => console.error("Error fetching tasks:", error));
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", function() {
  fetchVerifiedStudents();
  fetchTasks();
});
});