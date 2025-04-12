window.onload = function () {
  const username = localStorage.getItem("username");
  const welcomeText = document.querySelector(".welcome-section p");
  if (username && welcomeText) {
    welcomeText.textContent = `Welcome ${username}!`;
  }
};

//http://nexusdcp.free.nf/fetch_users.php

fetch("http://localhost/nexus-dcp-backend/fetch_users.php")
  .then((res) => res.json())
  .then((data) => {
    const table = document.querySelector(".data-table");
    const tbody = table.querySelector("tbody");

    tbody.innerHTML = ""; // Clear any existing rows

    // If there are no data, just return
    if (data.length === 0) return;

    // Dynamically create the header row (optional since it's already hardcoded)
    const thead = table.querySelector("thead");
    const headerRow = thead.querySelector("tr");

    // Optionally, you can check if the header already exists and skip this step.

    // Create rows for the table dynamically
    data.forEach((user) => {
      const row = document.createElement("tr");

      // Add each cell to the row based on the user data
      Object.values(user).forEach((value) => {
        const td = document.createElement("td");
        td.textContent = value;
        row.appendChild(td);
      });

      tbody.appendChild(row); // Add row to table body
    });
  });

document.getElementById("update-button").onclick = () => {
  document.getElementById("update-dialog").style.display = "block";
};

document.getElementById("update-save").onclick = () => {
  const id = document.getElementById("update-id").value;
  const username = document.getElementById("update-username").value;
  const password = document.getElementById("update-password").value;

  fetch("http://localhost/nexus-dcp-backend/update_user.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, username, password }),
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.success ? "User updated!" : "Update failed.");
      location.reload();
    });

  document.getElementById("update-dialog").style.display = "none";
};

document.getElementById("delete-button").onclick = () => {
  document.getElementById("delete-dialog").style.display = "block";
};

document.getElementById("delete-confirm").onclick = () => {
  const id = document.getElementById("delete-id").value;

  fetch("http://localhost/nexus-dcp-backend/delete_user.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id }),
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.success ? "User deleted!" : "Delete failed.");
      location.reload();
    });

  document.getElementById("delete-dialog").style.display = "none";
};

const logoutButton = document.getElementById("log-out-button");

logoutButton.addEventListener("click", () => {
  window.location.href = "../pages/log_in.html";
});
