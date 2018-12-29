$(".confirm #cancel").click(function(e) {
  hideConfirm();
});

function confirm(el) {
  let id = $(el).data("id");
  showConfirm();
  $(".confirm strong").html(id);
  $(".confirm #confirm").attr("data-id", id);
}
function supp(el) {
  var id = $(".confirm strong").html();
  console.log("deleting user " + id);

  $.post("partials/ops.php?op=delete", { id }, function(res) {
    console.log(res);
    hideConfirm();
    refresh();
  });
}

function hideConfirm() {
  $(".black").hide();
  $(".confirm").hide();
}

function showConfirm() {
  $(".black").show();
  $(".confirm").show();
}
