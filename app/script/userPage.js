const url = new URL(window.location.href);
const li_desideri = $('#li_lista_desideri').text();
const nav_menu = $('#menu').text();
const carousel = $('#single-carousel').text();
const carouselIndicatorFirst = $('#carousel-first-indicator').text();
const carouselIndicator = $('#carousel-indicator').text();
const carouselItem = $('#carousel-item').text();
let genreInput = $('#genre-input').text();
let currentUser = {};

const createBootstrapTable = (arrayObj, where) => {
  const keys = Object.keys(arrayObj[0]);
  console.log(keys);

  where.append(
    `
        <div class="table-responsive">
          <table class="table">
              <thead>
                  <tr class="intestazione"></tr>
              </thead>
              <tbody class="table-body">
                  
              </tbody>
              </table>
        </div>`
  );
  $('.intestazione').append(`<th scope="col">#</th>`);

  keys.forEach((el, idx) => {
    if (el != 'id' && el != 'id_type' && el != 'id_genre' && el != 'img_src') {
      $('.intestazione').append(
        `<th class="text-light" scope="col">${el}</th>`
      );
    }
  });

  arrayObj.forEach((el, idx) => {
    const tr = document.createElement('tr');
    $(tr)
      .addClass(`riga${idx}`)
      .html(`<th scope="row" class="text-light">${idx + 1}</th>`)
      .appendTo('.table-body');
  });

  const righe = $('.table-body').children('tr');
  console.log(righe);

  for (let a = 0; a < righe.length; a += 1) {
    for (key of keys) {
      const riga = document.getElementsByClassName(`riga${a}`);
      console.log(key);
      if (
        key != 'id' &&
        key != 'id_type' &&
        key != 'id_genre' &&
        key != 'img_src'
      ) {
        //_____________________________________________________________________________

        if (key === 'title') {
          $(riga).append(
            `<td class="text-light"><a href="${url.origin}/esercizi/tesina/app/eventPage.html?event=${arrayObj[a][key]}" class="nav-link">${arrayObj[a][key]}</a></td>`
          );
        } else {
          $(riga).append(`<td class="text-light">${arrayObj[a][key]}</td>`);
        }
      }
    }
  }
};

$('.favourite-genre').submit((e) => {
  e.preventDefault();
  const data = new URLSearchParams(
    new FormData(document.getElementsByClassName('favourite-genre')[0])
  );
  console.log(data);

  fetch(`${url.origin}/esercizi/tesina/app/api/event/allGenre_prefGenre.php`, {
    method: 'POST',
    body: data,
  })
    .then((res) => res.json())
    .then((res) => {
      alert(`${res.status} : ${res.message}`);
    });
});

const getGenre = () => {
  fetch(`${url.origin}/esercizi/tesina/app/api/event/allGenre_prefGenre.php`)
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        $('.favourite-genre').empty();
        res.data.forEach((el) => {
          console.log(el.genre);

          console.log(genreInput.replaceAll('%genre%', el.genre));

          $('.favourite-genre').append(
            genreInput.replaceAll('%genre%', el.genre)
          );
        });
        $('.favourite-genre').append('<input type="submit" value = "SUBMIT">');
      }
    })
    .catch((err) => {
      console.log;
    });
};

const createAdminContent = () => {
  fetch(`${url.origin}/esercizi/tesina/app/api/user/getCurrent_signUp.php`)
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        console.log(res.data);
        const keys = Object.keys(res.data);

        keys.forEach((el) => {
          currentUser[el] = res.data[el];
        });
        console.log(currentUser);
        console.log(`admin: ${currentUser.admin}`);

        if (currentUser.admin == '1') {
          $('.nav-item').append(`<li>
              <a href="addEvent.html" class="nav-link">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                Add event
              </a>
            </li>
            `);
        }
      } else {
        alert(`${res.status} : ${res.message}`);
      }
    });
};

const tableEvents = () => {
  fetch(`${url.origin}/esercizi/tesina/app/api/event/getAll_create.php`)
    .then((res) => res.json())
    .then((res) => {
      createBootstrapTable(res, $('.main-content'));
    });
};

const carouselEvents = async () => {
  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/event/getAll_create.php`
  );
  const res = await Res.json();
  console.log(res);
  let active = '';
  res.forEach((el, idx) => {
    if (idx == 0) {
      active = 'active';

      $('.carousel-indicators').append(
        carouselIndicatorFirst
          .replace('%idx%', idx)
          .replace('%num_slide%', idx + 1)
      );
    } else {
      active = '';

      $('.carousel-indicators').append(
        carouselIndicator.replace('%idx%', idx).replace('%num_slide%', idx + 1)
      );
    }

    $('.carousel-inner').append(
      carouselItem
        .replace('%active%', active)
        .replace('%Title%', el.title)
        .replace('%img-src%', el.img_src)
    );
  });
};

$(document).ready(() => {
  console.log('ciao');
  $('#sidebar_list').empty();
  $('#sidebar_list').append(nav_menu);
  console.log(carousel);

  carouselEvents();
  tableEvents();

  createAdminContent();
});

whish_list = () => {
  $('#sidebar_list').empty();
  $('#sidebar_list').append('<h4>Lista desideri</h4>');

  fetch(`${url.origin}/esercizi/tesina/app/api/event/getAllWishList.php `)
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        res.data.forEach((el) => {
          $('#sidebar_list').append(
            `<li class="nav-item" ><a class="nav-link" href="${url.origin}/esercizi/tesina/app/eventPage.html?event=${el.title}">${el.title}</a></li>`
          );
        });
      } else {
        $('#sidebar_list').append(res.message);
      }
    })
    .catch((err) => console.log);

  $('#little-sidebar').append(
    "<button type='button' id='go_main' class='btn btn-outline-light' style='margin-left: 30px;' onclick='goBackMenu()'>BACK</button>"
  );
};

const goBackMenu = () => {
  console.log('ciao');
  $('#sidebar_list').empty();
  $('#go_main').remove();
  $('#sidebar_list').append(nav_menu);
};

const logout = async () => {
  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/user/login_logOut.php`
  );
  const res = await Res.json();

  window.location.href = `${url.origin}/esercizi/tesina/app/index.html`;
};
