$(document).ready(function(){
  $('#registerForm').validate({
    //Validation rules
    rules: {
      firstName: "required",
      lastName: "required",
      email: {
        required: true,
        email: true
      },
      password: {
        required: true
      },
      phoneNumber: true,
      physicalAddress: true
    },
    messages: {
      firstName: "Please enter your first name.",
      lastName: "Please enter your last name.",
      email: "Please enter your email address.",
      password: "Please enter a password.",
      phoneNumber: "Please enter a phone number.",
      physicalAddress: "Please enter an address."
    },
    submitHandler: function(/register) {
      form.submit();
    }
  });
});
