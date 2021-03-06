function checkRegisterFields() {
    // Get and reset element
    let errorElement = document.getElementById("js-response");
    errorElement.innerHTML = "";
    errorElement.style.display = "block";

    // Perform checks
    console.log("*****     Register Checks incomming     *****")
    let username = document.getElementById("register-username").value.trim()
    let validUsername = /^[a-zA-Z0-9]+$/.test(username)
    if (validUsername)
        console.log("Username is fine")
    else
        errorElement.innerHTML += "Username isn't valid! (Only english characters and digits)<br>"

    let password = document.getElementById("register-password").value.trim()
    let validPassword = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/.test(password)
    if (validPassword && password.length > 7)
        console.log("Password is fine")
    else
        errorElement.innerHTML += "Password isn't valid! (Must have small and large letters, a digit, and a length of at least 8 characters)<br>"

    let passwordRepeat = document.getElementById("register-password-repeat").value.trim()
    let validPasswordRepeat = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/.test(passwordRepeat)
    if (validPasswordRepeat && passwordRepeat.length > 7)
        console.log("Repeat password is fine")
    else
        errorElement.innerHTML += "Repeat password isn't valid! (Must have small and large letters, a digit, and a length of at least 8 characters)<br>"

    let firstname = document.getElementById("register-firstname").value.trim()
    let validFirstname = /^[a-zA-Z]+$/.test(firstname)
    if (validFirstname)
        console.log("Firstname is fine")
    else
        errorElement.innerHTML += "Firstname isn't valid! (Only english characters)<br>"

    let lastname = document.getElementById("register-lastname").value.trim()
    let validLastname = /^[a-zA-Z]+$/.test(lastname)
    if (validLastname)
        console.log("Lastname is fine")
    else
        errorElement.innerHTML += "Lastname isn't valid! (Only english characters)<br>"

    let zip = document.getElementById("register-zip").value.trim()
    let validZip = /^[0-9]{4}$/.test(zip)
    if (validZip)
        console.log("Zip code is fine")
    else
        errorElement.innerHTML += "Zip code isn't valid! (Must be 4 digits)<br>"

    let city = document.getElementById("register-city").value.trim()
    let validCity = /^[a-zA-Z]+$/.test(city)
    if (validCity)
        console.log("City is fine")
    else
        errorElement.innerHTML += "City isn't valid! (Only english characters)<br>"

    let email = document.getElementById("register-email").value.trim()
    let validEmail = /^\S+@\S+\.([a-z]|[A-Z]){1,5}$/.test(email)
    if (validEmail)
        console.log("Email is fine")
    else
        errorElement.innerHTML += "Email isn't valid!<br>"

    let phone = document.getElementById("register-phone").value.trim()
    let validPhone = /^\+[0-9]{8,30}$/.test(phone)
    if (validPhone)
        console.log("Phone number is fine")
    else
        errorElement.innerHTML += "Phone number isn't valid! (Must start with a +, at least 8 digits, and at most 30 digits)<br>"

    // Show eroor
    if (errorElement.innerHTML !== "")
    {
         errorElement.style.display = "block"
         return false
    }

    if (validUsername && validPassword && validPasswordRepeat && validFirstname && validLastname && validZip && validCity && validEmail && validPhone)
        return true
    else
        return false
}

function showUsers(requestString) {
    if (requestString === "") {
        document.getElementById("table-respons").innerHTML = ""
        return
    } else {
        let xmlHttp = new XMLHttpRequest()
        xmlHttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table-respons").innerHTML = this.responseText
            }
        }

        xmlHttp.open("GET", "/ernie17/mvc/public/users/getUsers/" + requestString, true)
        xmlHttp.send()
    }
}
