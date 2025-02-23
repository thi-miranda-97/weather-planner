// Theme toggles

$("#theme-toggle").on("click", function () {
  const currentTheme = $("html").attr("data-theme");
  if (currentTheme === "light") {
    $("html").attr("data-theme", "dark");
  } else {
    $("html").attr("data-theme", "light");
  }
});

// Card hover animation expending
$(document).ready(function () {
  // Iterate over each card and add click event listener
  $("#next-days .card").each(function () {
    $(this).click(function () {
      // Remove the active class from all cards
      removeActiveClass();

      // Add active class to the clicked card
      $(this).addClass("active");
    });
  });

  function removeActiveClass() {
    // Remove the active class from all cards
    $("#next-days .card").removeClass("active");
  }
});
