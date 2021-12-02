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
                    clearErrors();
                    //VALIDATION OF FEILDS
                    let approve=false;    
                    let validationFailed=false;
                    let add_fname= document.querySelector('#fname');
                    let add_lname= document.querySelector('#lname');
                    let add_email= document.querySelector('#email');
                    let add_password= document.querySelector('#password');


                    //Check if first name is empty
                    if (isEmpty(add_fname.value.trim())){
                        validationFailed=true;
                        approve=false;
                        add_fname.style.border="2px solid red";
                        displayErrorMessage(add_fname,"*You must fill in your First Name*");
                    }else{
                        add_fname.style.removeProperty("border");
                        approve=true;
                    }

                    //Check if last name is empty
                    if (isEmpty(add_lname.value.trim())){
                        validationFailed=true;
                        approve=false;
                        add_lname.style.border="2px solid red";
                        displayErrorMessage(add_lname,"*You must fill in your Last Name*");
                    }else{
                        add_lname.style.removeProperty("border");
                        approve=true;
                    }

                    //check if password is empty
                    if (isEmpty(add_password.value.trim())){
                        validationFailed=true;
                        approve=false;
                        add_password.style.border="2px solid red";
                        displayErrorMessage(add_password,"*You must fill in your Last Name*");
                    }else{
                        add_password.style.removeProperty("border");
                        approve=true;
                    }

                    //check if email is valid
                    if (!isValidEmail(add_email.value.trim())){
                        validationFailed=true;
                        approve=false;
                        add_email.style.border="2px solid red";
                        displayErrorMessage(add_email,"*Invalid email address*");
                    }else{
                        add_email.style.removeProperty("border");
                        approve=true;

                    }

                    
                    if (approve){
                        let httpRequest = new XMLHttpRequest();

                        var fname = document.getElementsByTagName("input")[0].value;
                        var lname = document.getElementsByTagName("input")[1].value;
                        var pass = document.getElementsByTagName("input")[2].value;
                        var email = document.getElementsByTagName("input")[3].value;
                        const add_user = [fname,lname,pass,email];

                        var url = "bugme.php";

                        httpRequest.onreadystatechange = processName;
                        httpRequest.open('POST', url,true);
                        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        httpRequest.send('add_user=' + encodeURIComponent(add_user));

                        function processName()
                        {
                            if (httpRequest.readyState === XMLHttpRequest.DONE) 
                            {
                                if (httpRequest.status === 200) 
                                {
                                    let response = httpRequest.responseText;
                                    console.log(response);
                                } 
                                else 
                                {
                                alert('There was a problem with the request.');
                                }
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
            document.getElementById('loginBtn').addEventListener("click", function(e){
                e.preventDefault();
                let log_pw= document.querySelector('#password');
                let log_email= document.querySelector('#email');
                let log_user= [log_email,log_pw];
                var url = "bugme.php";
                console.log("yo");
                let httpRequest = new XMLHttpRequest();

                httpRequest.onreadystatechange = processName;
                        httpRequest.open('POST', url,true);
                        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        httpRequest.send('log_user=' + encodeURIComponent(log_user));

                        function processName()
                        {
                            if (httpRequest.readyState === XMLHttpRequest.DONE) 
                            {
                                if (httpRequest.status === 200) 
                                {
                                    let response = httpRequest.responseText;
                                    console.log(response);
                                } 
                                else 
                                {
                                alert('There was a problem with the request.');
                                }
                            }
                        }
                
            })
        });
}

//VALIDATION CODE
function isEmpty(elementValue) {
    if (elementValue.length == 0) {
      // Or you could check if the value == ""
      console.log('field is empty');
      return true;
    } 
    return false;
}

function isValidID(id) {
    return /^\d{9}$/.test(id);
}

function isReference(ref){
    return /^\d{13}$/.test(ref);
}

function isValidEmail(emailAddress) {
    return /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/.test(emailAddress);
}

function insertAfter(element, newNode) {
    element.parentNode.insertBefore(newNode, this.nextSibling);
}

function clearErrors() {
    var elementsWithErrors = document.querySelectorAll('.error');
    //console.log(elementsWithErrors);
    for (var x = 0; x < elementsWithErrors.length; x++) {
      elementsWithErrors[x].setAttribute('class', '');
      elementsWithErrors[x].parentNode.removeChild(elementsWithErrors[x].nextElementSibling);
      //console.log(elementsWithErrors[x].nextElementSibling);
    } 
}

function displayErrorMessage(formField, message) {
    formField.setAttribute('class', 'error');
    var errorMessageText = document.createTextNode(message);
    var errorMessage = document.createElement('span');
    errorMessage.setAttribute('class', 'error-message');
    errorMessage.appendChild(errorMessageText);
    //formField.insertAfter(errorMessage);
    insertAfter(formField, errorMessage);
}