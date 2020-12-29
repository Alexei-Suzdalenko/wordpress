// en la pagina principal cambiamos taxnometrias de los productos
let selectField = document.getElementById("categorias-productos");
let renderContainer = document.getElementById("resultado-productos");
if (selectField) {
  selectField.addEventListener("change", function (e) {
    e.preventDefault();

    let info = new FormData();
    info.append("action", "pgFiltroProductos");
    info.append(
      "categoria",
      selectField.options[selectField.selectedIndex].value
    );

    let data = new URLSearchParams(info);
    fetch(pg.ajaxurl, {
      method: "POST",
      body: info,
    })
      .then((res) => res.json())
      .catch((error) => {
        console.log(error);
      })
      .then((data) => {
        console.log(data);
        let html = "";
        data.forEach((item) => {
          html +=
            '<div class="col-md-4 col-12 my-3"><figure>' +
            item.imagen +
            '</figure><h4 class="my-2"><a href="' +
            item.link +
            '">' +
            item.titulo +
            "</a></h4></div>";
        });
        renderContainer.innerHTML = html;
      });
  });
}



// get API test
let res = document.getElementById("res");

function startApi() { console.log('startApi');
  fetch(pg.apiurl + 'novedades/3' )
    .then((res) => res.json())
    .catch((error) => {
      console.log(error);
    })
    .then((data) => {
      console.log(data);
      let html = "";
      data.forEach((item) => {
        html += '<div class="col-md-4 col-12 my-3"><figure>' + item.imagen + '</figure><h4 class="my-2"><a href="' + item.link + '">' + item.titulo + "</a></h4></div>";
      });
      res.innerHTML = html;
    });
}
startApi();