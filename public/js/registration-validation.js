$(document).ready(function(){
  $("form[name='registration']").validate({
    //Validation rules
    rules: {
      firstName: "required",
      lastName: "required",
      email: {
        required: true,
        email: true
      },
      password: "required",
      phone: "required",
      physicalAddress: "required"
    },
    messages: {
      firstName: "Please enter your first name.",
      lastName: "Please enter your last name.",
      email: "Please enter your email address.",
      password: "Please enter a password.",
      phone: "Please enter a phone number.",
      physicalAddress: "Please enter an address."
    },

    submitHandler: function(form) {
      form.submit();
    }
  });
});
