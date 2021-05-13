<?php 
    session_start();
    if(!isset($_SESSION) || !key_exists("username" , $_SESSION)){
        header("location: login.html");
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
      crossorigin="anonymous"
    />
    <link href="./style/style.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
  </head>
  <body>
      <div class="container-fluid">
      <h1 class="text-light text-center">Control page</h1>
        <div class="input-group container-fluid m-3 graphic-control">
            <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                
                
            </select>
            <button class="btn btn-outline-light go_main" type="button" id="button">Button</button>
        </div>
        <div class="row justify-content-evenly">
            <div class="container-fluid graphic-container align-content-center col-4 h-100" id="graphic">
                <!-- GRAPHIC -->
            </div>
            <div class="col-4 p-5 bg-light" >
                <h1 class="text-center text-dark">What's up?</h1>
                <p class="text-dark">
                    Select an event's title and see how are sales in this period
                </p>
                <img src="image/thinking.png" class="img-fluid">
            </div>
        </div>
      </div>
        
        
  </body>
    <script
      src="bootstrap/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
    <script>
        const url = new URL(window.location.href);
        $(document).ready(async()=>{
            const Res = await fetch(`${url.origin}/esercizi/tesina/app/api/event/getAll_create.php`);
            const res = await Res.json();

            res.forEach(el=>{
                console.log(el.title);
                $(".form-select").append(`
                    <option value="${el.title}">${el.title}</option>
                `)
            })

        })

        $("#button").click(async()=>{
            const title = $(".form-select").val();
            $("#graphic").empty();
            try{
                const Res = await fetch(`${url.origin}/esercizi/tesina/app/api/ticket/howMany.php?title=${title}`);
                const res = await Res.json();
            if (res.status == "success"){
                res.data.forEach((el,idx)=>{
                    el["label"] = el.date;
                    delete el.date;
                    el["y"] = parseInt(el["COUNT(*)"]);
                    delete el["COUNT(*)"];
                });
                console.log(res.data);
                dataPoints = res.data;
                
                var chart = new CanvasJS.Chart("graphic", {
                theme: "light2", // "light2", "dark1", "dark2"
                animationEnabled: true, // change to true		
                title:{
                    text: "Sales trend"
                },
                data: [
                {
                    showInLegend: true,
                    name: "Sales trend",
                    // Change type to "bar", "area", "spline", "pie",etc.
                    type: "line",
                    dataPoints: dataPoints
                }
                ]
            });
            chart.render();

            }else{
                alert(`${res.status} : ${res.message}`);
            }

            }catch(err){
                console.log("error: " , err);
            }
            

        })
        
        
        

    </script>
  </body>
</html>
