function check_login(){
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let msg = document.getElementById("msg");

    if(!email && !password){
        msg.innerText = "Email and Password are required\n";
        msg.style.color = "red";
    }
    else if(!email){
        msg.innerText = "Email is required\n";
        msg.style.color = "red";
    }
    else if(!password){
        msg.innerText = "Password is required\n";
        msg.style.color = "red";
    }
    else if(!email.includes("@") || !email.includes(".")){
        msg.innerText = "Please enter a valid email address\n";
        msg.style.color = "red";
    }
    else{
        msg.innerText = "Login with success\n";
        msg.style.color = "green";
    }
}

function check_signup(){
    let fname = document.getElementById("fname").value.trim();
    let lname = document.getElementById("lname").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();
    let gender = document.querySelector('input[name="gender"]:checked');
    let age = document.getElementById("age").value;
    let wilaya = document.getElementById("wilaya").value;
    let password = document.getElementById("password").value;
    let password2 = document.getElementById("password2").value;
    
    let msg="";

    if(!fname){
        msg+="First Name is required\n";
    }
    if(!lname){
        msg+="last Name is required\n";
    }
    if(!email){
        msg+="Email is required\n";
    }
    if(!phone){
        msg+="phone is required\n";
    }
    else if(isNaN(phone)){
        if(phone.length!=10)
        msg+="Phone number is incorrect\n";
    }
    if(!address){
        msg+="address is required\n";
    }
    if(!gender){
        msg+="gender is required\n";
    }
    if(!age){
        msg+="age is required\n";
    }
    else if(age<17 || age >100){
        msg+="Age is not accepted\n"
    }
    if(!wilaya){
        msg+="wilaya is required\n";
    }
    if(!password){
        msg+="Password is required\n";
    }
    else if(password.length <8){
        msg+="Password is less than 8 char\n";
    }
    if(!password2){
        msg+="Password Confirmation is required\n";
    }
    if(password != password2){
        msg+="Password is not correct\n";
    }
    if(msg){
    alert("❌\n"+msg);
    return false;
}
return true;}

function check_quantity() {
    let quantity = parseInt(document.getElementById("quantity").value);
    let colors = document.querySelectorAll('.color');
    let colorRow = document.getElementById("colors");
    let colorQuantitiesRow = document.getElementById("color-quantities");
    let colorSelection = document.getElementById("color-selection");
    let blackQuantity = document.getElementById("black-quantity");
    let whiteQuantity = document.getElementById("white-quantity");

    if (quantity >= 1) {
        colorRow.style.display = "table-row";

        if (quantity === 1) {
            colorSelection.innerHTML = `
                <label>Black</label>
                <input type="radio" name="color" value="black" class="color" />
                <label>White</label>
                <input type="radio" name="color" value="white" class="color" />
            `;
            colorQuantitiesRow.style.display = "none";
        } else if (quantity === 2) {
            colorSelection.innerHTML = `
                <label>Black</label>
                <input type="checkbox" name="color" value="black" class="color" />
                <label>White</label>
                <input type="checkbox" name="color" value="white" class="color" />
            `;
            colorQuantitiesRow.style.display = "none";
        } else {
            colorSelection.innerHTML = `
                <label>Black</label>
                <input type="checkbox" name="color" value="black" class="color" checked disabled />
                <label>White</label>
                <input type="checkbox" name="color" value="white" class="color" checked disabled />
            `;
            colorQuantitiesRow.style.display = "table-row";
            blackQuantity.value = 0;
            whiteQuantity.value = 0;
        }
    } else {
        colorRow.style.display = "none";
        colorQuantitiesRow.style.display = "none";
        colorSelection.innerHTML = `
            <label>Black</label>
            <input type="checkbox" name="color" value="black" class="color" disabled />
            <label>White</label>
            <input type="checkbox" name="color" value="white" class="color" disabled />
        `;
    }
}

function validate_color_quantities() {
    let quantity = parseInt(document.getElementById("quantity").value);
    let blackQuantity = parseInt(document.getElementById("black-quantity").value) || 0;
    let whiteQuantity = parseInt(document.getElementById("white-quantity").value) || 0;
    let sum = blackQuantity + whiteQuantity;

    if (sum > quantity) {
        alert("❌ Sum of color quantities cannot exceed total quantity!");
        document.getElementById("black-quantity").value = 0;
        document.getElementById("white-quantity").value = 0;
    }
}

function validation_order() {
    let quantity = parseInt(document.getElementById("quantity").value);
    let colors = document.querySelectorAll('.color');
    let blackQuantity = parseInt(document.getElementById("black-quantity").value) || 0;
    let whiteQuantity = parseInt(document.getElementById("white-quantity").value) || 0;
    let colorChecked = false;

    colors.forEach(input => {
        if (input.checked) colorChecked = true;
    });

    let msg = "";
    if (!quantity || quantity <= 0) {
        msg = "❌ Quantity is required";
    } else if (quantity === 1 && !colorChecked) {
        msg = "❌ Color is required";
    } else if (quantity === 2 && !colorChecked) {
        msg = "❌ At least one color must be selected";
    } else if (quantity > 2) {
        let sum = blackQuantity + whiteQuantity;
        if (sum !== quantity) {
            msg = `❌ Sum of color quantities (${sum}) must equal total quantity (${quantity})`;
        } else if (blackQuantity < 0 || whiteQuantity < 0) {
            msg = "❌ Color quantities cannot be negative";
        } else {
            msg = "✅ The order is done!";
        }
    } else {
        msg = "✅ The order is done!";
    }

    alert(msg);
}
function check_quantity() {
    let quantity = parseInt(document.getElementById("quantity").value);
    let colors = document.querySelectorAll('.color');
    let colorRow = document.getElementById("colors");
    let colorQuantitiesRow = document.getElementById("color-quantities");
    let colorSelection = document.getElementById("color-selection");
    let blackQuantity = document.getElementById("black-quantity");
    let whiteQuantity = document.getElementById("white-quantity");

    if (quantity >= 1) {
        colorRow.style.display = "table-row";

        if (quantity === 1) {
            colorSelection.innerHTML = `
                <label>Black</label>
                <input type="radio" name="color" value="black" class="color" />
                <label>White</label>
                <input type="radio" name="color" value="white" class="color" />
            `;
            colorQuantitiesRow.style.display = "none";
        } else if (quantity === 2) {
            colorSelection.innerHTML = `
                <label>Black</label>
                <input type="checkbox" name="color" value="black" class="color" />
                <label>White</label>
                <input type="checkbox" name="color" value="white" class="color" />
            `;
            colorQuantitiesRow.style.display = "none";
        } else {
            colorSelection.innerHTML = `
                <label>Black</label>
                <input type="checkbox" name="color" value="black" class="color" checked disabled />
                <label>White</label>
                <input type="checkbox" name="color" value="white" class="color" checked disabled />
            `;
            colorQuantitiesRow.style.display = "table-row";
            blackQuantity.value = 0;
            whiteQuantity.value = 0;
        }
    } else {
        colorRow.style.display = "none";
        colorQuantitiesRow.style.display = "none";
        colorSelection.innerHTML = `
            <label>Black</label>
            <input type="checkbox" name="color" value="black" class="color" disabled />
            <label>White</label>
            <input type="checkbox" name="color" value="white" class="color" disabled />
        `;
    }
}
function toggleTheme() {
    document.body.classList.toggle("dark-theme");

    if (document.body.classList.contains("dark-theme")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
}
window.onload = function() {
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-theme");
    }
}
