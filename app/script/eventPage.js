const url = new URL(window.location.href);
const img = $('#event-img').text();
let eventTitle = '';
if (!url.searchParams.get('event')) {
  window.location.href = `${url.origin}/esercizi/tesina/app/userPage.php`;
} else {
  eventTitle = url.searchParams.get('event');
}

console.log(eventTitle);

const jsUcfirst = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
};

const createMap = async (lat, lng, title, place) => {
  var map = L.map('mapid').setView([lat, lng], 13);

  L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png' /*, {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }*/
  ).addTo(map);

  L.marker([lat, lng])
    .addTo(map)
    .bindPopup(`<b>${title}</b>\n${place}`)
    .openPopup();
};
const createEventSheet = (event) => {
  delete event.id_type;
  delete event.id_genre;
  delete event.id;
  delete event.discounted;
  delete event.tot_tickets;
  delete event.place_id;
  delete event.lat;
  delete event.lng;

  console.log(event);

  for (key of Object.keys(event)) {
    if (key != 'img_src') {
      $('#caratteristics').append(
        `<li class="list-group-item bg-transparent text-light">${jsUcfirst(
          key
        )}: ${event[key]}</li>`
      );
    }
  }
  $('.sheet-description').append(img.replace('%img_src%', event.img_src));
};

$(document).ready(() => {
  fetch(
    `${url.origin}/esercizi/tesina/app/api/prefer_events/addWishLikeList_exist.php?title=${eventTitle}`
  )
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        $('.sheet-intestation').prepend(
          `<h2 class="text-light text-center" style="width:100%;">${eventTitle}</h2><h2 class="text-light like" style="width:10%;"><a href="#" onclick="addWishList(1)"><i class="fa-heart ${
            res.message == 'not exist' ? 'far' : 'fas'
          }" id="hearth"></i></a></h2>`
        );
      }
    })
    .catch((err) => {
      console.log(err);
    });

  fetch(
    `${url.origin}/esercizi/tesina/app/api/event/getOne.php?title=${eventTitle}`
  )
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        console.log(res.data);
        createMap(res.data.lat, res.data.lng, res.data.title, res.data.place);

        createEventSheet(res.data);
      } else {
        console.log(res.message);
      }
    })
    .catch((err) => {
      console.log(err);
    });

  fetch(`${url.origin}/esercizi/tesina/app/api/user/getCurrent_signUp.php`)
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'fail') {
        alert(`${res.status}: ${res.message}`);
      } else {
        const user = res.data;
        $('.intestation').append(
          `<h2 class="text-center text-light">Current balance: ${user.aviable_balance} $</h2>`
        );
      }
    });
});

const addWishList = async (num) => {
  const classe = $('#hearth').attr('class').split(' ')[1];
  console.log(num);
  if (num == 1) {
    if (classe == 'far') {
      $('#hearth').removeClass('far').addClass('fas');
    } else {
      $('#hearth').removeClass('fas').addClass('far');
    }
  }

  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/prefer_events/addWishLikeList_exist.php?title=${eventTitle}&case=${num}`
  );
  const res = await Res.json();
  if (num != 1) {
    alert(`${res.status} : ${res.message}`);
  }
};

$('#buy').click(async () => {
  const cont = $('#count').val();
  console.log(cont);

  if (cont && cont > 0) {
    const Res = await fetch(
      `${url.origin}/esercizi/tesina/app/api/ticket/newTicket.php?title=${eventTitle}&count=${cont}`
    );
    const res = await Res.json();
    alert(`${res.status}: ${res.message}`);
    location.reload();
  } else {
    alert('invalid number of ticket');
  }
});
