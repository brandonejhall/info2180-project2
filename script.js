window.onload = function()
{
    fetch("./Login.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
            document.getElementsByClassName("content")[0].innerHTML = data;
            document.getElementById('loginBtn').addEventListener("click", function(e){
                e.preventDefault();
                clearErrors();
                console.log("success");
                let log_pw= document.querySelector('#password')
                let log_email= document.querySelector('#email')
                let log_user= [log_email.value,log_pw.value];
                let msg = document.querySelector('#msg');
                let approve=false;
                var url = "bugme.php";
                //VALIDATION
                //check if password is empty
                if (isEmpty(log_pw.value.trim())){
                    validationFailed=true;
                    approve=false;
                    log_pw.style.border="2px solid red";
                    displayErrorMessage(log_pw,"*Invalid Password*");
                }else{
                    log_pw.style.removeProperty("border");
                    approve=true;
                }

                //check if email is valid
                if (!isValidEmail(log_email.value.trim())){
                    validationFailed=true;
                    approve=false;
                    log_email.style.border="2px solid red";
                    displayErrorMessage(log_email,"*Invalid email address*");
                }else{
                    log_email.style.removeProperty("border");
                    approve=true;

                }
                
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
                                    msg.innerHTML=response;

                                } 
                                else 
                                {
                                alert('There was a problem with the request.');
                                }
                            }
                        }
                if (approve){
                    document.getElementsByClassName("Home")[0].addEventListener("click",home);
                    document.getElementsByClassName("Add")[0].addEventListener("click",add);
                    document.getElementsByClassName("New")[0].addEventListener("click",New);
                }
                
            })
        });
    
};

function home()
{     
   
    fetch("./home.html")
        .then(response => {
            return response.text()
        })
        .then(data => {
        document.getElementsByClassName("content")[0].innerHTML = data;
             
        let httpRequest = new XMLHttpRequest();
        var url = "bugme.php";
            
        let load_home = true;


        httpRequest.onreadystatechange = processName;
        httpRequest.open('POST', url,true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send('home=' + encodeURIComponent(load_home));

        function processName(){       
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    let response = httpRequest.responseText;
                    document.getElementsByClassName("content")[0].innerHTML = response;
                    
                    Array.prototype.forEach.call(document.getElementsByClassName("Title"), element=> {
                        element.addEventListener('click',function(){
                            let query_element = element.getAttribute('value');
                            var url = 'http://localhost/info2180-project2/bugme.php?title=';
                            let request = new URL(url+query_element);
                            fetch (request)
                                .then(response => {
                                    if (response.ok){
                                        return response.text()
                                    } 
                                    else{
                                        return Promise.reject('something went wrong')
                                    }
                            })
                            .then (function(data){
                                document.getElementsByClassName("content")[0].innerHTML = data;
                            })
                            .catch (error => console.log('There was an error: ' + error))



                        })
                      });

                } 
                else {
                    alert('There was a problem with the request.');
                }
            }
        }

            
        });
   
};


function add()
{
    fetch("./user.php")
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
                    let msg = document.querySelector('#msg');


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
                                    msg.innerHTML=response;
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
    fetch("./New_Issue.php")
    .then(response => {
        return response.text()
    })
    .then(data => {
        document.getElementsByClassName("content")[0].innerHTML = data;
        document.getElementsByClassName("newIssue")[0].addEventListener("click", function(element)
        {
            element.preventDefault();
            clearErrors();            

            var title = document.getElementById("title");
            var description = document.getElementById("description");
            var user = document.getElementById("new_issue");
            var type = document.getElementById("type");
            var level = document.getElementById("prio");
            const new_issue = [title.value,description.value,user.value,type.value,level.value];
            let approve=false;
            // console.log(title,description,user,type,level);
            //Validating input 
            if (isEmpty(title.value.trim())){
                validationFailed=true;
                approve=false;
                title.style.border="2px solid red";
                displayErrorMessage(title,"*Invalid Title*");
            }else{
                title.style.removeProperty("border");
                approve=true;
            }
            if (isEmpty(description.value.trim())){
                validationFailed=true;
                approve=false;
                description.style.border="2px solid red";
                displayErrorMessage(description,"*Invalid Description*");
            }else{
                description.style.removeProperty("border");
                approve=true;
            }

            if (approve){
                let httpRequest = new XMLHttpRequest();

                var url = "bugme.php";

                httpRequest.onreadystatechange = processName;
                httpRequest.open('POST', url,true);
                httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                httpRequest.send('new_issue=' + encodeURIComponent(new_issue));

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


//VALIDATION CODE
function isEmpty(elementValue) {
    if (elementValue.length == 0) {
      // Or you could check if the value == ""
      console.log('field is empty');
      return true;
    } 
    return false;
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