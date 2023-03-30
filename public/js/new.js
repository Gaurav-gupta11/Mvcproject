// new.php
$(document).ready(function() {
  $('#email').on('keyup', function() {
    var email = $(this).val();  
  
 
    $.get('/Account/validateEmailAction?email=' + email, function(data) {
      if (data) {
        $('#email').removeClass('is-invalid');
      } else {
        $('#email').addClass('is-invalid');
      }
});
});
  
  $('form').submit(function(event) {
    var name = $('#name').val();
    var password = $('#password').val();
    var repeatPassword = $('#repeat_password').val();
    var email = $('#email').val();
    
    // Validate name input
    if (!/^[A-Za-z]+$/.test(name)) {
      event.preventDefault();
      alert('Name must contain only letters');
      return;
    }
    
    // Validate password input
    if (!/(?=.*[A-Za-z])(?=.*\d).{6,}/.test(password)) {
      event.preventDefault();
      alert('Password must be at least 6 characters long and contain at least one letter and one number');
      return;
    }
    
    // Validate repeat password input
    if (password !== repeatPassword) {
      event.preventDefault();
      alert('Passwords do not match');
      return;
    }
    
    // Check if email is valid
    if ($('#email').hasClass('is-invalid')) {
      event.preventDefault();
      alert('Email is already taken');
      return;
    }

  });
});
