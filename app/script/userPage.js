//TODO:
//TODO: FARE GRAFICO

//- to remove of wish list an element
//- per i generi preferiti creare tabella apposita degli eventi ai quali si ha messo "like" e fare lo stesso controllo che ho fatto con la wish list
//&#x1F497; -> heart emoji
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
  //console.log(keys);

  arrayObj.forEach((el) => {
    delete el['discounted'];
    delete el['id'];
    delete el['id_type'];
    delete el['id_genre'];
    delete el['img_src'];
    delete el['tot_tickets'];

    el.ticket_price += ' $';
  });
  const keys = Object.keys(arrayObj[0]);

  console.log(arrayObj);

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
    $('.intestazione').append(`<th class="text-light" scope="col">${el}</th>`);
  });

  arrayObj.forEach((el, idx) => {
    const tr = document.createElement('tr');
    $(tr)
      .addClass(`riga${idx}`)
      .html(`<th scope="row" class="text-light">${idx + 1}</th>`)
      .appendTo('.table-body');
  });

  const righe = $('.table-body').children('tr');
  //console.log(righe);

  for (let a = 0; a < righe.length; a += 1) {
    for (key of keys) {
      const riga = document.getElementsByClassName(`riga${a}`);
      //console.log(key);

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
};

const createAdminContent = () => {
  console.log('inizio admin content');
  fetch(`${url.origin}/esercizi/tesina/app/api/user/getCurrent_signUp.php`)
    .then((res) => res.json())
    .then((res) => {
      console.log('ciao');
      if (res.status == 'success') {
        console.log(res.data);
        const keys = Object.keys(res.data);

        keys.forEach((el) => {
          currentUser[el] = res.data[el];
        });
        //console.log(currentUser);
        //console.log(`admin: ${currentUser.admin}`);

        if (currentUser.admin == '1') {
          $('#sidebar_list').append(`
            <li class="nav-item">
              <a href="addEvent.html" class="nav-link">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                Add event
              </a>
            </li>
            
            `);
          $('#sidebar_list').append(`
            <li class="nav-item">
              <a href="graphics.php" class="nav-link">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>

                Charts
              </a>
            </li>
            `);
          console.log('fine admin content');
        } else {
          $('#sidebar_list').append(`
            <li class="nav-item">
              <a href="#" class="nav-link" onclick="becomeAdmin()" data-bs-toggle="modal" data-bs-target="#becomeAdminModal">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                Became admin
              </a>
              
            </li>
            `);
        }
      } else {
        alert(`${res.status} : ${res.message}`);
      }
    })
    .catch((err) => console.log(err));
};

const tableEvents = () => {
  fetch(`${url.origin}/esercizi/tesina/app/api/event/getAll_create.php`)
    .then((res) => res.json())
    .then((res) => {
      createBootstrapTable(res, $('.main-content'));
    })
    .catch((err) => console.log);
};

//TODO:  get all with genre filters

const carouselEvents = async () => {
  const Pref = await fetch(
    `${url.origin}/esercizi/tesina/app/api/event/preferences.php`
  );
  const pref = await Pref.json();
  let Res = null;
  if (pref.status == 'success' && !pref.data.length == 0) {
    //se ha almeno un genere preferito
    console.log(pref.data); //lista generi degli eventi più presenti nella lista nei desideri
    const genrePrefer = pref.data[0].genre;

    Res = await fetch(
      `${url.origin}/esercizi/tesina/app/api/event/getAll_create.php?genre=${genrePrefer}`
    );
  } else {
    alert(`unable to get preferences: ${pref.message}`);
    Res = await fetch(
      `${url.origin}/esercizi/tesina/app/api/event/getAll_create.php`
    );
  }

  const res = await Res.json();
  //console.log(res);
  let active = '';
  res.slice(0, 3).forEach((el, idx) => {
    //res.slice perchè voglio solo i primi 3 della lista di tutti gli eventi
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
  //console.log('ciao');
  $('#sidebar_list').empty();
  $('#sidebar_list').append(nav_menu);
  //console.log(carousel);

  carouselEvents();
  tableEvents();

  const message = url.searchParams.get('message');
  if (message) {
    alert(message);
  }

  createAdminContent();
});

whish_list = () => {
  $('#sidebar_list').empty();
  $('#sidebar_list').append('<h4>Lista desideri</h4>');

  fetch(`${url.origin}/esercizi/tesina/app/api/event/getAllWishList.php `)
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        res.data.forEach((el, idx) => {
          $('#sidebar_list').append(
            `<li class="nav-item wish-list-item" id="idx-${idx}">
            <a class="nav-link" href="${url.origin}/esercizi/tesina/app/eventPage.html?event=${el.title}">${el.title}</a>
            <a class="xButton" href="#" onclick="remove('${el.title}' , ${idx})">&#x2718;</a>
            </li>`
          );
        });
      } else {
        $('#sidebar_list').append(res.message);
      }
    })
    .catch((err) => console.log);

  $('#sidebar').append(
    "<button type='button' id='go_main' class='btn btn-outline-light go_main' style='margin-left: 30px;' onclick='goBackMenu()'>BACK</button>"
  );
};

const remove = (title, idx) => {
  console.log(idx);
  console.log(document.getElementById(`idx-${idx}`));

  fetch(
    `${url.origin}/esercizi/tesina/app/api/event/deleteOneWishList.php?title=${title}`
  )
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        document.getElementById(`idx-${idx}`).remove();
      }

      alert(`${res.status} : ${res.message}`);
    })
    .catch((err) => console.log(err));
};

const goBackMenu = () => {
  $('#sidebar_list').empty();
  $('#go_main').remove();
  $('#sidebar_list').append(nav_menu);
  createAdminContent();
};

const logout = async () => {
  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/user/login_logOut.php`
  );
  const res = await Res.json();

  window.location.href = `${url.origin}/esercizi/tesina/app/index.html`;
};
