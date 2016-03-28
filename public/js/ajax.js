// the search function.
// used in year 2, semester 1 web-dev project.
function showResult(str) {
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = " ";

    } else {
        var http_request = new XMLHttpRequest();
        http_request.onreadystatechange = function () {
            if (http_request.readyState == 4 && http_request.status == 200) {
                document.getElementById("livesearch").innerHTML = http_request.responseText;
            }
        };
        http_request.open("GET", "/search/" + str, true);
        http_request.send();
    }
}