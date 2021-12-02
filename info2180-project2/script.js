window.onload = function()
{
    fetch("./Login.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
            document.getElementsByClassName("content")[0].innerHTML = data;
        });
    document.getElementsByClassName("Home")[0].addEventListener("click",home);
    document.getElementsByClassName("Add")[0].addEventListener("click",add);
    document.getElementsByClassName("New")[0].addEventListener("click",New);
    document.getElementsByClassName("Logout")[0].addEventListener("click",login);
};

function home()
{
    fetch("./home.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
            document.getElementsByClassName("content")[0].innerHTML = data;
        });
}

function add()
{
    fetch("./user.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
            document.getElementsByClassName("content")[0].innerHTML = data;
            document.getElementsByTagName("button")[0].addEventListener("click", function(element)
                {
                    element.preventDefault();

                    httpRequest = new XMLHttpRequest();

                    var fname = document.getElementsByTagName("input")[0].value;
                    var lname = document.getElementsByTagName("input")[1].value;
                    var pass = document.getElementsByTagName("input")[2].value;
                    var email = document.getElementsByTagName("input")[3].value;
                    const add_user = [fname,lname,pass,email];

                    var url = "bugme.php";

                    httpRequest.onreadystatechange = processName;
                    httpRequest.open('POST', url);
                    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpRequest.send('add_user=' + encodeURIComponent(add_user));

                    function processName()
                    {
                        if (httpRequest.readyState === XMLHttpRequest.DONE) 
                        {
                            if (httpRequest.status === 200) 
                            {
                              console.log("Success");
                            } 
                            else 
                            {
                              alert('There was a problem with the request.');
                            }
                        }
                    }
                }
                );
        });
}

function New()
{
    fetch("./New_Issue.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
            document.getElementsByClassName("content")[0].innerHTML = data;
        });
}

function login()
{
    fetch("./Login.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
            document.getElementsByClassName("content")[0].innerHTML = data;
        });
}
