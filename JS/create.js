$(() => {
  $('#createForm').submit(function (e) {
    e.preventDefault();

    const first_name = $('#first_name').val();
    const last_name = $('#last_name').val();
    const email = $('#email').val();
    const phone_number = $('#phone_number').val();

    const createObj = {
      first_name,
      last_name,
      email,
      phone_number,
    };

    $.ajax({
      url: '/API/addContact.php',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(createObj),
      success: function (response, status, jqXHR) {
        if (response.success || jqXHR.status === 200) {
          window.location = '../dashboard.php';
        } else {
          alert('Contact Creation Failed!:' + response.message);
          window.location = '../dashboard.php';
        }
      },
      error: function (error) {
        alert('Contact Creation Failed!:' + error.message);
        window.location = '../dashboard.php';
      },
    });
  });
});