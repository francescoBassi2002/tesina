const createBootstrapTable = (arrayObj, where) => {
  const keys = Object.keys(arrayObj[0]);
  //console.log(keys);

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
  //console.log(righe);

  for (let a = 0; a < righe.length; a += 1) {
    for (key of keys) {
      const riga = document.getElementsByClassName(`riga${a}`);
      //console.log(key);
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

const url = new URL(window.location.href);
$(document).ready(async () => {
  try {
    const Res = await fetch(
      `${url.origin}/esercizi/tesina/app/api/event/getAll_create.php`
    );
    const res = await Res.json();

    res.forEach((el) => {
      console.log(el.title);
      $('#ciao').append(`
                        <option value="${el.title}">${el.title}</option>
                    `);
    });

    const BadE = await fetch(
      `${url.origin}/esercizi/tesina/app/api/event/getAll_create.php?bad_success=1`
    );
    const badE = await BadE.json();

    createBootstrapTable(badE, $('.bad-event'));
    badE.forEach((el) => {
      $('#inputGroupSelect04').append(`
                        <option value="${el.title}">${el.title}</option>
                    `);
    });
    let htmlEl = '';

    for (let a = 0; a < 3; a++) {
      const ES = await fetch(
        `${url.origin}/esercizi/tesina/app/api/event/nextMonthEvent.php?es=es${
          a + 1
        }`
      );

      const es = await ES.json();
      console.log(es);
      if (es.status == 'success') {
        if (a == 0) {
          htmlEl = `<li>Next month event with more ticket purchased: <b>${es.data.title}</b> with <b>${es.data.next_month_tickets}</b> tickets</li>`;
        } else if (a == 1) {
          htmlEl = `<li>Total sales revenue from rock concerts in the last 6 months: <b>${parseInt(
            es.data.somma_rock
          ).toFixed(2)} $</b></li>`;
        } else if (a == 2) {
          htmlEl = `<li>Month of the year with more events: <b>${es.data.mese}</b> with <b>${es.data.num_eventi}</b> events</li>`;
        }

        $('.statistic-list').append(htmlEl);
      } else {
        alert(`${res.status}: ${res.message}`);
      }
    }
  } catch (err) {
    console.log(`Err: ${err}`);
  }

  //_----------------------------------------------TODO:
});

$('#button').click(async () => {
  const title = $('.form-select').val();
  $('#graphic').empty();
  try {
    const Res = await fetch(
      `${url.origin}/esercizi/tesina/app/api/ticket/howMany.php?title=${title}`
    );
    const res = await Res.json();
    if (res.status == 'success') {
      res.data.forEach((el, idx) => {
        el['label'] = el.date;
        delete el.date;
        el['y'] = parseInt(el['COUNT(*)']);
        delete el['COUNT(*)'];
      });
      console.log(res.data);
      dataPoints = res.data;

      var chart = new CanvasJS.Chart('graphic', {
        theme: 'light1', // "light2", "dark1", "dark2"
        animationEnabled: true, // change to true
        title: {
          text: 'Sales trend',
        },
        data: [
          {
            showInLegend: true,
            name: 'Sales trend',
            // Change type to "bar", "area", "spline", "pie",etc.
            type: 'line',
            dataPoints: dataPoints,
          },
        ],
      });
      chart.render();
    } else {
      alert(`${res.status} : ${res.message}`);
    }
  } catch (err) {
    console.log('error: ', err);
  }
});

$('#btn-discount').click(async () => {
  const title = $('#inputGroupSelect04').val();
  const percent = $('#percent-input').val();

  const Res = await fetch(
    `${url.origin}/esercizi/tesina/app/api/event/discount.php?title=${title}&percent=${percent}`
  );
  const res = await Res.json();

  alert(`${res.status}: ${res.message}`);
  location.reload();
});
