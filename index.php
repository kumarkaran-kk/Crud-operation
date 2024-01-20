<?php include("connection.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="style.css">

  <style>
  </style>
</head>

<body>
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form id="registrationForm" action="#" method="POST" enctype="multipart/form-data">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" name="fname" placeholder="Enter your name" required>
          </div>
          <div class="input-box">
            <span class="details">Age</span>
            <input type="number" name="age" placeholder="Enter your age" required>
          </div>
          <div class="input-box">
            <span class="details">Email Id</span>
            <input type="email" name="email" placeholder="Enter your email id" required>
          </div>
          <div class="input-box">
            <span class="details">Weight</span>
            <input type="number" name="weight" placeholder="Enter your weight (In KG)" required>
          </div>
        </div>

        <div class="gender-details">
          <label for="gender">Gender</label>
          <select name="gender" id="gender">

            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Prefer not to say">Prefer not to say</option>

          </select>
        </div>



        <div class="input-box upload">
          <span class="details">Upload file</span>
          <input type="file" name="pdf" accept=".pdf, image/*" required>
        </div>
        <div class="button">
          <input type="submit" name="register" value="Submit">
        </div>
      </form>
      <br>

      <!-- for get pdf -->
      <form id="fetchForm" class="details" method="POST">
        <div class="input-box" style="margin-bottom: 10px;">
          <span class="details">Want To Get Your Uploaded File</span>
          <input type="email" name="email" id="email" class="details" placeholder="Enter your registered email id" required style="height: 40px; width: 100%; outline: none; font-size: 16px; border-radius: 5px; padding: 5px 10px; border: 1px solid #ccc; background-color: #f2f2f2;">

        </div>
        <div class="button">
          <button type="submit" target="_blank" name="fetch" style="height: 40px; width: 120px; border-radius: 5px; border: none; color: #fff; font-size: 16px; font-weight: 500; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; background-color: #9b59b6; margin: 0 auto;">Fetch</button>
        </div>
        <div class="button">
          <a id="clickableText" href="login1.php" target="_blank" style="display: block; height: 60px; width: 200px; border-radius: 5px; border: none; color: #fff; font-size: 16px; font-weight: 500; letter-spacing: 1px; text-align: center; text-decoration: none; line-height: 60px; cursor: pointer; transition: all 0.3s ease; background-color: #9b59b6; margin: 0 auto;">Click to edit your info</a>
        </div>

      </form>
    </div>
  </div>
  <!-- for pop-up message -->
  <div id="popup" class="popup">
    <div class="popup-content">
      <span class="close" onclick="closePopup()">&times;</span>
      <div id="popup-message" class="message"></div>
      <div id="popup-download-link" class="download-link"></div>
    </div>
  </div>

  <script>
    // Function to create and display the pop-up message
    function showPopup(message) {
      const popup = document.getElementById('popup');
      const messageElem = document.getElementById('popup-message');
      const downloadLink = document.getElementById('popup-download-link');
      const closeBtn = document.querySelector('.popup .close');

      messageElem.innerHTML = message;
      downloadLink.innerHTML = '';
      popup.style.display = 'flex';

      closeBtn.addEventListener('click', () => {
        popup.style.display = 'none';
      });
    }

    // Function to close the pop-up message
    function closePopup() {
      const popup = document.getElementById('popup');
      popup.style.display = 'none';
    }

    // Add an event listener to the registration form submission
    document.getElementById('registrationForm').addEventListener('submit', (event) => {
      event.preventDefault(); // Prevent form submission

      const form = event.target;
      const formData = new FormData(form);

      fetch('register.php', {
          method: 'POST',
          body: formData
        })
        .then((response) => response.text())
        .then((data) => {
          showPopup(data);
          form.reset();
          handleGenderSelection();
        })
        .catch((error) => {
          console.log('Error:', error);
        });
    });

    // Add an event listener to the fetch form submission
    document.getElementById('fetchForm').addEventListener('submit', (event) => {
      event.preventDefault(); // Prevent form submission

      const email = document.getElementById('email').value;

      fetch('call.php', {
          method: 'POST',
          headers: {
            'Content-type': 'application/x-www-form-urlencoded'
          },
          body: `email=${encodeURIComponent(email)}`
        })
        .then((response) => response.text())
        .then((data) => {
          if (data.startsWith('Error:')) {
            console.log(data);
          } else {
            showPopup(`<a href="${data}">Download File</a>`);
          }
        })
        .catch((error) => {
          console.log('Error:', error);
        });
    });
  </script>
</body>

</html>