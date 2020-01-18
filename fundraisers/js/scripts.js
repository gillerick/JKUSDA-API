
let total =  747868 + 805343 + 4200;
//Get current Month name
const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

var d = new Date();
var this_month = monthNames[d.getMonth()];


let figure = document.getElementById("figure");

setInterval(function() {
    $.ajax({
        url: "paybill_request.php",
        type: "GET",
        processData: false,
        contentType: "application/json",
        success: function (response) {
            let newdata = JSON.parse(response);
            let newDB = parseInt(newdata.sum);
            let p_today = parseInt(newdata.PCount);
            let p_yester = parseInt(newdata.PYester);
            let latest_t = parseInt(newdata.Time);
            let latest_date = newdata.LTime;
            let p_month = parseInt(newdata.PMonth);
            let target = 3100000;
            let pFulfilled = 58181+1030+100+17500+8570+100+6500+1000+10000+25100;
            //102870 JKUSDA Pledges, 291108 AUSAA Pledges
            let pTotal = 102870 + 291108 + 25000 + 10500;

            dev = parseInt(newdata.latest);
            m = newdata.member;
            m1 = newdata.member1;
            total += newDB;
            p = parseInt(newdata.Pledges);
            let today_sum = parseInt(newdata.Today);
            let yester_sum = parseInt(newdata.Jana);

            figure.innerText = "KES " + total.toLocaleString();
            fig_perc.innerText = (total/target*100).toFixed(0) + "%";
            var leo = new Date().toJSON().slice(0,10);
            var l = m.length;
            if (l < 3){
                contributor.innerText = m1;
            }
            else{
                contributor.innerText = m;
            }

            //Convert Latest TimeStamp to Date
            var latest_time = new Date(latest_t*1000).toDateString().slice(0,10);
            // console.log(latest_time);
            contribution.innerText = "KES " + dev.toLocaleString();
            deficit.innerText = "KES " + (target - total).toLocaleString();
            deficit_per.innerText = ((target - total)/target*100).toFixed(0) + "%";
            pL.innerText = "KES " + (pTotal-pFulfilled-p).toLocaleString();
            pL_perc.innerText = ((pTotal-pFulfilled-p)/target*100).toFixed(0) + "%";
            duration.innerText = newdata.Timestamp;
            p_count_month.innerText = p_month + " • " + this_month;
            p_count.innerText = p_today + " • Today";
            p_count.innerText = p_today + " • Today";
            var now = (new Date().getTime())/1000;
            now  = parseInt(Math.round(now));

            if (now - latest_t == 1){
                M.toast({html: m1 + ' ' + m + ' | ' + 'KES ' + dev.toLocaleString(), classes: 'light-blue rounded'});
                document.getElementById("tone").play();
            }

            let cash = parseInt(4200);

            if (today_sum > 0 ){

                if (leo == '2019-12-31'){

                    today.innerText = "KES " + (today_sum + cash).toLocaleString();

                }
                else {

                    today.innerText = "KES " + today_sum.toLocaleString();
                }
            }

            else if (today_sum =! NaN){

                today_tag.innerText = "Contributed Yesterday";
                today.innerText = "KES " + (yester_sum + cash).toLocaleString();
                p_count.innerText = p_yester + " • Yesterday";
            }

            else if (yester_sum =! NaN){
                today_tag.innerText = "Contributed on " + latest_time;
                p_count.innerText = "" + latest_time;
            }

            total = 747868 + 805343 + 4200;

        },
        error: function (response) {
        },
    });
},2000);


// var countDownDate = new Date("Dec 22, 2019 03:00:00").getTime();
//
//
// var x = setInterval(function() {
//
// var now = new Date().getTime();
//
//
// var distance = countDownDate - now;
//
// var days = Math.floor(distance / (1000 * 60 * 60 * 24));
// var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
// var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
// var seconds = Math.floor((distance % (1000 * 60)) / 1000);
//
// document.getElementById("countdown").innerHTML = days + "D " + hours + "H " + minutes + "M " + seconds + "S ";
//
// if (distance < 0) {
//   clearInterval(x);
//   document.getElementById("countdown").innerHTML = "GANZE";
//   }
// }, 1000);
