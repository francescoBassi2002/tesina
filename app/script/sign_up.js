const url = new URL(window.location.href);
const form = document.getElementById('form');

form.addEventListener('submit', function (e) {
  e.preventDefault();
  const data = new URLSearchParams(new FormData(this));
  console.log(data);

  fetch(`${url.origin}/esercizi/tesina/app/api/user/getCurrent_signUp.php`, {
    method: 'POST',
    body: data,
  })
    .then((res) => res.json())
    .then((res) => {
      console.log(res);
      if (res.status == 'success') {
        alert(`${res.status} : ${res.message}`);
      } else {
        alert(`${res.status} : ${res.message}`);
      }
    })
    .catch((err) => {
      console.log('error: ', err);
    });
});
