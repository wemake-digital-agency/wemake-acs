jQuery(function ($) {
  // Check plugin update

  if (
    typeof wmacs_update_param !== "undefined" &&
    !wmacs_update_param.checked
  ) {
    $.ajax({
      url: wmacs_update_param.action_check,

      context: document.body,
    });
  }

  // Run plugin update

  $.fn.wmacs_showUpdateError = function () {
    var $this = $(this),
      $update_message = $this.find(".update-message");

    $update_message
      .attr(
        "class",
        "update-message notice inline notice-warning notice-alt notice-error"
      )

      .html(
        "<p class='notice-text update-text'>" +
          wmacs_language.update_error +
          "</p>"
      );

    $this.removeClass("updating-message");
  };

  $(document).on("click", ".wmacs-update-link", function () {
    var $plugin_update_row = $(this).parents(".plugin-update-tr"),
      $notice = $plugin_update_row.find(".notice");

    $plugin_update_row.addClass("updating-message");

    $.ajax({
      type: "POST",

      dataType: "json",

      url: wmacs_update_param.action_run,

      context: document.body,
    })
      .done(function (data) {
        if (
          typeof data !== "undefined" &&
          typeof data.error !== "undefined" &&
          data.error === 0
        ) {
          $plugin_update_row
            .removeClass("updating-message")
            .addClass("updated");

          $notice
            .removeClass("notice-warning")
            .addClass("updated-message notice-success");
        } else {
          $plugin_update_row.wmacs_showUpdateError();
        }
      })
      .fail(function () {
        $plugin_update_row.wmacs_showUpdateError();
      });

    return false;
  });

  // Settings - color

  if ($(".wmacs-settings-field").length) {
    $(".wmacs-settings-field.-color input").spectrum({
      preferredFormat: "hex",

      showInput: true,

      showPalette: true,

      palette: [
        [
          "White",
          "Silver",
          "Gray",
          "Black",
          "Red",
          "Maroon",
          "Yellow",
          "Olive",

          "Lime",
          "Green",
          "Aqua",
          "Teal",
          "Blue",
          "Navy",
          "Fuchsia",
          "Purple",
        ],
      ],
    });
  }
});
