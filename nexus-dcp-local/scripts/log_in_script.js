const logInButton = document.getElementById("log-in-button");

logInButton.onclick = function () {
  // ✅ Get values *inside* the click handler
  const usernameInput = document.getElementById("username-input").value;
  const passwordInput = document.getElementById("password-input").value;

  console.log("Sending:", usernameInput, passwordInput); // Debugging

  //http://nexusdcp.free.nf/login.php

  fetch("http://localhost/nexus-dcp-backend/login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      username: usernameInput,
      password: passwordInput,
    }),
  })
    .then((res) => res.text())
    .then((text) => {
      console.log("Raw response:", text);
      try {
        const data = JSON.parse(text);
        if (data.success) {
          alert("Login successful!");
          localStorage.setItem("username", usernameInput);
          window.location.href = "../pages/main.html";
        } else {
          alert("Login failed: " + (data.error || "Invalid credentials"));
        }
      } catch (e) {
        console.error("JSON parse error:", e, text);
        alert("Server error: invalid JSON response");
      }
    })
    .catch((err) => {
      console.error("Fetch error:", err);
      alert("Network error. See console for details.");
    });
};
