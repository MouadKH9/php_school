let limit = 10;
$("button.valider").click(function (e) {
  e.preventDefault();
  $("input")
    .toArray()
    .forEach(input => {
      if (!valider($(input).val())) return;
    });
  showLoading();
  $.post("partials/ops.php?op=add", getData(null), function (res) {
    res = JSON.parse(res);
    hideLoading();
    if (res.status === "ok") {
      refresh();
      notification("success", "Etudiant ajoute!");
      $(".modal").modal("hide");
      $(".modal input").val("");
    } else notification("danger", "Erreur lors de l'ajout d'etudiant");
  });
});

$("input").change(function (e) {
  if (!valider(e.target.value))
    $(e.target)
    .parent()
    .addClass("error");
  else
    $(e.target)
    .parent()
    .removeClass("error");
});

function refresh(loading = false) {
  let sort = $("#sort").val();
  let search = $("#search").val();
  $.get(`partials/ops.php?op=getAll&search=${search}&sort=${sort}&limit=${limit}`, function (
    res
  ) {
    res = JSON.parse(res);
    if (res.status === "ok") {
      $("tbody").html("");
      if (res.data.length === 0) {
        $(".empty").show();
        return false;
      }
      $(".empty").hide();
      res.data.forEach(el => {
        $("tbody").append(`
          <tr>
          <th scope="row">${el.id}</th>
          
          <td><span>${
            el.nom
          }</span><input class="form-control edit-nom" value="${el.nom}"/></td>
          <td><span>${
            el.prenom
          }</span><input class="form-control edit-prenom" value="${
          el.prenom
        }"/></td>
          <td>
            <button onclick="showEdit(this)" data-toggle="tooltip" data-placement="left" title="Modifier" ><i class="fas fa-user-edit"></i></button>
            <button data-id='${
              el.id
            }' onclick='confirm(this)'  data-toggle="tooltip" data-placement="right" title="Supprimer" ><i class="fas fa-user-minus"></i></button>
            <button data-id="${
              el.id
            }" onclick="edit(this)" id="add" class="edit-confirm">Valider</button>
            </td>
          </tr>
        `);
        if (loading) ScrollReveal().sync();
        if (res.count < limit) $("#show").hide();
        else $("#show").show();
        strong();
      });
    } else
      notification("danger", "Erreur lors de la recuperation des etudiants");
  });
}

// Function pour valider les champs
function valider(value) {
  let regex = /[^A-Z a-z]+/g;
  return !value.match(regex);
}

function strong() {
  let query = $("#search").val();
  if (query.length === 0) return;
  var foundin = $(`td span:contains("${query}")`).toArray();
  foundin.forEach(el => {
    let old = $(el).html();
    if (old.includes("span")) return;
    $(el).html(old.replace(query, "<span class='strong'>" + query + "</span>"));
  });

}

function getData(id) {
  return {
    id,
    nom: $("#nom").val(),
    prenom: $("#prenom").val()
  };
}

function showEdit(el) {
  $(".edit").removeClass("edit");
  $(el)
    .parent()
    .parent()
    .addClass("edit");
  $(".edit-prenom").focus();
}

function edit(el) {
  let id = $(el).data("id");

  $.post(
    "partials/ops.php?op=edit", {
      id,
      nom: $(el)
        .parent()
        .parent()
        .find(".edit-nom")
        .val(),
      prenom: $(el)
        .parent()
        .parent()
        .find(".edit-prenom")
        .val()
    },
    function (res) {
      res = JSON.parse(res);
      if (res.status === "ok") {
        $(".edit").removeClass("edit");
        notification("success", "Etudiant modifie!");
        refresh();
      } else
        notification(
          "danger",
          "Erreur lors de la modification d'etudiant #" + id
        );
    }
  );
}

function showLoading() {
  $("button.valider .fa-check").hide();
  $("button.valider .fa-spinner").show();
}

function hideLoading() {
  $("button.valider .fa-check").show();
  $("button.valider .fa-spinner").hide();
}

function notification(type, message) {
  var numItems = $(".notification").length;

  var div =
    '<div id="notification-' +
    numItems +
    '" class="notification alert alert-' +
    type +
    '" style="top:' +
    (15 + 70 * numItems) +
    'px">' +
    message +
    '<span aria-hidden="true">&times;</span></div>';

  $(div).prependTo("body");

  setTimeout(function () {
    $("#notification-" + numItems).hide("slow");
    $("#notification-" + numItems).remove();
    $(".notification").css("top", function () {
      var num = parseInt($(this).css("top")) - 70;
      return num.toString() + "px";
    });
  }, 5000);
}

// Les animation d'entres
ScrollReveal().reveal("tr", {
  interval: 100
});

//  Initialisations
$('[data-toggle="tooltip"]').tooltip();
$(".fa-spinner").hide();
$(document).ready(() => {
  refresh(true);
  $(".confirm").hide();
  $(".black").hide();
});
$(document).on("click", ".notification", function () {
  $(this).remove();
});

$("#show").click(function (e) {
  limit += 10;
  refresh(true);
});
