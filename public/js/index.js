$(document).ready(function () {
    checkPreviouslySelected();

    $('input[type="checkbox"]').each(function () {
        checkboxQueryChange($(this));
    });

    $('input[type="button"]').each(function () {
        $(this).click(function () {
            //Add ajax here
        });
    });
});

/**
 * Checks the checkboxes that were checked previously by checking the query string
 * 
 * @returns {undefined}
 */
function checkPreviouslySelected() {
    var string = window.location.search;

    var checkboxes = [];
    $('input[type="checkbox"]').each(function () {
        checkboxes.push($(this));
    });

    checkboxes.forEach(function (cb) {
        if (string.includes(cb.attr("name") + cb.attr("id") + "=" + cb.val())) {
            cb.prop("checked", true);
        }
    });
}

/**
 * Creates the change event for the checkbox so that it add or removes the query variables when needed
 * 
 * @param {type} checkboxElement
 * @returns {undefined}
 */
function checkboxQueryChange(checkboxElement) {
    var queryVariable = checkboxElement.attr("name") + checkboxElement.attr("id") + "=" + checkboxElement.val();
    checkboxElement.change(function () {
        var string = window.location.search;
        if (string.charAt(0) !== "?") {
            string = "?" + string;
        }

        if (checkboxElement.is(':checked')) { // If the checkbox is checked
            if (!(string[string.length - 1] === "?" || string[string.length - 1] === "&")) {
                string = string + "&";
            }
            string = string + queryVariable;
        } else {
            string = string.replace(queryVariable + "&", "");
            string = string.replace(queryVariable, "");

            if (string[string.length - 1] === "&") {
                string = string.substring(0, string.length - 1);
            }
        }

        window.location.href = string;
    });
}