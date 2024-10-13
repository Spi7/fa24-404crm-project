function enumerateItemNumbers() {
    let itemNumbers = document.getElementsByClassName("itemNumber")
    for (let item = 0; item < itemNumbers.length; item++) {
        itemNumbers[item].innerHTML = (item + 1).toString().padStart(2, '0') + ":"
    }
}
function addItemToForm() {
    let template = document.getElementById("itemTemplate")
    let html = template.content.cloneNode(true)
    document.getElementById("invoiceItems").appendChild(html)
    //find delete button on newest item and add event listener to delete its parent
    let deleteButtons = document.getElementsByClassName("deleteItemButton")
    let deleteButton = deleteButtons[deleteButtons.length - 1]
    deleteButton.addEventListener("click", (event) => {
        //don't allow user to remove the only item
        if (document.getElementsByClassName("quantityInput").length > 1) {
            event.target.parentElement.remove()
            enumerateItemNumbers()
        }
    })
    //add event listener for changes on quantity and price
    let quantityInputs = document.getElementsByClassName("quantityInput")
    let priceInputs = document.getElementsByClassName("priceInput")

    quantityInputs[quantityInputs.length - 1].addEventListener("input", computeCost)
    priceInputs[priceInputs.length - 1].addEventListener("input", computeCost)
    enumerateItemNumbers()
    useLabels(window.innerWidth > 700)
}
function computeCost() {
    let cost = 0
    let quantityInputs = document.getElementsByClassName("quantityInput")
    let priceInputs = document.getElementsByClassName("priceInput")
    for (let item = 0; item < quantityInputs.length; item++) {
        let quantity = parseInt(quantityInputs[item].value)
        let price = parseFloat(priceInputs[item].value)
        //if quantity and price are filled out add to total so we don't get NaN
        if (!isNaN(quantity) && !isNaN(price)) {
            cost += quantity * price
        }
    }
    document.getElementById("invoicePriceDisplay").innerHTML = `Total : ${cost == 0 ? "---" : cost.toLocaleString("en-US", {
        style: "currency",
        currency: "usd"
    })}`
}
function submitForm() {
    let formSucessEl = document.querySelector("#submitStatus")
    let allFilled = true
    document.querySelectorAll("input").forEach((inp) => { allFilled = allFilled && (inp.value != "") })
    allFilled = allFilled && document.querySelector("textArea").value!=""
    if (allFilled) {
        let userNotFoundEl = document.querySelector("#userNotFoundErr")
        userNotFoundEl.classList.add("hide")
        formSucessEl.innerHTML=""
        formSucessEl.classList.add("hide")
        let form = document.querySelector("form")
        let data = new FormData(form)
        console.log(form.action)
        fetch(form.action, {
            method: form.method,
            body: data,
        }).then(res => res.json())
            .then(json => {
                if (json.error == "EMAIL_NOT_FOUND") {
                    userNotFoundEl.classList.remove("hide")
                }
                if (json.success == "true") {
                    formSucessEl.innerHTML="Invoice Created"
                    formSucessEl.classList.remove("errorText")
                    formSucessEl.classList.remove("hide")
                }
            })
    } else {
        formSucessEl.classList.add("errorText")
        formSucessEl.innerHTML="Fill out all fields"
    }
}
addItemToForm()

//swap between placeholder and label to save space on mobile
function useLabels(useLabels) {
    let qtyLabels = document.querySelectorAll("label[for=quantity]")
    let pricesLabels = document.querySelectorAll("label[for=price]")
    let descriptionsLabels = document.querySelectorAll("label[for=description]")
    let quantityInputs = document.querySelectorAll(".quantityInput")
    let priceInputs = document.querySelectorAll(".priceInput")
    let descriptionsInputs = document.querySelectorAll(".descriptionInput")

    for (i = 0; i < qtyLabels.length; i++) {
        qtyLabels[i].innerHTML = useLabels ? "Quantity: " : ""
        pricesLabels[i].innerHTML = useLabels ? "Price: " : ""
        descriptionsLabels[i].innerHTML = useLabels ? "Description: " : ""
        quantityInputs[i].placeholder = useLabels ? "" : "qty"
        priceInputs[i].placeholder = useLabels ? "" : "price"
        descriptionsInputs[i].placeholder = useLabels ? "" : "description"
    }
}

window.onresize = window.onload = _ => { useLabels(window.innerWidth > 700); }
