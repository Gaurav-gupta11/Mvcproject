$(document).ready(function() {
  // AJAX call to retrieve session ID
  $.ajax({
    url: '/Account/getSessionAction',
    type: 'GET',
    success: function(data) {
      var session_id = data;
      // Use the session ID as needed
      // console.log(session_id);

      // Keep track of email validation status for each email
      var emailValidationStatus = {};

      // Check email availability
      $('#email').on('keyup', function() {
        var email = $(this).val();
        if (emailValidationStatus[email] === undefined) {
          // Email validation has not been done for this email
          // AJAX call to validate email
          $.get('/Account/validateEmailAction', {email: email, session_id: session_id}, function(data) {
            if (data) {
              $('#email').removeClass('is-invalid');
              emailValidationStatus[email] = true; // set validation status to true
            } else {
              $('#email').addClass('is-invalid');
              emailValidationStatus[email] = false; // set validation status to false
            }
          });
        } else if (emailValidationStatus[email]) {
          // Email validation has already been done and email is available
          $('#email').removeClass('is-invalid');
        } else {
          // Email validation has already been done and email is not available
          $('#email').addClass('is-invalid');
        }
      });

      // Form submission
      $('form').submit(function(event) {
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var profilePic = $('#profile_pic').val();

        if (!/^[A-Za-z]+$/.test(name)) {
          alert('Name should contain only alphabets');
          event.preventDefault();
        }

        if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z]{2,}$/i.test(email)) {
          alert('Please enter a valid email address');
          event.preventDefault();
        }

        if (password.length > 0 && (password.length < 6 || !/[A-Za-z]/.test(password) || !/\d/.test(password))) {
          alert('Password should be at least 6 characters long and contain at least one alphabet and one number');
          event.preventDefault();
        }

        // Check email availability
        if (emailValidationStatus[email] === false) { // check the validation status for the current email
          $('#email').addClass('is-invalid');
          event.preventDefault();
          alert('Email is already taken');
          return;
        }

        if (profilePic && !/\.(jpg)$/i.test(profilePic)) {
          alert('Profile picture should be in JPG format only');
          event.preventDefault();
        }
      });
    }
  });
});
