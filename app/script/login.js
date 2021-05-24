const url = new URL(window.location.href);
const form = document.getElementById('form');

form.addEventListener('submit', function (e) {
  e.preventDefault();
  const data = new URLSearchParams(new FormData(this));
  console.log(data);

  fetch(`${url.origin}/esercizi/tesina/app/api/user/login_logout.php`, {
    method: 'POST',
    body: data,
  })
    .then((res) => res.json())
    .then((res) => {
      console.log(res);
      if (res.status == 'success') {
        window.location.href = `${url.origin}/esercizi/tesina/app/userPage.php`;
      } else {
        alert(`${res.status} : ${res.message}`);
      }
    })
    .catch((err) => {
      console.log('error: ', err);
    });

});
