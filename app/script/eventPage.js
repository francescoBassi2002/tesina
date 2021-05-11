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

$(document).ready(() => {
  fetch(
    `${url.origin}/esercizi/tesina/app/api/event/addWishLikeList_exist.php?title=${eventTitle}`
  )
    .then((res) => res.json())
    .then((res) => {
      if (res.status == 'success') {
        $('.sheet-intestation').prepend(
          `<h2 class="text-light text-center">${eventTitle}</h2><h2 class="text-light like"><a href="#" onclick="addWishList(1)"><i class="fa-heart ${
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
        delete res.data.id_type;
        delete res.data.id_genre;
        delete res.data.id;
        console.log(res.data);

        for (key of Object.keys(res.data)) {
          if (key != 'img_src') {
            $('#caratteristics').append(
              `<li class="list-group-item bg-transparent text-light">${jsUcfirst(
                key
              )}: ${res.data[key]}</li>`
            );
          }
        }
        $('.sheet-description').append(
          img.replace('%img_src%', res.data.img_src)
        );
      } else {
        console.log(res.message);
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
    `${url.origin}/esercizi/tesina/app/api/event/addWishLikeList_exist.php?title=${eventTitle}&case=${num}`
  );
  const res = await Res.json();
  if (num != 1) {
    alert(`${res.status} : ${res.message}`);
  }
};

$('#buy').click(async () => {
  const cont = $('#count').val();

  if (cont) {
    const Res = await fetch(
      `${url.origin}/esercizi/tesina/app/api/ticket/newTicket.php?title=${eventTitle}&count=${cont}`
    );
    const res = await Res.json();
    alert(`${res.status}: ${res.message}`);
  } else {
    alert('insert how many tickets you want to buy');
  }
});
