const signupButton = document.getElementById("signup-button");

signupButton.addEventListener("click", function () {
  const username = document.getElementById("username-signup").value.trim();
  const password = document.getElementById("password-signup").value;
  const confirmPassword = document.getElementById(
    "confirm-password-signup"
  ).value;

  if (!username || !password || !confirmPassword) {
    alert("Please fill out all fields.");
    return;
  }

  if (password !== confirmPassword) {
    alert("Passwords do not match.");
    return;
  }

  //http://localhost/nexus-dcp-backend/signup.php
  // http://nexusdcp.free.nf/signup.php

  fetch("http://localhost/nexus-dcp-backend/signup.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username: username, password: password }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Sign-up successful! You can now log in.");
        window.location.href = "log_in.html";
      } else {
        alert("Error: " + (data.error || "Unknown error"));
      }
    })
    .catch((err) => {
      console.error("Fetch error:", err);
      alert("Network error. See console for details.");
    });
});
