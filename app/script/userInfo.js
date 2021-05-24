const url = new URL(window.location.href);

const toUpperCase = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
};

const destroyUser = async () => {
  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/user/destroy_becomeAdmin.php`
  );
  const res = await Res.json();
  if (res.status == 'success') {
    window.location.href = 'index.html';
  } else {
    alert(`${res.status}: ${res.message}`);
  }
};

const destroyReceives = async () => {
  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/ticket/deleteFromUser.php`
  );
  const res = await Res.json();

  alert(`${res.status}: ${res.message}`);
  if (res.status == 'success') {
    $('#list-of-pdf').empty();
  }
};

$(document).ready(async () => {
  try {
    const User = await fetch(
      `${url.origin}/esercizi/tesina/app/api/user/getCurrent_signUp.php`
    );
    const user = await User.json();
    console.log(user);
    if (user.status == 'success') {
      $('.user-intestation').append(`<h1>${toUpperCase(user.data.name)}</h1>`);

      Object.keys(user.data).forEach((key) => {
        $('#user-info-list').append(
          `<li class="list-group-item">${toUpperCase(key)}: ${
            key != 'admin'
              ? user.data[key]
              : user.data[key] == '1'
              ? 'admin'
              : 'user'
          }</li>`
        );
      });
    } else {
      console.log(`${user.status}: ${user.message}`);
    }

    const Pdf = await fetch(
      `${url.origin}/esercizi/tesina/app/api/user/getAllUser.php`
    );
    const pdf = await Pdf.json();

    if (pdf.status == 'success') {
      pdf.data.forEach((el) => {
        $('#list-of-pdf').append(
          `<li class="list-group-item"><a href="pdf/${CryptoJS.MD5(
            user.data.username
          )}/${el.pdf_src}.pdf">${el.pdf_src}.pdf</a></li>`
        );
      });
    } else {
      alert(`${pdf.status}: ${pdf.message}`);
    }
  } catch (err) {
    console.log('err: ', err);
  }
});
